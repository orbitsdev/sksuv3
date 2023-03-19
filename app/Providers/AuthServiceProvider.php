<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-osas', function($user){
            return $user->hasRole('osas'); 
        });
        Gate::define('is-adviser', function($user){
            return $user->hasRole('sbo-adviser'); 
        });
        Gate::define('is-student', function($user){
            return $user->hasRole('sbo-student'); 
        });
        Gate::define('is-director', function($user){
            return $user->hasRole('campus-director'); 
        });
        Gate::define('is-vpa', function($user){
            return $user->hasRole('vpaa'); 
        });

        Gate::define('is-guest', function($user){
            return $user->hasRole('guest'); 
        });
        Gate::define('is-guest', function($user){
            return $user->hasRole('super-admin'); 
        });
        Gate::define('is-superadmin', function($user){
            return $user->hasRole('super-admin'); 
        });
        Gate::define('is-developer', function($user){
            return $user->hasRole('developer'); 
        });
        
        Gate::define('is-guest-or-student', function($user){
            return $user->hasRoleOf(['guest','sbo-student']); 
        });

    }
}
