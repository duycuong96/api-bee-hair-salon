<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BranchSalonRepository;

class BranchSalonController extends Controller
{
    public function __construct(BranchSalonRepository $branchSalonRepository)
    {
        $this->BranchSalonRepository = $branchSalonRepository;
    }

    public function index()
    {
        $branchSalons = $this->BranchSalonRepository->all();
        return $branchSalons;
    }

    public function show($id)
    {
        $branch = $this->BranchSalonRepository->find($id);
        return $branch;
    }
}
