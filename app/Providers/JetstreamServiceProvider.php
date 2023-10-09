<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Http\Responses\RegisterResponse;
use App\Models\Colony;
use App\Models\Workplace;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\RegisterResponse as ContractsRegisterResponse;
use Spatie\Permission\Models\Role;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::registerView(function () {
            return Inertia::render('Auth/Register', [
                'roles' => Role::all(),
                'workplaces' => Workplace::all(),
                'colonies' => Colony::all(),
                /*                 'pruebita' =>  Http::get("https://api.tau.com.mx/dipomex/v1/62130")
 */
            ]);
        });

        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        /*   $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \App\Http\Responses\RegisterResponse::class
        ); */
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
