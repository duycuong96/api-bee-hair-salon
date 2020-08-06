<?php

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerTableSeeeder extends Seeder
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
                'ward_id' => '1',
            ],
            [
                'full_name'=>'Phuoc',
                'email'=>'phuoc@gmail.com',
                'password' => Hash::make('123456'),
                'ward_id' => '1',
            ],
            [
                'full_name'=>'Khai',
                'email'=>'khai@gmail.com',
                'password' => Hash::make('123456'),
                'ward_id' => '1',
            ],
        ];
        foreach($datas as $data){
            $customer = Customer::create($data);
        }
    }
}
