<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfil = Role::where('name', 'Admin')->first();
        $user = Role::where('name', 'Alumno')->first();

        

        // Cobertura de visibilidad completa
        
        $user->givePermissionTo(Permission::where('name','academico.index')->get());
        $user->givePermissionTo(Permission::where('name','academico.store')->get());
        $user->givePermissionTo(Permission::where('name','academico.update')->get());
        $user->givePermissionTo(Permission::where('name','academico.delete')->get());

        $perfil->givePermissionTo(Permission::where('module_key', 'modulo')->get());
        
        $user->givePermissionTo(Permission::where('name','academico.update')->get());
        $perfil->givePermissionTo(Permission::where('module_key', 'cat')->get());

       /*  $cap->givePermissionTo(Permission::where('name', 'modulo.catalogos')->get());
        $cap->givePermissionTo(Permission::where('name', 'convocatoria.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'evento.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'calendario.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'modulo.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'permissions.index')->get()); */
    }
}
