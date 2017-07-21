<?php

use App\Models\Assembly;
use Illuminate\Database\Seeder;

class AssembliesSeeder extends Seeder
{
    /**
     * Seed the database.
     *
     * @return void
     */
    public function run()
    {
        // Create two assemblies.
        Assembly::create([
            'id' => 'k',
            'name_en' => 'Chamber of Representatives',
            'name_fr' => 'Chambre des représentants',
            'name_nl' => 'Kamer van Volksvertegenwoordigers',
        ]);
        Assembly::create([
            'id' => 's',
            'name_en' => 'Senate',
            'name_fr' => 'Sénat',
            'name_nl' => 'Senaat',
        ]);
    }
}
