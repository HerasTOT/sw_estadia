<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Colony;
use App\Models\Workplace;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    use PasswordValidationRules;

    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'roles' => Role::pluck('name'),
            'workplaces' => Workplace::all(),
            'colonies' => Colony::all(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $input): RedirectResponse
    {
        Validator::make($input, [
            'curp' => ['required', 'string', 'max:18', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'paternal_surname' => ['required', 'string', 'max:255'],
            'maternal_surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string',],
            'colony_id' => ['required', 'integer', 'exists:colonies,id'],
            'workplace_id' => ['required', 'integer', 'exists:workplaces,id'],
        ])->validate();

        $user = User::create([
            'curp' => $input['curp'],
            'name' => $input['name'],
            'paternal_surname' => $input['paternal_surname'],
            'maternal_surname' => $input['maternal_surname'],
            'colony_id' => $input['colony_id'],
            'workplace_id' => $input['workplace_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ])->assignRole($input['role']);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('login'));
    }
}
