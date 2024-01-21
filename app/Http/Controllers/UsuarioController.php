<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Modulo;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;


class UsuarioController extends Controller
{
    protected string $routeName;
    protected string $source;
    protected string $module = 'usuarios';
    protected User $model;

    public function __construct()
    {
        $this->routeName = "usuarios.";
        $this->source    = "Seguridad/Usuarios/";
        $this->model     = new User();
        // $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        // $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        // $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        // $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }

    public function index(Request $request): Response
    {
        $usuarios = $this->model::with('roles')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();
    
        return Inertia::render("{$this->source}Index", [
            'titulo'   => 'Catálogo de Usuarios',
            'usuarios' => $usuarios,
            'profiles' => Role::get(['id', 'name']),
            'routeName'=> $this->routeName,
            'loadingResults' => false,
        ]);
    }
    
    public function create()
    {
        return Inertia::render("Seguridad/Usuarios/Create", [
            'titulo'      => 'Agregar Usuarios',
            'routeName'      => $this->routeName,
            'roles' => Role::pluck('name'),
        ]);
    }

    public function store(StoreUsuarioRequest $request)
    
    {
        // dd($request);
        $newUser = user::create([
            'name' => $request->input('name'),
            'apellido_paterno' => $request->input('apellido_paterno'),
            'apellido_materno' => $request->input('apellido_materno'),
            'numero' => $request->input('numero'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            //'role' => $request->input('role'),
            'role' => 'no hace nada'
            
        ])->assignRole($request['role']);
      

        return redirect()->route("usuarios.index")->with('message', 'materia generado con éxito');
  
    }

    

   

   

    public function edit( User $User)
    {
        return Inertia::render("Seguridad/Usuarios/Edit", [
            'titulo'      => 'Modificar Usuario',
            'User'    => $User,
            'routeName'      => $this->routeName,
        ]);
    }
    public function update(UpdateUsuarioRequest $request, $id)
    {
        $user = user::find($id);
        $user->update($request->all());
        return redirect()->route("usuarios.index")->with('message', 'Usuario actualizado correctamente!');
}

    

    public function destroy(User $usuarios)
    {
        $usuarios->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado con éxito');
    }

}