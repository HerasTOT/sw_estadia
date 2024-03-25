<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Pregunta;
use App\Http\Requests\StorePreguntaRequest;
use App\Http\Requests\UpdatePreguntaRequest;
use Illuminate\Http\Request;
use App\Models\Academico;
use App\Models\Habito;
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
        $Pregunta = $Pregunta->where('formato',2);
        $versionsByFormat = [];
        for ($i = 1; $i <= 3; $i++) {
            $formato = '';
            switch ($i) {
                case 1:
                    $formato = 'Formato Análisis académico individual';
                    break;
                case 2:
                    $formato = 'Formato Hábitos de estudio';
                    break;
                case 3:
                    $formato = 'Formato Inteligencias múltiples';
                    break;
            }
    
            $versionsByFormat[$formato] = DB::table('preguntas')
                                            ->where('formato', $i)
                                            ->distinct()
                                            ->pluck('version')
                                            ->toArray();
        }
    
    
        return Inertia::render("Pregunta/habilitar", [
            'titulo'      => 'Habilitar formularios',
            'routeName'      => $this->routeName,
            'pregunta'  => $Pregunta,
            'version'   => $versionsByFormat,
           

        ]);

    }
    public function habilitarFormulario($formato_id, $version_id, $estatus)
    {

        
       
       switch ($formato_id) {
           case 'Formato Análisis académico individual':
               $formato_id = 1;
               break;
           case 'Formato Hábitos de estudio':
               $formato_id = 2;
               break;
           case 'Formato Inteligencias múltiples':
               $formato_id = 3;
               break;
           
       }
       
        $preguntas = Pregunta::where('formato', $formato_id)
        ->where('version', $version_id)
        ->get();

        Habito::where('formato', $formato_id)
        ->where('version', $version_id)
        ->update(['estatus' => $estatus]);
        
        Academico::where('formato', $formato_id)
        ->where('version', $version_id)
        ->update(['estatus' => $estatus]);
        
        if ($estatus === '1') {
          
            foreach ($preguntas as $pregunta) {
                $pregunta->estatus = 1;
                $pregunta->save();
            }
            return redirect()->route("pregunta.index")->with('success', 'Formulario activado.');

        } elseif ($estatus === '0') {
            foreach ($preguntas as $pregunta) {
                $pregunta->estatus = 0;
                $pregunta->save();
            }
            return redirect()->route("pregunta.index")->with('success', 'Formulario desactivado.');

        } else {
        return redirect()->route("pregunta.index")->with('error', 'Estatus inválido.');
        }

    }
    public function create()
    {
        $versions = DB::table('preguntas')->distinct()->pluck('version')->toArray(); 
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
        
        
        $Formato= $request->input('formato');
        $versionAnterior = Pregunta::where('formato', $Formato)
        ->max('version');
        $preguntasVersionAnterior = Pregunta::where('version', $versionAnterior)
            ->where('formato',$Formato )
            ->get();
        foreach ($preguntasVersionAnterior as $pregunta) {
            $nuevaPregunta = new Pregunta([
                'pregunta' => $pregunta->pregunta,
                'formato' => $request->input('formato'),
                'version' => $versionAnterior+1, 
                'estatus'  => $request->input('estatus'), 
            ]);
            $nuevaPregunta->save();
        }
    
        $preguntas = $request->input('preguntas');
        foreach ($preguntas as $pregunta) {
            Pregunta::create([
                'pregunta' => $pregunta['pregunta'],
                'formato' => $request->input('formato'),
                'version' => $versionAnterior+1,
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
