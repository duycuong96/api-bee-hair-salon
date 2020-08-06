<?php

namespace App\Http\Controllers\server;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    protected $serviceRepository;
    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        $service = $this->serviceRepository->all();
        return response()->json([
            'status' => true,
            'data' => $service,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name'          => 'required|min:2|max:255|unique:services,name',
                'slugs'         => 'required|min:2|max:255',
                'detail'        => 'min:10',
                'service_id'    => 'required',
                'images'        => 'required',
                'price'         => 'required|numeric',
                'sale_price'    => 'required|numeric',
                'estimate'      => 'required',
            ],
            [
                'required'      => ":attribute không được để trống",
                'unique'        => ':attribute đã tồn tại',
                'min'           => ":attribute quá ngắn",
                'max'           => ":attribute qúa dài",
                'array'         => ":attribute không hợp lệ",
                'numeric'       => ":attribute không hợp lệ",
            ],
            [
                'name'          => "Tên dịch vụ",
                'slugs'         => "Ảnh",
                'detail'        => "Chi tiết dịch vụ",
                'service_id'    => "Loại dịch vụ",
                'images'        => "Ảnh dịch vụ",
                'price'         => "Giá",
                'sale_price'    => "Giá sau khi giảm",
                'estimate'      => "Thời gian",
            ],
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $data = $request->all([
            'name',
            'slugs',
            'detail',
            'service_id',
            'images',
            'price',
            'sale_price',
            'estimate',
        ]);
        $service = $this->serviceRepository->find($data['service_id']);

        if (empty($service)) {
            return response()->json(['service_id' => "Dịch vụ không tồn tại"], 422);
        }
        $arrayImage = array();
        if ($data['images'] != null) {
            foreach ($data['images'] as $key => $image) {
                $images = $image->store('salon_images', 'public');
                array_push($arrayImage, $images);
            }
            $data['images'] = $arrayImage;
        }

        $branch = $this->serviceRepository->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Thêm dịch vụ thành công',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = $this->serviceRepository->find($id);
        return response()->json([
            'status' => true,
            'data' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name'          => 'required|min:2|max:255|unique:branch_salons,name',
                'slugs'         => 'required|min:2|max:255',
                'detail'        => 'min:10',
                'service_id'    => 'required',
                // 'images'        => 'required',
                'price'         => 'required|numeric',
                'sale_price'    => 'required|numeric',
                'estimate'      => 'required',
            ],
            [
                'required'      => ":attribute không được để trống",
                'unique'        => ':attribute đã tồn tại',
                'min'           => ":attribute quá ngắn",
                'max'           => ":attribute qúa dài",
                'array'         => ":attribute không hợp lệ",
                'numeric'       => ":attribute không hợp lệ",
            ],
            [
                'name'          => "Tên dịch vụ",
                'slugs'         => "Ảnh",
                'detail'        => "Chi tiết dịch vụ",
                'service_id'    => "Loại dịch vụ",
                'images'        => "Ảnh dịch vụ",
                'price'         => "Giá",
                'sale_price'    => "Giá sau khi giảm",
                'estimate'      => "Thời gian",
            ],
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $data = $request->all([
            'name',
            'slugs',
            'detail',
            'service_id',
            'images',
            'price',
            'sale_price',
            'estimate',
        ]);

        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            return response()->json(['service_id' => "Dịch vụ không tồn tại"], 422);
        }
        // $arrayImage = array();
        // if ($data['images'] != null) {
        //     foreach ($data['images'] as $key => $image) {
        //         $images = $image->store('salon_images', 'public');
        //         array_push($arrayImage, $images);
        //     }
        //     $data['images'] = $arrayImage;
        // }

        $service = $this->serviceRepository->update($data, $id);
        return $service;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = $this->serviceRepository->delete($id);
        return $branch;
    }
}
