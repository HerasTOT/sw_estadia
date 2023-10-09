<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepermisosRequest;
use App\Http\Requests\UpdatepermisosRequest;
use Spatie\Permission\Models\Permission;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    protected string $routeName;
    protected string $source;
    protected string $module = 'permissions';
    protected Permission $model;

    public function __construct()
    {
        $this->routeName = "permissions.";
        $this->source    = "Permissions/";
        $this->model     = new Permission();
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
                $query->orWhere('description', 'LIKE', "%$search%");
                $query->orWhere('module_key',  'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Catálogo de Permisos',
            'records'        => $records,
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
            'titulo' => 'Agregar Permisos',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepermisosRequest $request): RedirectResponse
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Permiso guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        abort(405);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission): Response
    {

        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Permisos',
            'routeName'      => $this->routeName,
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepermisosRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        Cache::forget('permissions');
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Permiso editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Permiso eliminado con éxito');
    }
}
