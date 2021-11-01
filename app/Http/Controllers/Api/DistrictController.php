<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\District\DistrictRepository;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    protected $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function index(Request $request)
    {
        $district = $this->districtRepository->search($request->only(['province', 'page']));

        return response()->json($district);
    }
}
