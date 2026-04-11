<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etape;

class EtapeSeeder extends Seeder
{
    /**
     * Insertion des étapes pour chaque service
     * Chaque étape a un ordre qui détermine sa position dans la progression
     */
    public function run(): void
    {
        $etapes = [
            // Service 1 — Études en France
            ['service_id' => 1, 'nom' => 'Choix de la formation', 'ordre' => 1],
            ['service_id' => 1, 'nom' => 'Choix de l\'établissement', 'ordre' => 2],
            ['service_id' => 1, 'nom' => 'Constitution du dossier académique', 'ordre' => 3],
            ['service_id' => 1, 'nom' => 'Dépôt de candidature', 'ordre' => 4],
            ['service_id' => 1, 'nom' => 'Réception de la lettre d\'admission', 'ordre' => 5],

            // Service 2 — Études au Canada
            ['service_id' => 2, 'nom' => 'Admission dans un établissement canadien (DLI)', 'ordre' => 1],
            ['service_id' => 2, 'nom' => 'Paiement des frais de scolarité', 'ordre' => 2],
            ['service_id' => 2, 'nom' => 'Ouverture d\'un compte bancaire / preuve financière', 'ordre' => 3],
            ['service_id' => 2, 'nom' => 'Dépôt de la demande de permis d\'études', 'ordre' => 4],
            ['service_id' => 2, 'nom' => 'Données biométriques', 'ordre' => 5],
            ['service_id' => 2, 'nom' => 'Visite médicale', 'ordre' => 6],
            ['service_id' => 2, 'nom' => 'Décision IRCC', 'ordre' => 7],
            ['service_id' => 2, 'nom' => 'Préparation du voyage', 'ordre' => 8],

            // Service 3 — Études en Belgique
            ['service_id' => 3, 'nom' => 'Reconnaissance de diplôme', 'ordre' => 1],
            ['service_id' => 3, 'nom' => 'Admission universitaire', 'ordre' => 2],
            ['service_id' => 3, 'nom' => 'Constitution du dossier visa', 'ordre' => 3],
            ['service_id' => 3, 'nom' => 'Dépôt à l\'ambassade / TLS', 'ordre' => 4],
            ['service_id' => 3, 'nom' => 'Enquête administrative', 'ordre' => 5],
            ['service_id' => 3, 'nom' => 'Réception du visa D', 'ordre' => 6],
            ['service_id' => 3, 'nom' => 'Voyage & inscription communale', 'ordre' => 7],

            // Service 4 — Études au Luxembourg
            ['service_id' => 4, 'nom' => 'Reconnaissance de diplôme', 'ordre' => 1],
            ['service_id' => 4, 'nom' => 'Admission universitaire', 'ordre' => 2],
            ['service_id' => 4, 'nom' => 'Demande d\'autorisation de séjour', 'ordre' => 3],
            ['service_id' => 4, 'nom' => 'Réponse favorable', 'ordre' => 4],
            ['service_id' => 4, 'nom' => 'Dépôt visa long séjour', 'ordre' => 5],
            ['service_id' => 4, 'nom' => 'Voyage', 'ordre' => 6],
            ['service_id' => 4, 'nom' => 'Déclaration d\'arrivée + titre de séjour', 'ordre' => 7],

            // Service 5 — Visa Tourisme France
            ['service_id' => 5, 'nom' => 'Préparation du passeport et documents personnels', 'ordre' => 1],
            ['service_id' => 5, 'nom' => 'Remplir le formulaire de visa', 'ordre' => 2],
            ['service_id' => 5, 'nom' => 'Réservation de l\'hôtel ou hébergement', 'ordre' => 3],
            ['service_id' => 5, 'nom' => 'Souscrire une assurance voyage', 'ordre' => 4],
            ['service_id' => 5, 'nom' => 'Réserver le billet d\'avion A/R', 'ordre' => 5],
            ['service_id' => 5, 'nom' => 'Fournir les relevés bancaires des 3 derniers mois', 'ordre' => 6],
            ['service_id' => 5, 'nom' => 'Dépôt du dossier à l\'ambassade / centre visa', 'ordre' => 7],
            ['service_id' => 5, 'nom' => 'Attendre la décision (15 à 30 jours)', 'ordre' => 8],

            // Service 6 — Visa Tourisme Canada
            ['service_id' => 6, 'nom' => 'Passeport valide', 'ordre' => 1],
            ['service_id' => 6, 'nom' => 'Preuve financière', 'ordre' => 2],
            ['service_id' => 6, 'nom' => 'Lettre explicative', 'ordre' => 3],
            ['service_id' => 6, 'nom' => 'Hébergement', 'ordre' => 4],
            ['service_id' => 6, 'nom' => 'Billet A/R', 'ordre' => 5],
            ['service_id' => 6, 'nom' => 'Assurance voyage', 'ordre' => 6],

            // Service 7 — Visa Tourisme USA
            ['service_id' => 7, 'nom' => 'Passeport valide', 'ordre' => 1],
            ['service_id' => 7, 'nom' => 'Formulaire DS-160', 'ordre' => 2],
            ['service_id' => 7, 'nom' => 'Rendez-vous consulat prévu', 'ordre' => 3],
            ['service_id' => 7, 'nom' => 'Preuve financière', 'ordre' => 4],
            ['service_id' => 7, 'nom' => 'Lettre explicative', 'ordre' => 5],
            ['service_id' => 7, 'nom' => 'Hébergement et billet A/R', 'ordre' => 6],
            ['service_id' => 7, 'nom' => 'Assurance voyage', 'ordre' => 7],
        ];

        foreach ($etapes as $etape) {
            Etape::create($etape);
        }
    }
}