<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INSCRIPTION
    |--------------------------------------------------------------------------
    */

    /**
     * Traite le formulaire d'inscription depuis le modal
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'password'  => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Le nom est obligatoire.',
            'email.required'     => 'L\'adresse email est obligatoire.',
            'email.email'        => 'L\'adresse email n\'est pas valide.',
            'email.unique'       => 'Cette adresse email est déjà utilisée.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'password'  => $request->password,
            'role'      => 'client',
            'actif'     => true,
        ]);

        Auth::login($user);

        return redirect()->route('client.dashboard')
            ->with('success', 'Bienvenue ' . $user->name . ' ! Votre compte a été créé avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | CONNEXION
    |--------------------------------------------------------------------------
    */

    /**
     * Traite le formulaire de connexion depuis le modal
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'L\'adresse email est obligatoire.',
            'email.email'       => 'L\'adresse email n\'est pas valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (!Auth::user()->actif) {
                Auth::logout();
                return redirect()->route('home')
                    ->with('login_error', 'Votre compte a été désactivé. Contactez l\'administrateur.');
            }

            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return redirect()->route('home')
            ->with('login_error', 'Email ou mot de passe incorrect.');
    }

    /*
    |--------------------------------------------------------------------------
    | DÉCONNEXION
    |--------------------------------------------------------------------------
    */

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | MOT DE PASSE OUBLIÉ
    |--------------------------------------------------------------------------
    */

    /**
     * Affiche la page "Mot de passe oublié"
     */
    public function showForgotPassword()
    {
        // Si déjà connecté, rediriger
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.forgot-password');
    }

    /**
     * Envoie le lien de réinitialisation par email
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email'    => 'L\'adresse email n\'est pas valide.',
        ]);

        // Laravel envoie automatiquement l'email avec le token
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
        }

        return back()->withErrors(['email' => 'Aucun compte trouvé avec cette adresse email.']);
    }

    /*
    |--------------------------------------------------------------------------
    | RÉINITIALISATION DU MOT DE PASSE
    |--------------------------------------------------------------------------
    */

    /**
     * Affiche la page de réinitialisation avec le token
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Traite la réinitialisation du mot de passe
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required'     => 'L\'adresse email est obligatoire.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        // Laravel vérifie le token et met à jour le mot de passe
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('home')
                ->with('success', 'Mot de passe réinitialisé avec succès ! Vous pouvez maintenant vous connecter.');
        }

        return back()->withErrors(['email' => 'Le lien est invalide ou expiré. Veuillez recommencer.']);
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFICATION MOT DE PASSE (depuis le profil)
    |--------------------------------------------------------------------------
    */

    /**
     * Modifie le mot de passe depuis la page profil
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'password.required'         => 'Le nouveau mot de passe est obligatoire.',
            'password.min'              => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'        => 'Les mots de passe ne correspondent pas.',
        ]);

        // Vérifier que le mot de passe actuel est correct
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.'
            ]);
        }

        // Mettre à jour le mot de passe
        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès !');
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTHODE UTILITAIRE
    |--------------------------------------------------------------------------
    */

    /**
     * Redirige selon le rôle de l'utilisateur
     */
    private function redirectByRole()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('client.dashboard');
    }
}