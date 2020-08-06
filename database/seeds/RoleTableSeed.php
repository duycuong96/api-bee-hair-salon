<?php

use Illuminate\Database\Seeder;

class RoleTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create([
            'name' => 'Full Admin',
            'slugs' => 'full_admin',
            'permissions' => ['isAdmin' => true, 'salon.*' => true]
        ]);

        \App\Models\Role::create([
           'name' => 'Editor',
            'slugs' => 'editor',
            'permissions' => ['salon.*' => true]
        ]);
    }
}
