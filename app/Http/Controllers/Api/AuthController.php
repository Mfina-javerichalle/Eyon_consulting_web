<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

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

        // Créer l'utilisateur
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'password'  => $request->password,
            'role'      => 'client',
            'actif'     => true,
        ]);

        // Générer le Bearer Token Sanctum
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

        // Vérifier les identifiants
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect.',
            ], 401);
        }

        $user = Auth::user();

        // Vérifier que le compte est actif
        if (!$user->actif) {
            Auth::logout();
            return response()->json([
                'message' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
            ], 403);
        }

        // Révoquer les anciens tokens et en créer un nouveau
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
    | Révoque le token actuel — le mobile ne peut plus accéder aux routes protégées
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        // Révoquer uniquement le token utilisé pour cette requête
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | MOT DE PASSE OUBLIÉ
    | Envoie un email de réinitialisation (même système que le web)
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
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'telephone' => $user->telephone,
                'role'      => $user->role,
                'avatar'    => $user->avatar ? asset('storage/' . $user->avatar) : null,
                'created_at'=> $user->created_at->format('d/m/Y'),
            ],
        ], 200);
    }
}