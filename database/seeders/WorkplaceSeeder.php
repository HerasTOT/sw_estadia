<?php

namespace Database\Seeders;

use App\Models\Workplace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Workplace::create(['name' => 'workplace-1','status' => 1]);
        Workplace::create(['name' => 'workplace-2','status' => 1]);
        Workplace::create(['name' => 'workplace-3','status' => 1]);

    }
}
