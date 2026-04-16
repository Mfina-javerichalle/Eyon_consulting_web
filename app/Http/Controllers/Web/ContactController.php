<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Affiche la page de contact
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Traite l'envoi du formulaire de contact
     *
     * POURQUOI ÇA NE MARCHAIT PAS EN LIGNE :
     * Mailtrap capture les emails en local mais ne les envoie JAMAIS
     * vers de vraies boîtes mail. En production il faut un vrai SMTP.
     *
     * SOLUTION — configurer le .env avec un vrai service :
     *
     * Option A — Gmail :
     *   MAIL_MAILER=smtp
     *   MAIL_HOST=smtp.gmail.com
     *   MAIL_PORT=587
     *   MAIL_USERNAME=elyonconsulting242@gmail.com
     *   MAIL_PASSWORD=xxxx xxxx xxxx xxxx  ← mot de passe d'application Google
     *   MAIL_ENCRYPTION=tls
     *   MAIL_FROM_ADDRESS=elyonconsulting242@gmail.com
     *   MAIL_FROM_NAME="Elyon Consulting"
     *
     */
    public function send(Request $request)
    {
        // ── Validation avec messages personnalisés ──
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.required'    => 'Le nom est obligatoire.',
            'email.required'   => 'L\'email est obligatoire.',
            'email.email'      => 'L\'email n\'est pas valide.',
            'subject.required' => 'Le sujet est obligatoire.',
            'message.required' => 'Le message est obligatoire.',
            'message.min'      => 'Le message doit contenir au moins 10 caractères.',
        ]);

        // ── Envoi de l'email avec mise en forme HTML ──
        try {
            Mail::send([], [], function ($mail) use ($request) {
                $mail->to(config('mail.from.address'))
                     ->replyTo($request->email, $request->name)
                     ->subject('[Contact Elyon] ' . $request->subject . ' — ' . $request->name)
                     ->html(
                         '<div style="font-family:sans-serif;max-width:600px;margin:auto;padding:20px;">' .
                         '<h2 style="color:#0a2463;border-bottom:2px solid #e2e8f0;padding-bottom:12px;">' .
                             ' Nouveau message depuis le site' .
                         '</h2>' .
                         '<table style="width:100%;border-collapse:collapse;margin-bottom:20px;">' .
                             '<tr><td style="padding:8px 0;color:#64748b;width:140px;">Nom</td>' .
                                 '<td style="padding:8px 0;font-weight:600;">' . e($request->name) . '</td></tr>' .
                             '<tr><td style="padding:8px 0;color:#64748b;">Email</td>' .
                                 '<td style="padding:8px 0;font-weight:600;">' . e($request->email) . '</td></tr>' .
                             '<tr><td style="padding:8px 0;color:#64748b;">Téléphone</td>' .
                                 '<td style="padding:8px 0;font-weight:600;">' . e($request->phone ?? 'Non renseigné') . '</td></tr>' .
                             '<tr><td style="padding:8px 0;color:#64748b;">Sujet</td>' .
                                 '<td style="padding:8px 0;font-weight:600;">' . e($request->subject) . '</td></tr>' .
                         '</table>' .
                         '<div style="background:#f1f5f9;border-radius:10px;padding:16px;">' .
                             '<p style="color:#64748b;font-size:0.85rem;margin:0 0 8px;">Message :</p>' .
                             '<p style="margin:0;line-height:1.7;">' . nl2br(e($request->message)) . '</p>' .
                         '</div>' .
                         '<hr style="border:none;border-top:1px solid #e2e8f0;margin:20px 0;">' .
                         '<p style="font-size:0.75rem;color:#94a3b8;">Envoyé depuis elyon-consulting.com</p>' .
                         '</div>'
                     );
            });

            return redirect()->route('contact')
                ->with('contact_success', 'Votre message a bien été envoyé ! Notre équipe vous répondra sous 24h.');

        } catch (\Exception $e) {
            // En cas d'erreur SMTP, on log sans bloquer l'utilisateur
            \Log::error('Erreur envoi email contact : ' . $e->getMessage());

            return redirect()->route('contact')
                ->with('contact_success', 'Votre message a bien été reçu ! Notre équipe vous répondra sous 24h.');
        }
    }
}