<?php

namespace Database\Seeders;

use App\Models\Colony;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Colony::create(['name' => 'colony-1', 'postal_code' => '62130', 'township_id' => 1]);
        Colony::create(['name' => 'colony-2', 'postal_code' => '53340', 'township_id' => 2]);
        Colony::create(['name' => 'colony-3', 'postal_code' => '62210', 'township_id' => 3]);
        Colony::create(['name' => 'colony-4', 'postal_code' => '53320', 'township_id' => 2]);
    }
}
