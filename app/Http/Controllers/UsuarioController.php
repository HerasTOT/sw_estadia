<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Profesor;
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

        $alumnos = Alumno::with('user')->get();
        $profesores = Profesor::with('user')->get();
        $usuarios = $this->model::with('roles')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

           

        return Inertia::render("{$this->source}Index", [
            'titulo'   => ' Usuarios',
            'usuarios' => $usuarios,
            'alumnos' => $alumnos,
            'profesores' => $profesores,
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
            'role' => $request->input('role'),
            
            
        ])->assignRole($request['role']);
      

        return redirect()->route("usuarios.index")->with('message', 'materia generado con éxito');
  
    }

    

   

   
    public function edit($id)
    {
        $usuario = User::find($id);
    
        // Obtén el alumno específico relacionado con este usuario
        $alumno = Alumno::where('user_id', $id)->first();
    
        // Asegúrate de manejar el caso en que no se encuentre el usuario o el alumno
        if (!$usuario || !$alumno) {
            abort(404, 'Usuario o alumno no encontrado');
        }
    
        return Inertia::render("Seguridad/Usuarios/Edit", [
            'titulo'   => 'Modificar Usuario',
            'usuario'  => $usuario,
            'alumno'   => $alumno,
            'routeName'=> $this->routeName,
        ]);
    }

    public function update(UpdateUsuarioRequest $request, $id)
    {
        $usuario = User::find($id);
    
        if (!$usuario) {
            abort(404, 'Usuario no encontrado');
        }
    
        // Actualiza los datos del usuario
        $usuario->update($request->all());
    
        // Obtén el alumno relacionado con este usuario
        $alumno = Alumno::where('user_id', $usuario->id)->first();
    
        if ($alumno) {
            // Actualiza los datos del alumno si existe
            $alumno->update([
                'cuatrimestre' => $request->input('cuatrimestre'),
                'matricula'    => $request->input('matricula'),
                // Otros campos del alumno
            ]);
        }
    
        return redirect()->route("usuarios.index")->with('message', 'Usuario y alumno actualizados correctamente!');
    
    }

    

    public function destroy($alumnoId)
    {
        $alumno = Alumno::find($alumnoId);
        $usuario = User::find($alumno->user_id);
        $alumno->delete();

        if ($usuario) {
            // Elimina al usuario
            $usuario->delete();
        }

        // Finalmente, elimina al alumno
        
    return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado con éxito');

    
    }

}