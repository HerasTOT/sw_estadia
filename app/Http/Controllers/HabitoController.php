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
    $habitoId = $user->habito ? $user->habito->id : null;
    $habito = $user->habito;
    $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
        $query->where('formato', 2);
    })->get();
    $preguntas = $respuestas->pluck('pregunta')->unique();

     
       return Inertia::render("Habito/Index", [
           'titulo'      => 'Formato de habitos de estudio',
           'routeName'      => $this->routeName,
           'habito'      => $habito,
           'habitoId'      => $habitoId,    
           'preguntas' => $preguntas,
           'respuestas' => $respuestas,
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

 
    public function show(Habito $habito)
    {
        //
    }

  
    public function edit($id)
    {
        $user = Auth::user();
        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
            $query->where('formato', 2);
        })->get();
        $preguntas = $respuestas->pluck('pregunta')->unique();

        $habito= Habito::find($id);
        return Inertia::render("Habito/Edit", [
            'titulo'      => 'Modificar formato',
            'habito'       => $habito,
            'respuestas'     => $respuestas,
            'preguntas'      => $preguntas,  

            'routeName'      => $this->routeName,
        ]);
    }

    public function update(UpdateHabitoRequest $request, $id)
    {
        $habito = Habito::find($id);
        $habito->update($request->all());
        $user = Auth::user();
        $respuestasUsuario = Respuesta::where('user_id', $user->id)->get();
        foreach ($request->input('respuestas') as $respuestaData) {
            // Accede a los datos de respuesta y pregunta
            $preguntaId = $respuestaData['pregunta']['id'];
            $respuestaValor = $respuestaData['respuesta'];
    
            // Busca la respuesta existente para esa pregunta y ese usuario
            $respuestaExistente = $respuestasUsuario->firstWhere('pregunta_id', $preguntaId);
    
            if ($respuestaExistente) {
                // Si la respuesta existe, actualiza el valor
                $respuestaExistente->respuesta = $respuestaValor;
                $respuestaExistente->save();
            } 
        
        } 
        return redirect()->route("habito.index")->with('message', 'Formato actualizado correctamente!');

    }

   
    public function destroy( $id)
    {
        $habito = Habito::find($id);
        $habito->delete();
        return redirect()->route("habito.index")->with('success', 'Formato eliminada con éxito');

    }
}
