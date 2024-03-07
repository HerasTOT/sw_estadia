<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Encuesta;
use App\Models\User;
use App\Models\Alumno;
use App\Http\Requests\StoreEncuestaRequest;
use App\Http\Requests\UpdateEncuestaRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class EncuestaController extends Controller
{
    private Encuesta $model;
    private string $routeName;
    private string $source;
    private string $module = 'periodo';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Encuesta/';
        $this->model = new Encuesta();
        $this->routeName = 'encuesta.';
    }

    public function index(Request $request): Response
    {
        $usuarios = User::all();
        $Encuesta = $this->model;
       

        $Encuesta = $Encuesta->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->with('user')->paginate(7)->withQueryString();

        return Inertia::render("Encuesta/Index", [
            'titulo'      => 'Encuestas de recursamiento',
            'Encuesta'    => $Encuesta,
            'usuarios'      => $usuarios,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    public function create()
    {

        return Inertia::render("Encuesta/Create", [
            'titulo'      => 'Encuestas de recursamiento',
            'routeName'      => $this->routeName,
        ]);
    }


    public function store(StoreEncuestaRequest $request)
    {

        $user = Auth::user();
        if ($user->role !== 'Alumno') {
            return redirect()->route("{$this->routeName}index")->with('error', 'Solo los alumnos pueden ser asignados a recursamientos.');
        }
        $existingResponse = Encuesta::where('user_id', auth()->id()) // O utiliza el ID del usuario que quieras verificar
            ->first();

        if ($existingResponse) {

            return redirect()->route("{$this->routeName}index")->with('error', 'El usuario ya ha respondido a la encuesta.');
        }

        Encuesta::Create([
            'horario' => $request->input('horario'),
            'profesores' => $request->input('profesores'),
            'tipo_proyecto' => $request->input('tipo_proyecto'),
            'dificultad' => $request->input('dificultad'),
            'estudiantes' => $request->input('estudiantes'),
            'user_id' => $user->id,
        ]);
        return redirect()->route('encuesta.index');
    }


    public function show(Encuesta $encuesta)
    {
    }


    public function edit($id)
    {
        $Encuesta = Encuesta::find($id);
        return Inertia::render([
            'Encuesta' => $Encuesta,
            'titulo' => 'Modificar formulario',
            'routeName'      => $this->routeName,
        ]);
    }


    public function update(UpdateEncuestaRequest $request, $id)
    {
        $Encuesta = Encuesta::find($id);
        $Encuesta->update($request->all());
        return redirect()->route("Encuesta.index");
    }


    public function destroy($id)
    {
        $Encuesta = Encuesta::find($id);
        $Encuesta->delete();
        return redirect()->route("encuesta.index");
    }
}
