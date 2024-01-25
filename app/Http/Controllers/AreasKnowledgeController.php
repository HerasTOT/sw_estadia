<?php

namespace App\Http\Controllers;

use App\Models\Areas_knowledge;
use App\Http\Requests\StoreAreas_knowledgeRequest;
use App\Http\Requests\UpdateAreas_knowledgeRequest;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AreasKnowledgeController extends Controller
{

    protected string $routeName;
    protected string $source;
    protected string $module = 'thematics';
    protected Areas_knowledge $model;

    public function __construct()
    {
        $this->routeName = "knowledges.";
        $this->source    = "knowledge/";
        $this->model     = new Areas_knowledge();

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
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Areas del Conocimiento',
            'knowledges'        => $records,
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
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
            'titulo' => 'Agregar Areas del conocimiento',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAreas_knowledgeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAreas_knowledgeRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Area guardada con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Areas_knowledge  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function show(Areas_knowledge $knowledge)
    {
        abort(406);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Areas_knowledge  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function edit(Areas_knowledge $knowledge)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Area',
            'routeName'      => $this->routeName,
            'knowledge' => $knowledge,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAreas_knowledgeRequest  $request
     * @param  \App\Models\Areas_knowledge  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAreas_knowledgeRequest $request, Areas_knowledge $knowledge)
    {
        $knowledge->update($request->validated());
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Area editada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Areas_knowledge  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Areas_knowledge $knowledge)
    {
        $knowledge->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Area eliminado con éxito');
    }
}
