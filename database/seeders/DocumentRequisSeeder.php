<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentRequis;

class DocumentRequisSeeder extends Seeder
{
    /**
     * Insertion des documents requis pour chaque service
     * Les IDs des services correspondent à l'ordre d'insertion du ServiceSeeder
     * Service 1 = Études en France, 2 = Études au Canada, etc.
     */
    public function run(): void
    {
        $documents = [
            // Service 1 — Études en France
            ['service_id' => 1, 'nom' => 'Passeport valide au moins 6 mois', 'obligatoire' => true],
            ['service_id' => 1, 'nom' => 'Bulletins et relevés académiques', 'obligatoire' => true],
            ['service_id' => 1, 'nom' => 'Lettre de motivation', 'obligatoire' => true],
            ['service_id' => 1, 'nom' => 'CV ou résumé', 'obligatoire' => true],
            ['service_id' => 1, 'nom' => 'Preuve de logement ou hébergement', 'obligatoire' => true],

            // Service 2 — Études au Canada
            ['service_id' => 2, 'nom' => 'Passeport valide au moins 6 mois', 'obligatoire' => true],
            ['service_id' => 2, 'nom' => 'Bulletins scolaires ou diplômes', 'obligatoire' => true],
            ['service_id' => 2, 'nom' => 'Preuve de fonds pour études', 'obligatoire' => true],
            ['service_id' => 2, 'nom' => 'Lettre d\'admission provisoire ou acceptation', 'obligatoire' => true],
            ['service_id' => 2, 'nom' => 'CV ou résumé', 'obligatoire' => true],

            // Service 3 — Études en Belgique
            ['service_id' => 3, 'nom' => 'Passeport valide (au moins 6 mois)', 'obligatoire' => true],
            ['service_id' => 3, 'nom' => 'Relevés académiques / diplômes', 'obligatoire' => true],
            ['service_id' => 3, 'nom' => 'Lettre d\'admission de l\'établissement', 'obligatoire' => true],
            ['service_id' => 3, 'nom' => 'Certificat médical', 'obligatoire' => true],

            // Service 4 — Études au Luxembourg
            ['service_id' => 4, 'nom' => 'Passeport valide', 'obligatoire' => true],
            ['service_id' => 4, 'nom' => 'Diplômes et relevés de notes', 'obligatoire' => true],
            ['service_id' => 4, 'nom' => 'Lettre d\'admission ou attestation d\'inscription', 'obligatoire' => true],
            ['service_id' => 4, 'nom' => 'Preuves financières pour séjour', 'obligatoire' => true],

            // Service 5 — Visa Tourisme France
            ['service_id' => 5, 'nom' => 'Passeport valide au moins 6 mois', 'obligatoire' => true],
            ['service_id' => 5, 'nom' => 'Formulaire de demande de visa Schengen rempli', 'obligatoire' => true],
            ['service_id' => 5, 'nom' => 'Justificatifs financiers', 'obligatoire' => true],
            ['service_id' => 5, 'nom' => 'Preuve d\'hébergement', 'obligatoire' => true],

            // Service 6 — Visa Tourisme Canada
            ['service_id' => 6, 'nom' => 'Passeport valide (min. 6 mois)', 'obligatoire' => true],
            ['service_id' => 6, 'nom' => 'Bulletins académiques', 'obligatoire' => true],
            ['service_id' => 6, 'nom' => 'Preuve de fonds suffisants', 'obligatoire' => true],
            ['service_id' => 6, 'nom' => 'Lettre d\'admission', 'obligatoire' => false],

            // Service 7 — Visa Tourisme USA
            ['service_id' => 7, 'nom' => 'Passeport valide 6+ mois', 'obligatoire' => true],
            ['service_id' => 7, 'nom' => 'Formulaire DS-160 imprimé', 'obligatoire' => true],
            ['service_id' => 7, 'nom' => 'Confirmation rendez-vous visa', 'obligatoire' => true],
            ['service_id' => 7, 'nom' => 'Preuves financières', 'obligatoire' => true],
            ['service_id' => 7, 'nom' => 'Itinéraire / billets', 'obligatoire' => true],
            ['service_id' => 7, 'nom' => 'Photo conforme aux normes USA', 'obligatoire' => true],
        ];

        foreach ($documents as $document) {
            DocumentRequis::create($document);
        }
    }
}