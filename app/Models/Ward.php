<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'ward';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;

    public function district()
    {
        return $this->beLongto('App\Models\District', 'district_code', 'code');
    }
}
