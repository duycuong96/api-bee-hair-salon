<?php


namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class CustomerRepository
{
    public function getCustomerByEmail($email)
    {
        $customer = Customer::where('email', $email)->first();
        return empty($customer) ? [] : $customer;
    }

    public function getCustomerByToken($token)
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $customer = Customer::where('token_hash', $token)->where('token_expired', '>', $date)->first();
        return empty($customer) ? [] : $customer;
    }

    public function getCustomerById($id)
    {
        return Customer::find($id);
    }

    public function update(Customer $customer, array $data)
    {
        if (!empty($data['full_name'])) {
            $customer->full_name = $data['full_name'];
        }

        if (!empty($data['avatar'])) {
            $customer->avatar = $data['avatar'];
        }

        if (!empty($data['birthday'])) {
            $customer->birthday = $data['birthday'];
        }

        if (!empty($data['phone'])) {
            $customer->phone = $data['phone'];
        }

        if (!empty($data['address'])) {
            $customer->address = $data['address'];
        }

        if (!empty($data['ward_id'])) {
            $customer->ward_id = $data['ward_id'];
        }

        if (!empty($data['password'])) {
            $customer->password = $data['password'];
        }
        $customer->save();
        return $customer;
    }

    public function delete(Customer $customer)
    {
        return $customer->delete();
    }
}
