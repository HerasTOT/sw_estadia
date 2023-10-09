<?php

namespace App\Http\Controllers;

use App\Models\Assestment_Criteria;
use App\Http\Requests\StoreAssestment_CriteriaRequest;
use App\Http\Requests\UpdateAssestment_CriteriaRequest;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class AssestmentCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected string $routeName;
    protected string $source;
    protected string $module = 'assesstments';
    protected Assestment_Criteria $model;

    public function __construct()
    {   
        $this->routeName = "assesstment.";
        $this->source    = "Assesstment/";
        $this->model     = new Assestment_Criteria();
        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }

    public function index(Request $request): Response
    {
        $records = $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('value', 'LIKE', "%$search%");
            }
        })->paginate(5)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Criterios de evaluacion',
            'assesstments'        => $records,
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
            'status'         => (bool) $request->status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'titulo' => 'Agregar Criterio de Evaluacion',
            'routeName' => $this->routeName,
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAssestment_CriteriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssestment_CriteriaRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Criterio guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assestment_Criteria  $assestment_Criteria
     * @return \Illuminate\Http\Response
     */
    public function show(Assestment_Criteria $assestment_Criteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assestment_Criteria  $assestment_Criteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Assestment_Criteria $assesstment)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Permisos',
            'routeName'      => $this->routeName,
            'assesstment' => $assesstment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssestment_CriteriaRequest  $request
     * @param  \App\Models\Assestment_Criteria  $assestment_Criteria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssestment_CriteriaRequest $request, Assestment_Criteria $assesstment)
    {
        $assesstment->update($request->validated());
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Criterio editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assestment_Criteria  $assestment_Criteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assestment_Criteria $assesstment)
    {
        $assesstment->delete();
    return redirect()->route("{$this->routeName}index")->with('success', 'Criterio eliminado con éxito');
    }
}
