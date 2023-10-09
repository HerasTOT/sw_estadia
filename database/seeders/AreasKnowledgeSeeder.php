<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Areas_knowledge;

class AreasKnowledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Areas_knowledge::create(['name' => 'Física, Matemáticas y Ciencias de la Tierra', 'status' => '1']);
        Areas_knowledge::create(['name' => 'Biología y Química','status' => '1']);
        Areas_knowledge::create(['name' => 'Medicina y Salud','status' => '1']);
        Areas_knowledge::create(['name' => 'Biotecnología y Ciencias Agropecuarias','status' => '1']);
        Areas_knowledge::create(['name' => 'Tecnología 4.0','status' => '1']);
        Areas_knowledge::create(['name' => 'Ingeniería e Industria','status' => '1']);
        Areas_knowledge::create(['name' => 'Ciencias Sociales','status' => '1']);
    }
}
