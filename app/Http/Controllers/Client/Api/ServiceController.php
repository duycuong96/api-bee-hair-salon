<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ServiceRepository;

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

    public function show($id)
    {
        $service = $this->serviceRepository->find($id);
        return response()->json([
            'status' => true,
            'data' => $service,
        ]);
    }
}
