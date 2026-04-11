<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Mettre à jour l'avatar de l'administrateur
     * Le fichier est stocké dans storage/app/public/avatars/
     * et accessible via public/storage/avatars/
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

        // Supprimer l'ancien avatar s'il existe
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Stocker le nouvel avatar
        // Le nom du fichier est unique grâce au timestamp
        $path = $request->file('avatar')->store('avatars', 'public');

        // Mettre à jour le chemin dans la base de données
        $user->update(['avatar' => $path]);

        return redirect()->back()
            ->with('password_success', 'Photo de profil mise à jour avec succès !');
    }

    /**
     * Mettre à jour les informations du profil admin
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

        return redirect()->back()
            ->with('password_success', 'Profil mis à jour avec succès !');
    }
}