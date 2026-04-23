<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INSCRIPTION
    | Crée un compte et retourne un Bearer Token
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'password'  => $request->password,
            'role'      => 'client',
            'actif'     => true,
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'message' => 'Inscription réussie !',
            'token'   => $token,
            'user'    => [
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'telephone' => $user->telephone,
                'role'      => $user->role,
                'avatar'    => $user->avatar ? asset('storage/' . $user->avatar) : null,
            ],
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | CONNEXION
    | Vérifie les identifiants et retourne un Bearer Token
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect.',
            ], 401);
        }

        $user = Auth::user();

        if (!$user->actif) {
            Auth::logout();
            return response()->json([
                'message' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
            ], 403);
        }

        $user->tokens()->delete();
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie !',
            'token'   => $token,
            'user'    => [
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'telephone' => $user->telephone,
                'role'      => $user->role,
                'avatar'    => $user->avatar ? asset('storage/' . $user->avatar) : null,
            ],
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DÉCONNEXION
    | Révoque le token actuel
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | MOT DE PASSE OUBLIÉ
    | Envoie un email de réinitialisation
    |--------------------------------------------------------------------------
    */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Un lien de réinitialisation a été envoyé à votre email.',
            ], 200);
        }

        return response()->json([
            'message' => 'Aucun compte trouvé avec cette adresse email.',
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | PROFIL
    | Retourne les infos de l'utilisateur connecté
    |--------------------------------------------------------------------------
    */
    public function profil(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'telephone'  => $user->telephone,
                'role'       => $user->role,
                'avatar'     => $user->avatar ? asset('storage/' . $user->avatar) : null,
                'created_at' => $user->created_at->format('d/m/Y'),
            ],
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | METTRE À JOUR L'AVATAR
    | Formats acceptés : JPEG, JPG, PNG, WEBP — max 2 Mo
    |--------------------------------------------------------------------------
    */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'avatar.required' => 'Veuillez sélectionner une image.',
            'avatar.image'    => 'Le fichier doit être une image.',
            'avatar.mimes'    => 'Formats acceptés : JPEG, JPG, PNG, WEBP.',
            'avatar.max'      => 'L\'image ne doit pas dépasser 2 Mo.',
        ]);

        $user = $request->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return response()->json([
            'message' => 'Avatar mis à jour avec succès !',
            'avatar'  => asset('storage/' . $path),
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFIER LE PROFIL
    | Modifier nom, email et téléphone
    |--------------------------------------------------------------------------
    */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
        ], [
            'email.unique' => 'Cette adresse email est déjà utilisée.',
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'telephone' => $request->telephone,
        ]);

        return response()->json([
            'message' => 'Profil mis à jour avec succès !',
            'user'    => [
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'telephone' => $user->telephone,
                'role'      => $user->role,
                'avatar'    => $user->avatar ? asset('storage/' . $user->avatar) : null,
            ],
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER LE COMPTE
    | Supprime définitivement le compte après confirmation du mot de passe
    |--------------------------------------------------------------------------
    */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ], [
            'password.required' => 'Veuillez confirmer votre mot de passe.',
        ]);

        $user = $request->user();

        // Vérifier le mot de passe avant suppression
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Mot de passe incorrect.',
            ], 401);
        }

        // Révoquer tous les tokens
        $user->tokens()->delete();

        // Supprimer l'avatar si existant
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Supprimer définitivement le compte
        $user->delete();

        return response()->json([
            'message' => 'Votre compte a été supprimé définitivement.',
        ], 200);
    }
}