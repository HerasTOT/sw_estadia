<?php

namespace Database\Seeders;

use App\Models\Township;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Township::create(['name' => 'Township-1', 'state_id' => '1']);
        Township::create(['name' => 'Township-2', 'state_id' => '2']);
        Township::create(['name' => 'Township-3', 'state_id' => '3']);

    }
}
