<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany('App\Models\District', 'province_code', 'code');
    }
}
