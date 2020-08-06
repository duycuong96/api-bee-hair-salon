<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchSalon extends Model
{
    protected $table = 'branch_salons';

    protected $fillable = [
        'name',
        'thumb_img',
        'content',
        'work_time',
        'address',
        'phone',
        'status',
        'ward_id',
        'admin_id',
        'locations',
    ];

    protected $casts = [
        'work_time' => 'array',
        'locations' => 'array'
    ];

    public function service()
    {
        return $this->belongsToMany('App\Models\Service', 'salon_service', 'salon_id');
    }
}
