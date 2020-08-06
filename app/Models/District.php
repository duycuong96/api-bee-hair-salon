<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;

    public function province()
    {
        return $this->beLongto('App\Models\Province', 'province_code', 'code');
    }

    public function wards()
    {
        return $this->hasMany('App\Models\Ward', 'district_code', 'code');
    }

}
