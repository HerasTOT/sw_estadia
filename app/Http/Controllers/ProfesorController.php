<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Http\Requests\StoreProfesorRequest;
use App\Http\Requests\UpdateProfesorRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;

class ProfesorController extends Controller
{
    private Profesor $model;
    private string $routeName;
    private string $source;
    private string $module = 'profesor';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Profesor/';
        $this->model = new Profesor();
        $this->routeName = 'profesor.';
   }


     public function index(Request $request): Response
    {
        $usuarios = User::all();
         $Profesor = $this->model;
        $Profesor = $Profesor->when($request->search, function ($query, $search) {
            if ($search != '') {
                    $query->where('name',          'LIKE', "%$search%");
                    $query->orWhere('status', 'LIKE', "%$search%");
                }
            })->paginate(10)->withQueryString();
    
            return Inertia::render("Profesor/Index", [
                'titulo'      => 'Profesor  ',
                'Profesor'    => $Profesor,
                'usuarios' =>$usuarios,
                'routeName'      => $this->routeName,
                'loadingResults' => false
            ]);
    }


   
    public function create()
    {
        $usuarios = User::all();
        return Inertia::render("Profesor/Create", [
            'titulo'      => 'Agregar profesor',
            'routeName'      => $this->routeName,
            'usuarios'  => $usuarios,
        ]);
    }

    public function store(StoreProfesorRequest $request)
    {
        $user_id = $request->input('user_id');
       
        Profesor::create([
             'grado_academico' => $request->input('grado_academico'),
             'area' => $request->input('area'),
             'user_id' => $user_id,
     
         ]);
       
 
         return redirect()->route("profesor.index")->with('message', 'Profesor generado con éxito');
   
    }

    public function show(Profesor $profesor)
    {
       
    }

    public function edit(Profesor $profesor)
    {
        return Inertia::render("Profesor/Edit", [
            'titulo'      => 'Modificar Alumno',
            'profesor'    => $profesor,
            'routeName'      => $this->routeName,
        ]);  
    }

    
    public function update(UpdateProfesorRequest $request,$id)
    {
        $profesor = Profesor::find($id);
        $profesor->update($request->all());
        return redirect()->route("profesor.index")->with('message', 'Profesor actualizado correctamente!');
    }

   
    public function destroy($id)
    {
        $profesor = Profesor::find($id);
        $profesor->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Profesor eliminada con éxito');

    }
}
