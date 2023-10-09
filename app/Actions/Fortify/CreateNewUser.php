<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create( $input): User
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
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
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


        return $user;
    }
}
