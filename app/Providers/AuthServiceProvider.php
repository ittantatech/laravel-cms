<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate as GateContract;
use App\Models\Permission;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return validation based on role assigned for admin
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        if (Schema::hasTable('permissions')) {
            $permissions = $this->getPermissions();
            if(!empty($permissions && count($permissions->toArray())>0)){
                foreach ($permissions as $permission) {
                    $gate::define($permission->name,function($user) use ($permission){
                        return $user->hasRole($permission->roles);
                    });
                }    
            }
        }
        
    }
    /**
     * Get all permission with role
     * 
     * @return Permission with role object
     */

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
