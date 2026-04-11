<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Insertion des services proposés par ELYON Consulting
     * 7 services : visas étudiants et touristiques
     */
    public function run(): void
    {
        $services = [
            [
                'nom'         => 'Études en France',
                'pays'        => 'France',
                'description' => 'Procédure complète pour étudier en France',
            ],
            [
                'nom'         => 'Études au Canada',
                'pays'        => 'Canada',
                'description' => 'Procédure pour obtenir un permis d\'étude au Canada',
            ],
            [
                'nom'         => 'Études en Belgique',
                'pays'        => 'Belgique',
                'description' => 'Procédure pour étudier en Belgique',
            ],
            [
                'nom'         => 'Études au Luxembourg',
                'pays'        => 'Luxembourg',
                'description' => 'Procédure pour étudier au Luxembourg',
            ],
            [
                'nom'         => 'Visa Tourisme France',
                'pays'        => 'France',
                'description' => 'Visa touristique espace Schengen',
            ],
            [
                'nom'         => 'Visa Tourisme Canada',
                'pays'        => 'Canada',
                'description' => 'Visa touristique Canada',
            ],
            [
                'nom'         => 'Visa Tourisme USA',
                'pays'        => 'USA',
                'description' => 'Visa touristique USA',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}