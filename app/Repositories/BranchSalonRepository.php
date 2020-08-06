<?php

namespace App\Repositories;

use App\Models\BranchSalon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchSalonRepository
{
    public function all()
    {
        $length = request()->input('length', 9);
        $branchSalons = BranchSalon::paginate($length);

        return response()->json([
            'status' => true,
            'data' => $branchSalons,
        ]);
    }

    public function create(array $data)
    {
        $branch = BranchSalon::create($data);
        return $branch;
    }

    public function find($id)
    {

        $branch = BranchSalon::find($id);
        if (empty($branch)) {
            return response()->json([
                'status' => false,
                'message' => 'Khong ton tai'
            ]);
        }
        return  response()->json([
            'status' => true,
            'data' => $branch
        ]);
    }
    public function update($data, $id)
    {
        $branch = BranchSalon::find($id);
        // dd($data);
        $branch->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật chi nhánh Salon thành công',
        ]);
    }

    public function delete($id)
    {
        $branch = BranchSalon::find($id);
        if (empty($branch)) {
            return response()->json([
                'status' => false,
                'message' => 'Khong ton tai'
            ]);
        }
        $branch->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xoá chi nhánh Salon thành công',
        ]);
    }
}
