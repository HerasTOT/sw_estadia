<?php

namespace App\Http\Controllers;

use App\Models\Institutions;
use App\Http\Requests\StoreInstitutionsRequest;
use App\Http\Requests\UpdateInstitutionsRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class InstitutionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private string $routeName;
    private Institutions $model;
    private string $module = 'institutions';



    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new Institutions();
        $this->routeName = 'institutions.';
        
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
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(5)->withQueryString();

        return Inertia::render("Institutions/Index", [
            'titulo'      => 'Instituciones',
            'institutions'    => $records,
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
        return Inertia::render("Institutions/Create", [
            'titulo'      => 'Instituciones',
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstitutionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstitutionsRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Registro guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institutions  $institutions
     * @return \Illuminate\Http\Response
     */
    public function show(Institutions $institutions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institutions  $institutions
     * @return \Illuminate\Http\Response
     */
    public function edit(Institutions $institution)
    {
        return Inertia::render("Institutions/Edit", [
            'titulo'      => 'Editar Instituciones',
            'institution'    => $institution,
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstitutionsRequest  $request
     * @param  \App\Models\Institutions  $institutions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstitutionsRequest $request, Institutions $institution)
    {
        $institution->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Instituto actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institutions  $institutions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institutions $institution)
    {
        $institution->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Instituto eliminado con éxito');
    }
}
