<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InfosVisa;

class InfosVisaSeeder extends Seeder
{
    /**
     * Insertion des informations visa pour chaque service
     * Délai de traitement, frais, ambassade concernée
     */
    public function run(): void
    {
        $infos = [
            [
                'service_id' => 1,
                'delai'      => '2 à 4 semaines',
                'frais'      => '99€',
                'ambassade'  => 'Campus France / Ambassade de France',
                'notes'      => 'Inscription via Campus France obligatoire pour certains pays',
            ],
            [
                'service_id' => 2,
                'delai'      => '8 à 16 semaines',
                'frais'      => '150 CAD',
                'ambassade'  => 'Ambassade du Canada / IRCC',
                'notes'      => 'Biométrie et visite médicale obligatoires',
            ],
            [
                'service_id' => 3,
                'delai'      => '4 à 8 semaines',
                'frais'      => '180€',
                'ambassade'  => 'Ambassade de Belgique',
                'notes'      => 'Visa long séjour D requis pour plus de 90 jours',
            ],
            [
                'service_id' => 4,
                'delai'      => '4 à 6 semaines',
                'frais'      => '80€',
                'ambassade'  => 'Ambassade du Luxembourg',
                'notes'      => 'Autorisation de séjour à demander avant le visa',
            ],
            [
                'service_id' => 5,
                'delai'      => '15 à 30 jours',
                'frais'      => '80€',
                'ambassade'  => 'Ambassade de France / TLS Contact',
                'notes'      => 'Assurance voyage minimum 30 000€ obligatoire',
            ],
            [
                'service_id' => 6,
                'delai'      => '2 à 4 semaines',
                'frais'      => '100 CAD',
                'ambassade'  => 'Ambassade du Canada',
                'notes'      => 'Autorisation de voyage électronique (AVE) possible',
            ],
            [
                'service_id' => 7,
                'delai'      => '3 à 5 semaines',
                'frais'      => '160 USD',
                'ambassade'  => 'Ambassade des États-Unis',
                'notes'      => 'Formulaire DS-160 à remplir en ligne avant le rendez-vous',
            ],
        ];

        foreach ($infos as $info) {
            InfosVisa::create($info);
        }
    }
}