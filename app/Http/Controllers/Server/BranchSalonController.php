<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchSalonRequest;
use App\Models\Admin;
use App\Models\BranchSalon;
use App\Models\Ward;
use App\Repositories\AddressRepository;
use App\Repositories\BranchSalonRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BranchSalonController extends Controller
{

    protected $addressRepository;
    protected $branchSalonRepository;

    public function __construct(BranchSalonRepository $branchSalonRepository, AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->branchSalonRepository = $branchSalonRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $branchSalons = $this->branchSalonRepository->all();
        return $branchSalons;
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
                'name'      => 'required|min:2|unique:branch_salons,name',
                'thumb_img' => 'required',
                'content'   => 'min:10',
                'work_time' => 'required|array',
                'address'   => 'required',
                'ward_id'   => 'required|numeric',
                'admin_id'  => 'required|numeric',
                'phone'     => 'required|min:10|max:14',
                'status'    => 'required',
            ],
            [
                'required'  => ":attribute không được để trống",
                'unique'    => ':attribute đã tồn tại',
                'min'       => ":attribute quá ngắn",
                'max'       => ":attribute không hợp lệ",
                'array'     => ":attribute không hợp lệ",
                'numeric'   => ":attribute không hợp lệ",
            ],
            [
                'name'      => "Tên đăng nhập",
                'thumb_img' => "Ảnh",
                'content'   => "Nội dung",
                'work_time' => "Giờ làm việc",
                'address'   => "Địa chỉ",
                'ward_id'   => "Phường xã",
                'admin_id'  => "Quyền",
                'phone'     => "Số điện thoại",
                'status'    => "Trạng thái Salon",
            ],
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $data = $request->all([
            'name',
            'thumb_img',
            'content',
            'work_time',
            'address',
            'phone',
            'status',
            'ward_id',
            'admin_id',
            'locations',
        ]);

        $ward = $this->addressRepository->getWardByCode($data['ward_id']);
        $admin = Admin::find($data['admin_id']);

        if (empty($ward)) {
            return response()->json(['ward_id' => "Phường xã không hợp lệ"], 422);
        }
        if (empty($admin)) {
            return response()->json(['admin_id' => "Bạn không có quyền để làm việc này"], 422);
        }

        $data['thumb_img'] = $request->file('thumb_img')->store('thumb_imgs', 'public');

        // dd($data['phones']);
        $branch = $this->branchSalonRepository->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Thêm chi nhánh Salon thành công',
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
        $branch = $this->branchSalonRepository->find($id);
        return $branch;
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
                'name' => 'required|min:2|unique:branch_salons,name',
                'thumb_img' => 'required',
                'content' => 'min:10',
                'work_time' => 'required',
                'address' => 'required',
                'locations' => 'required',
                'phone'     => 'required',
                'status'    => 'required',
            ],
            [
                'required' => ":attribute không được để trống",
                'unique' => ':attribute đã tồn tại',
                'min' => ":attribute quá ngắn",
            ],
            [
                'username' => "Tên đăng nhập",
                'thumb_img' => "Ảnh",
                'content' => "Nội dung",
                'work_time' => "Giờ làm việc",
                'address' => "Địa chỉ",
                'locations' => "Địa chỉ",
                'phone'     => "Số điện thoại",
                'status'    => "Trạng thái Salon",
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $data = $request->all([
            'name',
            'thumb_img',
            'content',
            'work_time',
            'address',
            'locations',
            'ward_id',
            'admin_id',
            'phone',
            'status',
        ]);

        $ward = $this->addressRepository->getWardByCode($data['ward_id']);
        $admin = Admin::find($data['admin_id']);

        if (empty($ward)) {
            return response()->json(['ward_id' => "Phường xã không hợp lệ"], 422);
        }
        if (empty($admin)) {
            return response()->json(['admin_id' => "Bạn không có quyền để làm việc này"], 422);
        }
        if ($request->file('image') != null) {
            $data['thumb_img'] = $request->file('thumb_img')->store('thumb_imgs', 'public');
        }

        $branch = $this->branchSalonRepository->update($data, $id);
        return $branch;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = $this->branchSalonRepository->delete($id);
        return $branch;
    }
}
