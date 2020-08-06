<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Role extends Model
{
    use Sluggable;
    protected $table = 'roles';
    protected $fillable = [
        'id', 'name', 'slugs', 'permissions'
    ];
    protected $casts = [
        'permissions' => 'array'
    ];

    public function admins(){
        return $this->belongsToMany(Admin::class, 'role_admin');
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions): bool
    {
        foreach($permissions as $permission){
            if ($this->hasPermission($permission)){
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function sluggable(): array
    {
        return [
            'slugs' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * check exists permission
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission){
        return $this->permissions[$permission] ?? false;
    }
}
