<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory,Notifiable,SoftDeletes,HasRoles;

    /** 
     * Default guard use for admin authentication 
     */
    protected $guard = 'admin';

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'name', 'email','password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /** 
     * Custom password reset notification for admin. Extented default password notification 
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    /**
     * @return Admin name which is created by current record
     */ 
    public function getCreatedByName(){
        return $this->where('id',$this->created_by)->withTrashed()->first()->name;
    }

}
