<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Colony;
use App\Models\Events;
use App\Models\Institutions;
use App\Models\Township;
use App\Models\Workplace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert(['curp' => 'GOPE011110HNEMNRA8', 'name' => 'ERICK JOSUE', 'paternal_surname' => 'GOMEZ', 'maternal_surname' => 'PINEDA', 'email' => 'ashgomez4@gmail.com', 'email_verified_at' => '2023-03-14 04:50:32', 'password' => Hash::make('Password'), 'colony_id' => '1', 'workplace_id' => '2',]);
        DB::table('users')->insert(['curp' => 'NUOR001129HGRXRBA4', 'name' => 'JOSE ROBERTO', 'paternal_surname' => 'NUÑEZ', 'maternal_surname' => 'ORTIZ', 'email' => 'josuezerod@gmail.com', 'email_verified_at' => '2023-03-14 04:50:32', 'password' => Hash::make('28219436'), 'colony_id' => '1', 'workplace_id' => '2',]);
        DB::table('users')->insert(['curp' => 'PIGD690806MNENML05', 'name' => 'DILIA DEL CARMEN', 'paternal_surname' => 'PINEDA', 'maternal_surname' => 'DE GOMEZ', 'email' => 'lalatinajapon4@gmail.com', 'email_verified_at' => '2023-03-14 04:50:32', 'password' => Hash::make('28219436'), 'colony_id' => '1', 'workplace_id' => '2',]);
        DB::table('users')->insert(['curp' => 'TAGC011026HMSBZHA1', 'name' => 'CHRISTIAN ARMANDO', 'paternal_surname' => 'TABOADA', 'maternal_surname' => 'GUZMAN', 'email' => 'royer.cj717@gmail.com', 'email_verified_at' => '2023-03-14 04:50:32', 'password' => Hash::make('28219436'), 'colony_id' => '1', 'workplace_id' => '2',]);

        $this->call([
            RoleSeeder::class,
            WorkplaceSeeder::class,
            StateSeeder::class,
            TownshipSeeder::class,
            ColonySeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            ProposalStatesSeeder::class,
            AreasKnowledgeSeeder::class,
            EventsSeeder::class,
            InstitutionsSeeder::class

        ]);

        User::find(1)->assignRole('Admin');
        User::find(2)->assignRole('Postulante');
        User::find(3)->assignRole('Evaluador');
        User::find(4)->assignRole('Evaluador');


    }
}
