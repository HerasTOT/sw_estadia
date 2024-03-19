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
    Route::resource('usuarios', UsuarioController::class)->parameters(['usuarios' => 'usuarios']);


    Route::resource('alumno', AlumnoController::class)->parameters(['alumno' => 'alumno']);
    //Route::post('/alumnos}', [AlumnoController::class, 'store'])->name('alumnos.store');
    Route::resource('profesor', ProfesorController::class)->parameters(['profesor' => 'profesor']);
  
    //Formatos  Analiis academico individual, habitos 
    Route::resource('academico', AcademicoController::class)->names('academico');
    Route::get('academico/create/{version}', [AcademicoController::class, 'create'])->name('academico.create');

    Route::resource('habito', HabitoController::class)->names('habito');
    Route::resource('inteligencia', InteligenciaController::class)->names('inteligencia');
    Route::resource('pregunta', PreguntaController::class)->parameters(['pregunta' => 'pregunta']);
    Route::resource('respuesta', RespuestaController::class)->parameters(['respuesta' => 'respuesta']);
    Route::get('pregunta/{id}/version/{version_id}', [PreguntaController::class, 'crearnuevapregunta'])->name('pregunta.agregar-pregunta');
    Route::post('pregunta/crear', [PreguntaController::class, 'storepregunta'])->name('pregunta.store-pregunta');
    Route::post('pregunta/habilitar', [PreguntaController::class, 'habilitar'])->name('pregunta.habilitar');
    Route::get('pregunta/{formato_id}/version/{version_id}/estatus/{estatus}', [PreguntaController::class, 'habilitarFormulario'])->name('pregunta.habilitar-formulario');

    //Route::get('pregunta/{id}/version/{version_id}/estatus/{estatus}', [PreguntaController::class, 'habilitar'])->name('pregunta.habilitar');
    //Route::get('pregunta/habilitar-formulario', [PreguntaController::class, 'habilitarFormulario'])->name('pregunta.habilitar-formulario');


    //Gestion de grupo 
    Route::resource('grupomaterias', GrupoMateriasController::class)->parameters(['grupomaterias' => 'grupomaterias']);
    //Publicacion de recursamientos disponibles 
    Route::resource('recursamiento', RecursamientoController::class)->parameters(['recursamiento' => 'recursamiento']);
    //asignar estudiantes a grupo
    Route::get('/grupos/{id}/assign-group', [GrupoController::class, 'assignGroupView'])->name('grupos.assign-group.view');
    Route::post('/grupo/remove-alumno', [GrupoController::class, 'removeAlumno'])->name('grupo.remove-alumno');
    Route::post('/gruposAsignacion', [GrupoController::class, 'assignAlumno'])->name('grupos.assign-group.post');
    Route::resource('periodo', PeriodoController::class)->names('periodo');


    Route::resource('lista', ListaRecursamientoController::class)->parameters(['lista' => 'lista']);
    Route::get('/lista/{id}/assign-Alumno', [ListaRecursamientoController::class, 'assignAlumnoRecursamiento'])->name('lista.assign-lista.view');
    //Route::get('/lista/{id}/delete-Alumno', [ListaRecursamientoController::class, 'deleteAlumnoRecursamiento'])->name('lista.delete-lista.view');
    Route::post('/lista/{id}/eliminar-Alumno/{userId}', [ListaRecursamientoController::class, 'eliminarAlumno'])->name('lista.eliminar-alumno');

    Route::resource('encuesta',EncuestaController::class)->parameters(['encuesta'=>'encuesta']);
});


require __DIR__ . '/auth.php';
