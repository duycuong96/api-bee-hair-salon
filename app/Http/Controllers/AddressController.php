<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AddressRepository;
class AddressController extends Controller
{

    protected $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function province(Request $request)
    {
        $code = $request->input('code', null);
        $provinces = $this->addressRepository->getProvince($code);
        return response()->json([
            'status' => 'success',
            'data' => $provinces->toArray()
        ]);
    }

    public function district(Request $request)
    {
        $districtCode = $request->input('code', null);
        $provinceCode = $request->input('province', null);
        $districts = $this->addressRepository->getDistrict($districtCode, $provinceCode);
        return response()->json([
            'status' => 'success',
            'data' => $districts->toArray()
        ]);
    }

    public function ward(Request $request)
    {
        $wardCode = $request->input('code', null);
        $districtCode = $request->input('district', null);
        $wards = $this->addressRepository->getWard($wardCode, $districtCode);
        return response()->json([
            'status' => 'success',
            'data' => $wards->toArray()
        ]);
    }
}
