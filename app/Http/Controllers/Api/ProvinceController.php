<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Province\ProvinceCollection;
use App\Repositories\Province\ProvinceRepository;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    protected $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    public function index(Request $request)
    {
        $provinces = $this->provinceRepository->getProvinces($request->all());

        return new ProvinceCollection($provinces);
    }
}
