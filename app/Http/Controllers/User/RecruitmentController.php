<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use App\Models\RecruitmentCategory;
use App\Repositories\Province\ProvinceRepository;
use App\Repositories\Recruitment\RecruitmentRepository;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    protected $recruitmentRepository;
    protected $provinceRepository;

    public function __construct(RecruitmentRepository $recruitmentRepository, ProvinceRepository $provinceRepository)
    {
        $this->recruitmentRepository = $recruitmentRepository;
        $this->provinceRepository = $provinceRepository;
    }

    public function index(Request $request)
    {
        $recruitment = $this->recruitmentRepository->getListRecruitmentUser($request->all());
        $province = $this->recruitmentRepository->getProvince();
        
        return view('user.recruitment.index', compact('recruitment', 'province'));
    }

    public function detail(Recruitment $recruitment)
    {
        $recruits = Recruitment::where('id', '<>', $recruitment->id)->take(3)->get();
        
        return view('user.recruitment.detail', compact('recruitment', 'recruits'));
    }
}
