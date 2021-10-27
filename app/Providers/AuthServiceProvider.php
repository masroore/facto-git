<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
      parent::registerPolicies($gate);
        try {
          if (\Schema::hasTable('permissions')) {
              // Dynamically register permissions with Laravel's Gate.
              foreach ($this->getPermissions() as $permission) {
                  $gate->define($permission->name, function ($user) use ($permission) {
                      return $user->hasPermission($permission);
                  });
              }
          }
        } catch (\Illuminate\Database\QueryException $ex) {
            return;
        }
        //
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }

}
