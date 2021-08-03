<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class Role extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * @return Object of permissiobs associated with current role
     */
    public function permissions()
    {
    	return $this->belongsToMany(Permission::class);
    }

    /**
     * @param  Permission object 
     * @return Multiple Permission object
     */
    public function givePermissionTo($permission)
    {
    	return $this->permissions()->save($permission);
    }

    
    /**
     * @return Admin name which is created role
     */
    public function getCreatedBy()
    {
        if($this->created_by > 0 )
        {
            return Admin::where('id',$this->created_by)->withTrashed()->first()->name;    
        }
        else
        {
            return "Super Admin";
        }
        
    }
    
}
