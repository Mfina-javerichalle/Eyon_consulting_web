<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Mettre à jour l'avatar du client
     *
     * CORRECTION PRODUCTION :
     * Utilise Storage::disk('public') pour que les fichiers soient
     * accessibles via asset('storage/avatars/...')
     * OBLIGATOIRE sur le serveur : php artisan storage:link
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'avatar.required' => 'Veuillez sélectionner une image.',
            'avatar.image'    => 'Le fichier doit être une image.',
            'avatar.mimes'    => 'Format accepté : jpeg, png, jpg, webp.',
            'avatar.max'      => 'L\'image ne doit pas dépasser 2 Mo.',
        ]);

        $user = Auth::user();

        // Supprimer l'ancien avatar s'il existe dans le storage
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Stocker le nouvel avatar dans storage/app/public/avatars/
        // Chemin stocké en base : "avatars/fichier.jpg"
        // Vue : asset('storage/' . $user->avatar) ✓
        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        return redirect()->route('client.dashboard')
            ->with('success', 'Photo de profil mise à jour avec succès !');
    }
 
    /**
     * Mettre à jour les informations du profil client
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
        ], [
            'name.required'  => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.unique'   => 'Cet email est déjà utilisé.',
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('client.dashboard')
            ->with('profile_success', 'Profil mis à jour avec succès !');
    }
}