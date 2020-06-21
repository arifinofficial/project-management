<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Departement;
use App\Policies\DepartementPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Departement' => 'App\Policies\DepartementPolicy',
        'App\Models\Job' => 'App\Policies\DepartementPolicy',
        // Departement::class => DepartementPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super admin') ? true : null;
        });
    }
}
