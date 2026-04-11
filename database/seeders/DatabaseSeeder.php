<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Lancement de tous les seeders dans l'ordre correct
     * L'ordre est très important à cause des clés étrangères :
     * - Les services doivent exister avant les documents requis
     * - Les services doivent exister avant les étapes
     * - Les services doivent exister avant les infos visa
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,        // 1. D'abord les services
            DocumentRequisSeeder::class, // 2. Ensuite les documents requis
            EtapeSeeder::class,          // 3. Ensuite les étapes
            InfosVisaSeeder::class,      // 4. Enfin les infos visa
        ]);
    }
}