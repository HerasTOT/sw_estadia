<?php

namespace Database\Seeders;

use App\Models\Events;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Events::create(['name' => 'Publicación de convocatoria']);
        Events::create(['name' => 'Captura de proyectos']);
        Events::create(['name' => 'Evalucación de proyectos']);
        Events::create(['name' => 'Cierre de convocatoria']);

    }
}
