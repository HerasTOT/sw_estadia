<?php

namespace App\Http\Controllers;

use App\Models\ListaRecursamiento;
use App\Http\Requests\StoreListaRecursamientoRequest;
use App\Http\Requests\UpdateListaRecursamientoRequest;
use App\Models\Recursamiento;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
class ListaRecursamientoController extends Controller
{
    private ListaRecursamiento $model;
    private string $routeName;
    private string $source;
    private string $module = 'academico';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Lista/';
        $this->model = new ListaRecursamiento();
        $this->routeName = 'lista.';

   }
   
   public function index(Request $request): Response
   {
        $user = Auth::user();
        
        $recursamiento= Recursamiento::all();

        
     
       return Inertia::render("Lista/Index", [
           'titulo'      => 'lista de recursamiento',
           'recursamiento' => $recursamiento,
           'routeName'      => $this->routeName,
           
           'loadingResults' => false
       ]);
   }

   public function assignAlumnoRecursamiento(Request $request,$id)
   {
       $user = Auth::user();
       if ($user->role !== 'Alumno') {
        return redirect()->route("{$this->routeName}index")->with('error', 'Solo los alumnos pueden ser asignados a recursamientos.');
    }
       $existingAssignment = ListaRecursamiento::where('user_id', $user->id)
       ->where('recursamiento_id', $id)
       ->first();

   if ($existingAssignment) {
       // Si ya existe la asignación, puedes manejarlo de acuerdo a tus necesidades.
       // Puedes redirigir a una página de error o mostrar un mensaje.
       return redirect()->route("{$this->routeName}index")->with('error', 'El alumno ya está asignado a este recursamiento.');
   }
       ListaRecursamiento::create([
           'user_id' => $user->id,
           'recursamiento_id' => $id,
       ]);
      
   
       return redirect()->route("{$this->routeName}index")->with('success', 'Alumno asignado al grupo con éxito!');
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreListaRecursamientoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListaRecursamientoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListaRecursamiento  $listaRecursamiento
     * @return \Illuminate\Http\Response
     */
    public function show(ListaRecursamiento $listaRecursamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListaRecursamiento  $listaRecursamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaRecursamiento $listaRecursamiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateListaRecursamientoRequest  $request
     * @param  \App\Models\ListaRecursamiento  $listaRecursamiento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateListaRecursamientoRequest $request, ListaRecursamiento $listaRecursamiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListaRecursamiento  $listaRecursamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaRecursamiento $listaRecursamiento)
    {
        //
    }
}
