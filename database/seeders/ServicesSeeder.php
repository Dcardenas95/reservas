<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Services::create([
            'name' => 'Limpieza facial',
            'duration' => 90,
        ]);
        Services::create([
            'name' => 'Corte de cabello',
            'duration' => 30,
        ]);
        Services::create([
            'name' => 'Tinturado de cabello',
            'duration' => 180,
        ]);
        Services::create([
            'name' => 'Maquillaje',
            'duration' => 40,
        ]);
    }
}
