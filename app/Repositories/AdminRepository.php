<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
    public function getById($id)
    {
        return Admin::find($id);
    }

    public function update(Admin $admin, array $data)
    {
        if (!empty($data['full_name'])) {
            $admin->full_name = $data['full_name'];
        }

        if (!empty($data['avatar'])) {
            $admin->avatar = $data['avatar'];
        }

        if (!empty($data['dob'])) {
            $admin->dob = $data['dob'];
        }

        if (!empty($data['phone'])) {
            $admin->phone = $data['phone'];
        }

        if (!empty($data['address'])) {
            $admin->address = $data['address'];
        }

        if (!empty($data['password'])) {
            $admin->password = $data['password'];
        }
        $admin->save();
        return $admin;
    }
}
