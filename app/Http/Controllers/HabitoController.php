<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Habito;
use App\Http\Requests\StoreHabitoRequest;
use App\Http\Requests\UpdateHabitoRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Pregunta;
use App\Models\Respuesta;

class HabitoController extends Controller
{
    private Habito $model;
    private string $routeName;
    private string $source;
    private string $module = 'habito';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Habito/';
        $this->model = new Habito();
        $this->routeName = 'habito.';

   }
   
   public function index(Request $request): Response
   {
    $user = Auth::user();
    $habito = $user->habito ? $user->habito->id : null;
    $habito = $user->habito;
    $pregunta = Pregunta::all();

     
       return Inertia::render("Habito/Index", [
           'titulo'      => 'Formato de habitos de estudio',
           'routeName'      => $this->routeName,
           'habito'      => $habito,  
           'pregunta' => $pregunta,
           'loadingResults' => false
       ]);
   }

   
    public function create()
    {
        $preguntas = Pregunta::all();

        return Inertia::render("Habito/Create", [
            'titulo'      => 'Habitos de estudio',
            'routeName'      => $this->routeName,
            'preguntas'      => $preguntas,  
        ]);
    }

 
    public function store(StoreHabitoRequest $request)
    {

        $user = auth()->user();

        Habito::create([
            'user_id' => $user->id,
            'matricula' => $request->input('matricula'),
            'grado' => $request->input('grado'),
            'grupo' => $request->input('grupo'),
            'tutor' => $request->input('tutor'),
            'periodo' => $request->input('periodo'),
            'formato' => $request->input('formato'),
            ]);

            $respuestas = $request->input('respuestas'); // Cambiado de 'respuesta' a 'respuestas'
            $preguntas_id = $request->input('pregunta_id');
            
            if (!is_null($respuestas) && is_array($respuestas)) {
                foreach ($respuestas as $pregunta_id => $respuesta) { // Recorre el array asociativo con índice de pregunta
                    if($pregunta_id != null){
                    Respuesta::create([
                        'respuesta' => $respuesta,
                        'user_id' => $user->id,
                        'pregunta_id' => $pregunta_id, // Usa directamente el ID de la pregunta
                    ]);
                }
                }
            }
            return redirect()->route("habito.index")->with('message', 'grupo generado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Habito  $habito
     * @return \Illuminate\Http\Response
     */
    public function show(Habito $habito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Habito  $habito
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $habito= Habito::find($id);
        return Inertia::render("Habito/Edit", [
            'titulo'      => 'Modificar materia',
            'habito'    => $habito,
            'routeName'      => $this->routeName,
        ]);
    }

    public function update(UpdateHabitoRequest $request, $id)
    {
        $habito = Habito::find($id);
        $habito->update($request->all());
        return redirect()->route("grupo.index")->with('message', 'Grupo actualizado correctamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Habito  $habito
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $habito = Habito::find($id);
        $habito->delete();
        return redirect()->route("grupo.index")->with('success', 'Materia eliminada con éxito');

    }
}
