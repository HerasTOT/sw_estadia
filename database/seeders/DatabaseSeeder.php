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

        DB::table('users')->insert(['name' => 'Santiago', 'apellido_paterno' => 'Heras', 'apellido_materno' => 'Gomez','numero' => '7775420768', 'email' => 'admin@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('Password'), 'role' =>'Admin']);
        DB::table('users')->insert(['name' => 'Miguel', 'apellido_paterno' => 'roman', 'apellido_materno' => 'Chano','numero' => '7772052238', 'email' => 'miguel@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('Password'), 'role' =>'Alumno']);

        /*
        DB::table('users')->insert(['curp' => 'NUOR001129HGRXRBA4', 'name' => 'JOSE ROBERTO', 'paternal_surname' => 'NUÑEZ', 'maternal_surname' => 'ORTIZ', 'email' => 'josuezerod@gmail.com', 'email_verified_at' => '2023-03-14 04:50:32', 'password' => Hash::make('28219436'), 'colony_id' => '1', 'workplace_id' => '2',]);
        DB::table('users')->insert(['curp' => 'PIGD690806MNENML05', 'name' => 'DILIA DEL CARMEN', 'paternal_surname' => 'PINEDA', 'maternal_surname' => 'DE GOMEZ', 'email' => 'lalatinajapon4@gmail.com', 'email_verified_at' => '2023-03-14 04:50:32', 'password' => Hash::make('28219436'), 'colony_id' => '1', 'workplace_id' => '2',]);
        DB::table('users')->insert(['curp' => 'TAGC011026HMSBZHA1', 'name' => 'CHRISTIAN ARMANDO', 'paternal_surname' => 'TABOADA', 'maternal_surname' => 'GUZMAN', 'email' => 'royer.cj717@gmail.com', 'email_verified_at' => '2023-03-14 04:50:32', 'password' => Hash::make('28219436'), 'colony_id' => '1', 'workplace_id' => '2',]);
        */
        $this->call([
            RoleSeeder::class,
           
            
            PermissionSeeder::class,
            AdminSeeder::class,
            
            InstitutionsSeeder::class,
            MateriaSeeder::class,
            PreguntaSeeder::class,

        ]);

        User::find(1)->assignRole('Admin');
        User::find(2)->assignRole('Alumno');


    }
}
