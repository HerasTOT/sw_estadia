<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Grupo_Materias;
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;
use App\Models\Grupo_Alumnos;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class GrupoController extends Controller
{
    
    private Grupo $model;
    private string $routeName;
    private string $source;
    private string $module = 'grupo';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Grupo/';
        $this->model = new Grupo();
        $this->routeName = 'grupo.';

        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }

    public function index(Request $request): Response
    {
        $Grupo = $this->model;
        $alumnos = Alumno::all();
        $profesor=Profesor::all();
        $grupos = Grupo::with('materias','profesor.user','alumnos.user')->paginate(10);
        
        $Grupo = $Grupo->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name', 'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->with('materias','profesor.user','alumnos.user')->paginate(10)->withQueryString();
    //dd($grupos);
        
        return Inertia::render("Grupo/Index", [
            'titulo' => 'Grupos de ITI',
            'Grupo' => $Grupo,
            'alumnos' => $alumnos,
            'grupos' => $grupos,
            'profesor'  => $profesor,
            'routeName' => $this->routeName,
            'loadingResults' => false
        ]);
    }
    
  

    public function assignGroupView($id)
    {
        $alumnos = Alumno::whereDoesntHave('grupos')->get();
        $grupo = Grupo::find($id);
        return inertia('Grupo/assignGroup', [
            'titulo' => 'Asignar Alumno a Grupo',
            'alumnos' => $alumnos,
            'grupo' => $grupo,
        ]);
    }

    public function assignAlumno(Request $request)
    {
        
        $alumnoId = $request['alumno_id'];
        $grupoId = $request['grupo_id'];

        Grupo_Alumnos::create([
            'alumno_id' => $alumnoId,
            'grupo_id' => $grupoId,
        ]);
        // $alumno = Alumno::find($alumnoId);
        // $alumno->grupos()->sync([$grupoId]);
    
        return redirect()->route("{$this->routeName}index")->with('success', 'Alumno asignado al grupo con éxito!');
    }

    public function removeAlumno(Request $request)
{
    $alumnoId = $request['alumno_id'];
    $grupoId = $request['grupo_id'];

    // Verificar si el alumno está asignado al grupo
    $relacion = Grupo_Alumnos::where('alumno_id', $alumnoId)->where('grupo_id', $grupoId)->first();

    if (!$relacion) {
        return redirect()->route("{$this->routeName}index")->with('error', 'Este alumno no está asignado a este grupo.');
    }

    // Eliminar la relación
    $relacion->delete();

    return redirect()->route("{$this->routeName}index")->with('success', 'Alumno eliminado del grupo con éxito!');
}
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profesor=Profesor::all();
        $usuarios=User::all();
        return Inertia::render("Grupo/Create", [
            'titulo'      => 'Grupo',
            'profesor'  => $profesor,
            'usuarios'  => $usuarios,
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGrupoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrupoRequest $request)
    {
       
        $profesor_id = User::find($request->input('profesor_id'))->profesor;
        $existingAssignment = Grupo::where('profesor_id', $profesor_id->id)
       
        ->first();
 
    if ($existingAssignment) {
        
        return redirect()->route("{$this->routeName}index")->with('error', 'El profesor ya esta asignado a un grupo');
    }
        $grupo = Grupo::create([
            'grado' => $request->input('grado'),
            'grupo' => $request->input('grupo'),
            'profesor_id' => $profesor_id->id,
        ]);
        $cuatrimestre = $request->input('grado');
        $materias = Materia::where('cuatrimestre', $cuatrimestre)->get();
    
        // Vincular todas las materias al grupo
        foreach ($materias as $materia) {
            Grupo_Materias::create([
                'materia_id' => $materia->id,
                'grupo_id' => $grupo->id,
            ]);
        }
      

        return redirect()->route("grupo.index")->with('message', 'grupo generado con éxito');
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $Grupo= Grupo::find($id);
        $alumnos = Alumno::all();
        $usuarios = User::all();
        return Inertia::render("Grupo/Edit", [
            'titulo'      => 'Modificar grupo',
            'Grupo'    => $Grupo,
            'profesor_id' => $Grupo->profesor_id,
            'alumnos'  => $alumnos,
            'usuarios'  => $usuarios,
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGrupoRequest  $request
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrupoRequest $request, $id)
    {
       
        $Grupo = Grupo::find($id);
        $profesor = User::find($request->input('profesor_id'))->profesor;
    
        $Grupo->update([
            'profesor_id' => $profesor->id,
            'grado' => $request->input('grado'),
            'grupo' => $request->input('grupo'),
        ]);
        $nuevoCuatrimestre = $request->input('grado');
        $nuevasMaterias = Materia::where('cuatrimestre', $nuevoCuatrimestre)->get();
        $Grupo->materias()->detach();
        foreach ($nuevasMaterias as $materia) {
            Grupo_Materias::create([
                'materia_id' => $materia->id,
                'grupo_id' => $Grupo->id,
            ]);
        }

        return redirect()->route("grupo.index")->with('message', 'Grupo actualizado correctamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $Grupo = Grupo::find($id);
        $Grupo->materias()->detach();
        $Grupo->alumnos()->detach();
        $Grupo->delete();
        return redirect()->route("grupo.index")->with('success', 'Materia eliminada con éxito');

 
    }
}
