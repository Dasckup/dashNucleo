<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_activity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission($permission){
        return $this->permissions->where("name", $permission)->isNotEmpty();
    }

    public function assignPermission($permissionName){
        $permission = Permission::where("name", $permissionName)->first();
        if ($permission) {
            return $this->permissions()->attach($permission->id);
        }
        return false;
    }


    public function removePermission($permission){
        return $this->permissions()->detach($permission);
    }

    public function updateActivity(){
        return $this->update(['last_activity' => now()]);
    }
}
