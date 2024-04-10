<?php

use App\Http\Controllers\AcademicoController;
use App\Http\Controllers\InteligenciaController;
use App\Http\Controllers\HabitoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\GrupoMateriasController;
use App\Http\Controllers\RecursamientoController;
use App\Http\Controllers\ListaRecursamientoController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\FormatoEvaluacionController;
use App\Models\Announcements;
use App\Models\Inteligencia;
use App\Models\ListaRecursamiento;
use App\Models\Periodo;
use App\Models\review;
use App\Models\User;
use App\Models\Recursamiento;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use function GuzzleHttp\Promise\all;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $recursamientos = Recursamiento::all();
    
    return Inertia::render('Welcome', [
  'recursamientos' =>$recursamientos,
    ]);
});


Route::get('/dashboard', function () {
    $recursamientos = Recursamiento::all();
    return Inertia::render('HomeView', [
        'users' => User::all(),
        'recursamientos' =>$recursamientos,
    
    ]);
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {

    //Assign roles
    Route::get('/users/{user}/assign-roles-and-permissions', [UserController::class, 'assignRolesAndPermissionsView'])->name('users.assign-roles-and-permissions.view');
    Route::post('/users/{user}/assign-roles-and-permissions', [UserController::class, 'assignRolesAndPermissions'])->name('users.assign-roles-and-permissions');

    //Admin user management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/{userId}/assign-role', [ProfileController::class, 'assignRole'])->name('profile.assignRole');

    //Main routes
    Route::resource('reviews', ReviewController::class)->names('reviews');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('roles', RolesController::class)->names('roles');
    Route::resource('materia', MateriaController::class)->names('materia');
    Route::resource('grupo', GrupoController::class)->names('grupo');
    //usuarios
    Route::resource('usuarios', UsuarioController::class)->parameters(['usuarios' => 'usuarios']);
    Route::get('/usuarios/profe', [UsuarioController::class, 'profe'])->name('usuarios.profe');
    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('usuarios.perfil');
    Route::post('actualizarPerfil', [UsuarioController::class, 'updatePerfil'])->name('usuarios.update-perfil');

    Route::resource('alumno', AlumnoController::class)->parameters(['alumno' => 'alumno']);
    //Route::post('/alumnos}', [AlumnoController::class, 'store'])->name('alumnos.store');
    Route::resource('profesor', ProfesorController::class)->parameters(['profesor' => 'profesor']);
  
    //Formatos  Analiis academico individual, habitos 
    Route::resource('academico', AcademicoController::class)->names('academico');
    Route::get('academico/create/{version}', [AcademicoController::class, 'create'])->name('academico.create');
    Route::get('academico/{id}/edit/{version}', [AcademicoController::class, 'edit'])->name('academico.edit');
    Route::get('observaciones', [AcademicoController::class, 'observacion'])->name('academico.observacion');

    Route::resource('habito', HabitoController::class)->names('habito');
    Route::get('habito/create/{version}', [HabitoController::class, 'create'])->name('habito.create');
    Route::get('habito/{id}/edit/{version}', [HabitoController::class, 'edit'])->name('habito.edit');

    Route::resource('inteligencia', InteligenciaController::class)->names('inteligencia');
    Route::get('inteligencia/create/{version}', [InteligenciaController::class, 'create'])->name('inteligencia.create');
    Route::get('inteligencia/{id}/edit/{version}', [InteligenciaController::class, 'edit'])->name('inteligencia.edit');

    Route::resource('pregunta', PreguntaController::class)->parameters(['pregunta' => 'pregunta']);
    Route::resource('respuesta', RespuestaController::class)->parameters(['respuesta' => 'respuesta']);
    Route::get('pregunta/{id}/version/{version_id}', [PreguntaController::class, 'crearnuevapregunta'])->name('pregunta.agregar-pregunta');
    Route::post('pregunta/crear', [PreguntaController::class, 'storepregunta'])->name('pregunta.store-pregunta');
    Route::get('habilitar', [PreguntaController::class, 'habilitar'])->name('pregunta.habilitar');
    Route::get('pregunta/{formato_id}/version/{version_id}/estatus/{estatus}/grupo/{grupo_id}', [PreguntaController::class, 'habilitarFormulario'])->name('pregunta.habilitar-formulario');
    Route::get('AnalisisPreguntas', [PreguntaController::class, 'gestionAnalisis'])->name('pregunta.academico');
    Route::get('HabitoPreguntas', [PreguntaController::class, 'gestionHabito'])->name('pregunta.habito');
    Route::get('InteligenciaPreguntas', [PreguntaController::class, 'gestionInteligencia'])->name('pregunta.inteligencia');

    //Route::get('pregunta/{id}/version/{version_id}/estatus/{estatus}', [PreguntaController::class, 'habilitar'])->name('pregunta.habilitar');
    //Route::get('pregunta/habilitar-formulario', [PreguntaController::class, 'habilitarFormulario'])->name('pregunta.habilitar-formulario');


    //Gestion de grupo 
    Route::resource('grupomaterias', GrupoMateriasController::class)->parameters(['grupomaterias' => 'grupomaterias']);
    //Publicacion de recursamientos disponibles 
    Route::resource('recursamiento', RecursamientoController::class)->parameters(['recursamiento' => 'recursamiento']);
    //asignar estudiantes a grupo
    Route::get('/grupos/{id}/assign-group', [GrupoController::class, 'assignGroupView'])->name('grupos.assign-group.view');
    Route::post('/grupo/{id}/remove-alumno/{userId}', [GrupoController::class, 'removeAlumno'])->name('grupo.remove-alumno');
    Route::post('/gruposAsignacion', [GrupoController::class, 'assignAlumno'])->name('grupos.assign-group.post');
    Route::resource('periodo', PeriodoController::class)->names('periodo');


    Route::resource('lista', ListaRecursamientoController::class)->parameters(['lista' => 'lista']);
    Route::get('/lista/{id}/assign-Alumno', [ListaRecursamientoController::class, 'assignAlumnoRecursamiento'])->name('lista.assign-lista.view');
    Route::post('/lista/{id}/eliminar-Alumno/{userId}', [ListaRecursamientoController::class, 'eliminarAlumno'])->name('lista.eliminar-alumno');

    Route::resource('encuesta',EncuestaController::class)->parameters(['encuesta'=>'encuesta']);
    Route::resource('evaluacion', FormatoEvaluacionController::class)->parameters(['evaluacion' => 'evaluacion']);
    Route::get('evaluacionHabitos', [FormatoEvaluacionController::class, 'evaluacionHabito'])->name('evaluacion.habito');
    Route::get('evaluacionAcademicos', [FormatoEvaluacionController::class, 'evaluacionAcademico'])->name('evaluacion.academico');
    Route::get('evaluacionInteligencias', [FormatoEvaluacionController::class, 'evaluacionInteligencia'])->name('evaluacion.inteligencia');



});


require __DIR__ . '/auth.php';
