<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'full_name'=>'Cuong',
                'email'=>'cuong@gmail.com',
                'password' => Hash::make('123456'),
            ],
            [
                'full_name'=>'Phuoc',
                'email'=>'phuoc@gmail.com',
                'password' => Hash::make('123456'),
            ],
            [
                'full_name'=>'Khai',
                'email'=>'khai@gmail.com',
                'password' => Hash::make('123456'),
            ],
        ];
        foreach($datas as $data){
            $admin = Admin::create($data);
        }
    }
}
