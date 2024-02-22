<?php

namespace App\Http\Controllers;

use App\Models\Recursamiento;
use App\Http\Requests\StoreRecursamientoRequest;
use App\Http\Requests\UpdateRecursamientoRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class RecursamientoController extends Controller
{
    private Recursamiento $model;
    private string $routeName;
    private string $source;
    private string $module = 'recursamiento';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Recursamiento/';
        $this->model = new Recursamiento();
        $this->routeName = 'recursamiento.';

        
    }

    public function index(Request $request): Response
    {
        
        $Recursamiento = $this->model;
        $Recursamiento = $Recursamiento->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("Recursamiento/Index", [
            'titulo'      => 'Gestión de recursamientos y aviso al alumnado del mismo',
            'Recursamiento'    => $Recursamiento,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);



    }
    public function recursamientoDashboard()
    {
    $recursamientos = Recursamiento::all(); // O cualquier consulta que necesites
    return $recursamientos;
    }

    public function welcome()
    {
    $recursamientos = $this->recursamientoDashboard();

    return Inertia::render('Welcome', [
        'recursamientos' => $recursamientos,
    ]);
    }


    public function create()
    {
        return Inertia::render("Recursamiento/Create", [
            'titulo'      => 'Recursamiento',
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecursamientoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecursamientoRequest $request)
    {
        
        Recursamiento::create([
            'materia' => $request->input('materia'),
            'periodo' => $request->input('periodo'),
            'profesor' => $request->input('profesor'),
            'horarios' => $request->input('horarios')
            
        ]);
        return redirect()->route("recursamiento.index")->with('success', 'materia generado con éxito');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recursamiento  $recursamiento
     * @return \Illuminate\Http\Response
     */
    public function show(Recursamiento $recursamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recursamiento  $recursamiento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $Recursamiento= Recursamiento::find($id);
        return Inertia::render("Recursamiento/Edit", [
            'titulo'      => 'Modificar materia',
            'Recursamiento'    => $Recursamiento,
            'routeName'      => $this->routeName,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecursamientoRequest  $request
     * @param  \App\Models\Recursamiento  $recursamiento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecursamientoRequest $request, $id)
    {
        $Recursamiento = Recursamiento::find($id);
        $Recursamiento->update($request->all());
        return redirect()->route("recursamiento.index")->with('success', 'Materia actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recursamiento  $recursamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $Recursamiento = Recursamiento::find($id);
        $Recursamiento->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Materia eliminada con éxito');

    }
}
