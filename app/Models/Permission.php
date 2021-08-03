<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /** 
     * Roles which are relation with permission
     * @return Multiple Role object
     * 
     */
    public function roles()
    {
   		return $this->belongsToMany(Role::class);
   	}
    
}
