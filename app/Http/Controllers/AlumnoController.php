<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;
class AlumnoController extends Controller
{
    private Alumno $model;
    private string $routeName;
    private string $source;
    private string $module = 'alumno';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Alumno/';
        $this->model = new Alumno();
        $this->routeName = 'alumno.';
   }

   public function index(Request $request): Response
    {
        $usuarios = User::all();
        $Alumno = $this->model;
        $alumnos = Alumno::with('usuario')->get();

        $Alumno = $Alumno::with('usuario') 
        ->when($request->search, function ($query, $search){
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("Alumno/Index", [
            'titulo'      => 'Alumnos  ',
            'Alumno'    => $Alumno,
            'usuarios' =>$usuarios,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = User::all();
        return Inertia::render("Alumno/Create", [
            'titulo'      => 'Agregar alumno',
            'routeName'      => $this->routeName,
            'usuarios'  => $usuarios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAlumnoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlumnoRequest $request)
    {
        $user_id = $request->input('user_id');
       
       Alumno::create([
            'cuatrimestre' => $request->input('cuatrimestre'),
            'matricula' => $request->input('matricula'),
            'user_id' => $user_id,
    
        ]);
      

        return redirect()->route("alumno.index")->with('message', 'Alumno generado con éxito');
  
    }

    
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumno $Alumno)
    {
        return Inertia::render("Alumno/Edit", [
            'titulo'      => 'Modificar Alumno',
            'Alumno'    => $Alumno,
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlumnoRequest  $request
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlumnoRequest $request,$id)
    {
        $Alumno = Alumno::find($id);
        $Alumno->update($request->all());
        return redirect()->route("alumno.index")->with('message', 'Alumno actualizado correctamente!');
}
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Alumno = Alumno::find($id);
        $Alumno->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Alumno eliminada con éxito');

    }
}
