<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Recruitment\UpdateRequest;
use App\Http\Requests\Admin\Recruitment\CreateRequest;
use App\Models\Recruitment;
use App\Models\RecruitmentCategory;
use App\Repositories\Employer\EmployerRepository;
use App\Repositories\Province\ProvinceRepository;
use App\Repositories\Recruitment\RecruitmentRepository;
use Illuminate\Http\Request;
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
        $recruitment = $this->recruitmentRepository->getListRecruitmentFilterEmployer($request->all());
        $province = $this->provinceRepository->getListProvinceByRecruit();

        return view('employer.recruitment.index', compact('recruitment', 'province'));
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

        return \view('employer.recruitment.create', compact('provinces', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $params = $request->all();
        
        $this->recruitmentRepository->createRecruitment($params);

        return redirect()->route('employer.recruitment.index');
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

        return view('employer.recruitment.edit', compact('recruitment', 'provinces', 'categories'));
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
        $data = $request->all();
        $data['id'] = $id;
        
        $this->recruitmentRepository->updateRecruitment($data);

        return redirect()->route('employer.recruitment.index');
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
        
        return redirect()->route('employer.recruitment.index');
    }

}
