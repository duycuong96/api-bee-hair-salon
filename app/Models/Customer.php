<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'customers';

    protected $fillable = ['full_name', 'email', 'password', 'avatar', 'birthday', 'phone', 'address', 'ward_id'];
    protected $dates = ['birthday'];

     protected $hidden = ['password', 'token_hash', 'token_expired', 'remember_token'];

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

    public function ward()
    {
        return $this->beLongTo('App\Models\Ward', 'ward_id', 'code');
    }
}
