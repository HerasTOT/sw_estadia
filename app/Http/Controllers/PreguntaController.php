<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Pregunta;
use App\Http\Requests\StorePreguntaRequest;
use App\Http\Requests\UpdatePreguntaRequest;
use Illuminate\Http\Request;
use App\Models\Academico;
use Illuminate\Support\Facades\DB;
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
        $version = $request->input('version');
        $Pregunta = $Pregunta->where('formato',1)
        ->when($version, function($query,$version){
            $query->where('version', $version);

        })
        ->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(150)->withQueryString();
        $versions = DB::table('preguntas')->distinct()->pluck('version')->toArray(); // Obtener todas las versiones disponibles
        

        return Inertia::render("Pregunta/Index", [
            'titulo'      => 'Formulario',
            'Pregunta'    => $Pregunta,
            'Academico'    => $Academico,
            'routeName'      => $this->routeName,
            'version' => $versions,
            'loadingResults' => false
        ]);
    }

    public function habilitar()
    {
        $Pregunta = $this->model;
        $Pregunta = $Pregunta->where('formato',1);
        $versions = DB::table('preguntas')->distinct()->pluck('version')->toArray(); // Obtener todas las versiones disponibles

        return Inertia::render("Pregunta/habilitar", [
            'titulo'      => 'habilitar formulariosssssss',
            'routeName'      => $this->routeName,
            'pregunta'  => $Pregunta,
            'version'   => $versions,
        ]);

    }
    public function habilitarFormulario($formato_id, $version_id, $estatus)
    {

       
        $preguntas = Pregunta::where('formato', $formato_id)
        ->where('version', $version_id)
        ->get();
        
        if ($estatus === '1') {
          
            foreach ($preguntas as $pregunta) {
                $pregunta->estatus = 1;
                $pregunta->save();
            }
        } elseif ($estatus === '0') {
            foreach ($preguntas as $pregunta) {
                $pregunta->estatus = 0;
                $pregunta->save();
            }
        } else {
        return redirect()->route("pregunta.index")->with('error', 'Estatus inválido.');
        }
        return redirect()->route("pregunta.index")->with('success', 'Estatus actualizado correctamente.');

    }
    public function create()
    {
        $versions = DB::table('preguntas')->distinct()->pluck('version')->toArray(); // Obtener todas las versiones disponibles
        return Inertia::render("Pregunta/Create", [
            'titulo'      => 'Crear nuevo formulario',
            'routeName'      => $this->routeName,
            'version' => $versions,
        ]);
    }

    public function crearnuevapregunta($formato, $version)
    {
        
        return Inertia::render("Pregunta/createpregunta", [
            'titulo'      => 'Crear nueva pregunta',
            'routeName'      => $this->routeName,
            'version' => $version,
            'formato' =>  $formato,
        ]);
        return redirect()->route("pregunta.index");
    }
    public function storepregunta(StorePreguntaRequest $request)
    {
       
        Pregunta::create([
            'pregunta' => $request->input('pregunta'),
            'formato' => $request->input('formato'),
            'version' => $request->input('version'),
        ]);
        return redirect()->route("pregunta.index")->with('message', 'materia generado con éxito');
    }
    
    public function store(StorePreguntaRequest $request)
    {
        $versionAnterior = $request->input('version') - 1;
        $preguntasVersionAnterior = Pregunta::where('version', $versionAnterior)
            ->where('formato', 1)
            ->get();
    
        foreach ($preguntasVersionAnterior as $pregunta) {
            $nuevaPregunta = new Pregunta([
                'pregunta' => $pregunta->pregunta,
                'formato' => $pregunta->formato,
                'version' => $request->input('version'), 
                'estatus'  => $request->input('estatus'), 
            ]);
            $nuevaPregunta->save();
        }
    
        $preguntas = $request->input('preguntas');
        foreach ($preguntas as $pregunta) {
            Pregunta::create([
                'pregunta' => $pregunta['pregunta'],
                'formato' => $request->input('formato'),
                'version' => $request->input('version'),
                'estatus'  => $request->input('estatus'), 
            ]);
        }
    
        return redirect()->route("pregunta.index");
    }


    
   
    public function show(Pregunta $pregunta)
    {
        //
    }

   
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

        public function destroy( $id)
    {
        $Pregunta = Pregunta::find($id);
        $Pregunta->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Pregunta eliminada con éxito');
    }
}
