<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Colony;
use App\Models\User;
use App\Models\Workplace;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    protected string $routeName;
    protected string $source;
    /* protected string $module = 'profile'; */
    protected User $model;

    public function __construct()
    {
        $this->routeName = "profile.";
        $this->source    = "Profile/";
        $this->model     = new User();
        /*   $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']); */
    }
    public function index(Request $request): Response
    {
        $records = $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Usuarios',
            'records'        => $records,
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Profile/Edit', [
            'roles' => Role::pluck('name'),
            'workplaces' => Workplace::all(),
            'colonies' => Colony::all(),
            'titulo' => 'Agregar Usuario',
            'routeName' => $this->routeName,
            'user' => $user
        ]);
    }

    //assign A role to an user

    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($userId);
        $role = Role::findOrFail($request->input('role_id'));

        $user->roles()->sync([$role->id]);

        return redirect()->route("{$this->routeName}index")->with('success', 'Rol asignado con éxito!');
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'roles' => Role::pluck('name'),
            'workplaces' => Workplace::all(),
            'colonies' => Colony::all(),
            'titulo' => 'Agregar Usuario',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
