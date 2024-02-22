<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Pregunta;
use App\Http\Requests\StorePreguntaRequest;
use App\Http\Requests\UpdatePreguntaRequest;
use Illuminate\Http\Request;
use App\Models\Academico;
use Inertia\Response;
use Inertia\Inertia;

class PreguntaController extends Controller
{
    private Pregunta $model;
    private string $routeName;
    private string $source;
    private string $module = 'pregunta';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Pregunta/';
        $this->model = new Pregunta();
        $this->routeName = 'pregunta.';

    }
    public function index(Request $request): Response
    {
        $Pregunta = $this->model;
        $Academico = Academico::all();
     
        $Pregunta = $Pregunta->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("Pregunta/Index", [
            'titulo'      => 'Formulario',
            'Pregunta'    => $Pregunta,
            'Academico'    => $Academico,
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
        return Inertia::render("Pregunta/Create", [
            'titulo'      => 'Crear nueva pregunta',
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePreguntaRequest  $request
     * @return \Illuminate\Http\Response
     */
    
        public function store(StorePreguntaRequest $request)
    {
        Pregunta::create([
            'pregunta' => $request->input('pregunta'),
            'formato' => $request->input('formato'),
        ]);
        return redirect()->route("pregunta.index")->with('message', 'materia generado con éxito');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pregunta  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function show(Pregunta $pregunta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pregunta  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $Pregunta= Pregunta::find($id);
        return Inertia::render("Pregunta/Edit", [
            'titulo'      => 'Modificar pregunta',
            'Pregunta'    => $Pregunta,
            'routeName'      => $this->routeName,
        ]);
    }

    
    public function update(UpdatePreguntaRequest $request, $id)
    {
        $Pregunta= Pregunta::find($id);
        $Pregunta->update($request->all());
        return redirect()->route("pregunta.index")->with('message', 'Pergunta actualizada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pregunta  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $Pregunta = Pregunta::find($id);
        $Pregunta->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Pregunta eliminada con éxito');
    }
}
