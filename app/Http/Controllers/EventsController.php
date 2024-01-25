<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Http\Requests\StoreEventsRequest;
use App\Http\Requests\UpdateEventsRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;


class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private string $routeName;
    private Events $model;
    protected string $source;
    private string $module = 'events';



    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new Events();
        $this->source    = "Events/";
        $this->routeName = 'events.';

        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);
    }
    public function index(Request $request): Response
    {
        $records = $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
            }
        })->paginate(5)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'      => 'Eventos',
            'events'    => $records,
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
        return Inertia::render("{$this->source}Create", [
            'titulo' => 'Agregar Eventos',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventsRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Evento guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function show(Events $events)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function edit(Events $event)
    {
        return Inertia::render("Events/Edit", [
            'titulo'      => 'Editar Instituciones',
            'event'    => $event,
            'routeName'      => $this->routeName,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventsRequest  $request
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventsRequest $request, Events $event)
    {
        $event->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Evento actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function destroy(Events $event)
    {
        $event->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Evento eliminado con éxito');
    }
}
