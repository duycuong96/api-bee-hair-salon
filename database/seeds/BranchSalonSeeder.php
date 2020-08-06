<?php

use Illuminate\Database\Seeder;

class BranchSalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\BranchSalon::class, 20)->create();
    }
}
