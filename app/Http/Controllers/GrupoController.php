<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;
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
        $Grupo = $Grupo->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("Grupo/Index", [
            'titulo'      => 'Grupos de ITI  ',
            'Grupo'    => $Grupo,
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
        return Inertia::render("Grupo/Create", [
            'titulo'      => 'Materia',
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
        Grupo::create([
            'grado' => $request->input('grado'),
            'grupo' => $request->input('grupo'),
            'tutor' => $request->input('tutor'),
            'materia' => $request->input('materia'),
            ]);
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
        return Inertia::render("Grupo/Edit", [
            'titulo'      => 'Modificar materia',
            'Grupo'    => $Grupo,
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
        $Grupo->update($request->all());
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
        $Grupo->delete();
        return redirect()->route("grupo.index")->with('success', 'Materia eliminada con éxito');

 
    }
}
