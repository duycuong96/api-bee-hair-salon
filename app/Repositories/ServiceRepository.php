<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository
{

    public function all()
    {
        $length = request()->input('length', 10);
        $service = Service::paginate($length);
        return $service;
    }
    public function create($data)
    {
        $service = Service::create($data);
        return $service;
    }

    public function find($id)
    {
        $service = Service::find($id);
        if (empty($service)) {
            return response()->json([
                'status' => false,
                'message' => 'Dịch vụ không tồn tại',
            ]);
        }
        return $service;
    }
    public function update($data, $id)
    {
        $service = Service::find($id);
        $service->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật dịch vụ thành công',
        ]);
    }

    public function query($options = [])
    {
        $query = Service::query();
        if (!empty($options['slugs'])) {
            $query->where('slugs', $options['slugs']);
        }
        return $query;
    }

    public function delete($id)
    {

        $service = Service::find($id);
        if (empty($service)) {
            return response()->json([
                'status' => false,
                'message' => 'Dịch vụ không tồn tại',
            ]);
        }
        $service->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xoá chi nhánh Salon thành công',
        ]);
    }
}
