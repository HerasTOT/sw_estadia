<?php

namespace App\Http\Controllers;

use App\Models\Academico;
use App\Models\Respuesta;
use App\Http\Requests\StoreAcademicoRequest;
use App\Http\Requests\UpdateAcademicoRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Pregunta;


class AcademicoController extends Controller
{
    private Academico $model;
    private string $routeName;
    private string $source;
    private string $module = 'academico';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Academico/';
        $this->model = new Academico();
        $this->routeName = 'academico.';

   }
   
   public function index(Request $request): Response
   {
        $user = Auth::user();
        
        $academicoId = $user->academico ? $user->academico->id : null;
        $Academico = $user->Academico;
        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
            $query->where('formato', 1);
        })->get();
        $preguntas = $respuestas->pluck('pregunta')->unique();

        
     
       return Inertia::render("Academico/Index", [
           'titulo'      => 'Formato de analisis academico',
           'Academico'    => $Academico,
           'academicoId' => $academicoId,
           'routeName'      => $this->routeName,
           'preguntas'      => $preguntas,  
           'respuestas'     => $respuestas,
           'loadingResults' => false
       ]);
   }

    
    public function create()
    {
        
        $preguntas = Pregunta::all();

        return Inertia::render("Academico/Create", [
            'titulo'      => 'Analisis',
            'routeName'      => $this->routeName,
            'preguntas'      => $preguntas,  
        ]);
    }

    
    public function store(StoreAcademicoRequest $request)
    {
        $user = auth()->user();

        if ($user->academico && $user->academico->status == 1) {
            return redirect()->route('academico.index')->with('error', 'Ya has generado un formulario.');
        }
        Academico::create([
            'user_id' => $user->id,
            'matricula' => $request->input('matricula'),
            'grado' => $request->input('grado'),
            'grupo' => $request->input('grupo'),
            'tutor' => $request->input('tutor'),
            'periodo' => $request->input('periodo'),
            'materia_recursar' => $request->input('materia_recursar'),
            'status' => $request->input('status'),
            'version' => $request->input('version'),
            'formato' => $request->input('formato'),
            ]);

            $respuestas = $request->input('respuestas'); 
            $preguntas_id = $request->input('pregunta_id');
            
            if (!is_null($respuestas) && is_array($respuestas)) {
                foreach ($respuestas as $pregunta_id => $respuesta) { 
                    if($pregunta_id != null){
                    Respuesta::create([
                        'respuesta' => $respuesta,
                        'user_id' => $user->id,
                        'pregunta_id' => $pregunta_id, 
                    ]);
                }
                }
            }
        
        
            return redirect()->route("academico.index")->with('message', ' generado con éxito');
    }

    
    public function show(Academico $academico)
    {
        //
    }

    public function edit($id)
    {
        $user = Auth::user();
        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
            $query->where('formato', 1);
        })->get();
        $preguntas = $respuestas->pluck('pregunta')->unique();

        $Academico= Academico::find($id);
        return Inertia::render("Academico/Edit", [
            'titulo'      => 'Modificar formulario',
            'Academico'    => $Academico,
            'respuestas'     => $respuestas,
            'preguntas'      => $preguntas,  

            'routeName'      => $this->routeName,
        ]);
    }

    public function update(UpdateAcademicoRequest $request,$id)
    {
        $user = Auth::user();

        $Academico = Academico::find($id);
        $Academico->update($request->all());

        
        
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
        return redirect()->route("academico.index")->with('message', 'Formulario actualizado correctamente!');

    
}

    public function destroy($id)
    {
        $Academico = Academico::find($id);
        $Academico->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Materia eliminada con éxito');

    }
}
