<?php

use App\Http\Controllers\AcademicoController;
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
use App\Models\Announcements;
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
    return Inertia::render('HomeView', ['users' => User::all()]);
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/forms', function () {
        return Inertia::render('FormsView');
    });
    Route::get('/tables', function () {
        return Inertia::render('TablesView');
    });
    Route::get('/ui', function () {
        return Inertia::render('UiView');
    });
    Route::get('/responsive', function () {
        return Inertia::render('ResponsiveView');
    });
    Route::get('/profile', function () {
        return Inertia::render('ProfileView');
    });
    Route::get('/error', function () {
        return Inertia::render('ErrorView');
    });

    /*   Route::get('/', function () {
        return Inertia::render('StyleView');
    }); */

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
    Route::resource('habito', HabitoController::class)->names('habito');
    Route::resource('pregunta', PreguntaController::class)->parameters(['pregunta' => 'pregunta']);
    Route::resource('respuesta', RespuestaController::class)->parameters(['respuesta' => 'respuesta']);

    //Gestion de grupo 
    Route::resource('grupomaterias', GrupoMateriasController::class)->parameters(['grupomaterias' => 'grupomaterias']);
    //Publicacion de recursamientos disponibles 
    Route::resource('recursamiento', RecursamientoController::class)->parameters(['recursamiento' => 'recursamiento']);
    //asignar estudiantes a grupo
    Route::get('/grupos/{id}/assign-group', [GrupoController::class, 'assignGroupView'])->name('grupos.assign-group.view');
    
    Route::post('/gruposAsignacion', [GrupoController::class, 'assignAlumno'])->name('grupos.assign-group.post');
        //Route::post('/asigngrupo/{id}', [GrupoController::class, 'assignAlumno'])->name('assigngroup.post');
});


require __DIR__ . '/auth.php';
