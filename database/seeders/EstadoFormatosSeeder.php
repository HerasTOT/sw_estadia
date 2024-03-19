<?php

namespace Database\Seeders;

use App\Models\EstadoFormatos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoFormatosSeeder extends Seeder
{
    
    public function run()
    {
        EstadoFormatos::create(['nombre' => 'Analisis academico','formato' => '1', 'estado' => '1']);
        EstadoFormatos::create(['nombre' => 'Habitos de estudio', 'formato' => '2','estado' => '1']);
        EstadoFormatos::create(['nombre' => 'Inteligencias multiples', 'formato' => '3','estado' => '1']);
    }
}
