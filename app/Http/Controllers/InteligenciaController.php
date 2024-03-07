<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Inteligencia;
use App\Http\Requests\StoreInteligenciaRequest;
use App\Http\Requests\UpdateInteligenciaRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Pregunta;
use App\Models\Respuesta;

class InteligenciaController extends Controller
{
    private Inteligencia $model;
    private string $routeName;
    private string $source;
    private string $module = 'inteligencia';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Inteligencia/';
        $this->model = new Inteligencia();
        $this->routeName = 'inteligencia.';

   }
   
   public function index(Request $request): Response

   {
    $user = Auth::user();
    $inteligenciaId = $user->inteligencia ? $user->inteligencia->id : null;
    $inteligencia = $user->inteligencia;
    $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
        $query->where('formato', 3);
    })->get();

        $preguntas = $respuestas->pluck('pregunta')->unique();

     
       return Inertia::render("Inteligencia/Index", [
           'titulo'      => 'Formato de inteligencias multiples',
           'routeName'      => $this->routeName,
           'inteligencia'      => $inteligencia, 
           'inteligenciaId'      => $inteligenciaId,   
           'preguntas' => $preguntas,
           'respuestas' => $respuestas,
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
        $preguntas = Pregunta::all();

        return Inertia::render("Inteligencia/Create", [
            'titulo'      => 'Formato de inteligencias multiples',
            'routeName'      => $this->routeName,
            'preguntas'      => $preguntas,  
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInteligenciaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInteligenciaRequest $request)
    {
        $user = auth()->user();

        Inteligencia::create([
            'user_id' => $user->id,
            'matricula' => $request->input('matricula'),
            'grado' => $request->input('grado'),
            'grupo' => $request->input('grupo'),
            'tutor' => $request->input('tutor'),
            'periodo' => $request->input('periodo'),
            'formato' => $request->input('formato'),
            ]);

            $respuestas = $request->input('respuestas'); // Cambiado de 'respuesta' a 'respuestas'
          
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
            return redirect()->route("inteligencia.index")->with('succes', 'grupo generado con éxito');
    }

    public function show(Inteligencia $inteligencia)
    {
    
    }

 
    public function edit($id)
    {
        $user = Auth::user();
        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
            $query->where('formato', 3);
        })->get();
        $preguntas = $respuestas->pluck('pregunta')->unique();

        $inteligencia= Inteligencia::find($id);
        return Inertia::render("Inteligencia/Edit", [
            'titulo'      => 'Modificar formulario jkbnjk',
            'inteligencia'    => $inteligencia,
            'respuestas'     => $respuestas,
            'preguntas'      => $preguntas,  

            'routeName'      => $this->routeName,
        ]);
    }

 
    public function update(UpdateInteligenciaRequest $request, $id)
    {
        $user = Auth::user();

        $Inteligencia = Inteligencia::find($id);
        $Inteligencia->update($request->all());

        
        
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
        return redirect()->route("inteligencia.index")->with('message', 'Formulario actualizado correctamente!');

    
}

   
    public function destroy($id)
    {
        $inteligencia = Inteligencia::find($id);
        $inteligencia->delete();
        return redirect()->route("inteligencia.index")->with('success', 'Formato eliminada con éxito');

    }
}
