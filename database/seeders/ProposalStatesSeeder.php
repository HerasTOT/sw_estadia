<?php

namespace Database\Seeders;

use App\Models\ProposalStates;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProposalStates::create(['state' => 'Aprobado']);
        ProposalStates::create(['state' => 'Pendiente']);
        ProposalStates::create(['state' => 'Enviado para Validar']);
        ProposalStates::create(['state' => 'Rechazado']);
    }
}
