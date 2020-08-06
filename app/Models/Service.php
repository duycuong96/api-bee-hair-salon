<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Service extends Model
{
    use Sluggable;

    protected $table = 'services';
    protected $fillable = [
        'name',
        'slugs',
        'detail',
        'service_id',
        'images',
        'price',
        'sale_price',
        'astimate'
    ];
    protected $casts = ['images' => 'array'];
    public $timestamps = false;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slugs' => [
                'source' => 'name'
            ]
        ];
    }
}
