<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'admin';
     protected $hidden = ['password'];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * foreign for roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany(Role::class, 'role_admin');
    }

    public function allRole(){
        $roles = $this->roles()->get();
        $text = '';
        foreach($roles as $role){
            $text .= $role->name.',';
        }
        return trim($text, ',');
    }

    public function hasAccess(array $permissions): bool{
        foreach($this->roles as $role){
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    public function inRole(string $slug){
        return $this->roles()->where('slugs', $slug)->count() == 1;
    }

    public function fullPermission(){
        return $this->hasAccess(['isAdmin']) || false;
    }
}
