<?php

namespace App\Traits;

use App\Models\Role;

/**
 * HasRole trait
 */
trait HasRoles 
{
    /**
     * Get all roles for this user
     * @return Return all roles for this user
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Give a role to perticular user
     * @param  Role   $role role object with name, label
     * @return assign given role to this user
     */
    public function assignRole(Role $role)   
    {
        return $this->roles()->sync($role);
    }

    /**
     * Check if use has given role or not
     * @param  $role give role name or object of role
     * @return boolean if user has given role or not
     */
    public function hasRole($role)
    {
        if(is_string($role))
        {
            return $this->roles->contains('name',$role);
        }

        foreach ($role as $r) {
            if($this->hasRole($r->name)){
                return true;
            }
        }
        return false;
    }
}