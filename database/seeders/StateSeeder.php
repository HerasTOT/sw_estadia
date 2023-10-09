<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create(['name' => 'state-1']);
        State::create(['name' => 'state-2']);
        State::create(['name' => 'state-3']);
        State::create(['name' => 'state-4']);
    }
}
