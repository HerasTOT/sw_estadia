<?php

namespace App\Http\Controllers;

use App\Models\Document_Supporting;
use App\Http\Requests\StoreDocument_SupportingRequest;
use App\Http\Requests\UpdateDocument_SupportingRequest;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class DocumentSupportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected string $routeName;
    protected string $source;
    protected string $module = 'document';
    protected Document_Supporting $model;

    public function __construct()
    {
        $this->routeName = "documents.";
        $this->source    = "DocumentSupporting/";
        $this->model     = new Document_Supporting();
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
        })->paginate(5)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Documentacion',
            'documents'        => $records,
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
            'titulo' => 'Agregar Soporte',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDocument_SupportingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocument_SupportingRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Permiso guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document_Supporting  $document_Supporting
     * @return \Illuminate\Http\Response
     */
    public function show(Document_Supporting $document_Supporting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document_Supporting  $document_Supporting
     * @return \Illuminate\Http\Response
     */
    public function edit(Document_Supporting $document)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Soporte a documentos',
            'routeName'      => $this->routeName,
            'document' => $document,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDocument_SupportingRequest  $request
     * @param  \App\Models\Document_Supporting  $document_Supporting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocument_SupportingRequest $request, Document_Supporting $document)
    {
        $document->update($request->validated());
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Soporte editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document_Supporting  $document_Supporting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document_Supporting $document)
    {
        $document->delete();
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Soporte eliminado correctamente');
    }
}
