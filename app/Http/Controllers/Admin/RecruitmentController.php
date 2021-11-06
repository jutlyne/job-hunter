<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recruitment;
use App\Models\Employer;
use App\Models\RecruitmentCategory;
use App\Repositories\Employer\EmployerRepository;
use App\Repositories\Recruitment\RecruitmentRepository;
use App\Http\Requests\Admin\Recruitment\CreateRequest;
use App\Http\Requests\Admin\Recruitment\UpdateRequest;
use App\Repositories\Province\ProvinceRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RecruitmentController extends Controller
{
    protected $recruitmentRepository;
    protected $provinceRepository;
    protected $employerRepository;

    public function __construct(
        RecruitmentRepository $recruitmentRepository,
        ProvinceRepository $provinceRepository,
        EmployerRepository $employerRepository
    )
    {
        $this->recruitmentRepository = $recruitmentRepository;
        $this->provinceRepository = $provinceRepository;
        $this->employerRepository = $employerRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recruitment = $this->recruitmentRepository->getListRecruitmentFilter($request->all());
        $province = $this->provinceRepository->getListProvinceByRecruit();
        
        return view('admin.recruitment.index', compact('recruitment', 'province'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = $this->provinceRepository->all();
        $categories = RecruitmentCategory::get();
        $employers = $this->employerRepository->get();

        return \view('admin.recruitment.create', compact('provinces', 'categories', 'employers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $this->recruitmentRepository->createRecruitment($request->validated());

        return redirect()->route('admin.recruitment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recruitment = Recruitment::findOrFail($id);

        return response()->json(['data' => $recruitment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Recruitment $recruitment)
    {
        $provinces = $this->provinceRepository->all();
        $categories = RecruitmentCategory::get();
        $employers = $this->employerRepository->get();
        

        return view('admin.recruitment.edit', compact('recruitment', 'provinces', 'categories', 'employers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        
        $this->recruitmentRepository->updateRecruitment($data);

        return redirect()->route('admin.recruitment.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Storage::disk('public')->delete(Recruitment::findOrFail($id)->thumbnail);
        Recruitment::where(['id' => $id])->delete();
        
        return redirect()->route('admin.recruitment.index');
    }

    public function checkCat(Request $request)
    {
        return RecruitmentCategory::where('name', $request->category)->count();
    }

    public function createCat(Request $request)
    {
        $count = RecruitmentCategory::where('name', $request->category)->count();
        
        if ($count <= 0) {
            return RecruitmentCategory::create([
                'name' => $request->category,
                'icon' => \App\Enums\Icon::getDescription($request->icon)
            ]);
        } else {
            return false;
        }
    }

    public function getInfo($id)
    {
        $recruitment = Recruitment::findOrFail($id);

        return response()->json(['data' => $recruitment]);
    }
}
