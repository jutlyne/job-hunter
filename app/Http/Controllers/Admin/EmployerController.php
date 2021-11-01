<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Staff;
use App\Repositories\Employer\EmployerRepository;
use App\Http\Requests\Admin\Employer\Update as EmployerUpdateRequest;
use App\Http\Requests\Admin\Employer\Create as EmployerCreateRequest;
use App\Repositories\Province\ProvinceRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class EmployerController extends Controller
{
    protected $employerRepository;
    protected $provinceRepository;

    public function __construct(
        EmployerRepository $employerRepository,
        ProvinceRepository $provinceRepository
    )
    {
        $this->employerRepository = $employerRepository;
        $this->provinceRepository = $provinceRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employers = $this->employerRepository->getListEmployerFilter($request->get('province_id'));
        $provinces = $this->provinceRepository->getListProvinceByEmployer();
        
        return view('admin.employers.index', compact('employers', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = $this->provinceRepository->all();

        return \view('admin.employers.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployerCreateRequest $request)
    {
        $request['phone_verified_at'] = Carbon::now();
        
        $attributes = $request->except(['password']);
        if ($request->hasFile('thumbnail')) {
            $filename = Storage::disk('public')->put('employer', $request->thumbnail, 'public');
            $attributes['thumbnail'] = $filename;
        }
        if ($request->hasFile('public')) {
            $filename = Storage::disk('public')->put('avatars', $request->avatar, 'public');
            $attributes['avatar'] = $filename;
        }
        $attributes['status'] = 1;

        $employers = Employer::create($attributes);
        $request['employer_id'] = $employers->id;
        $credentials = $request->only(['phone', 'password', 'name','phone_verified_at', 'employer_id']);

        $staff = Staff::create($credentials);
        return \redirect()->route('admin.employers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employers = $this->employerRepository->getInfo($id);

        return view('admin.employers.show', \compact('employers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provinces = $this->provinceRepository->all();
        $employer = $this->employerRepository->getInfo($id);

        return view('admin.employers.edit', \compact('employer','provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployerUpdateRequest $request, $id)
    {
        $employer = Employer::findOrFail($id);
        $attributes = $request->validated();
        $schedule = $request->only(['start_time', 'end_time', 'number_of_slots']);

        if ($request->hasFile('thumbnail')) {
            $filename = Storage::disk('public')->put('employer', $request->thumbnail, 'public');
            $attributes['thumbnail'] = $filename;
            if ($employer->thumbnail) {
                Storage::disk('public')->delete($employer->thumbnail);
            }
        } else {
            unset($attributes['thumbnail']);
        }

        if ($request->hasFile('avatar')) {
            $filename = Storage::disk('public')->put('avatars', $request->avatar, 'public');
            $attributes['avatar'] = $filename;
            if ($employer->avatar) {
                Storage::disk('public')->delete($employer->avatar);
            }
        } else {
            unset($attributes['avatar']);
        }

        if($request->filled('password')) {
            $hash = Hash::make($request->get('password'));
            Staff::where('employer_id', $employer->id)->update(['password' => $hash]);
        }
        $this->employerRepository->update($attributes, $employer->id);

        return \redirect()->route('admin.employers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employer $employer)
    {
        $employer->delete();

        return redirect()->back();
    }

    public function requestForm()
    {
        $employers = $this->employerRepository
                    ->where('status',0)
                    ->orWhereNull('status')
                    ->paginate(config('paginate.limit'));

        return view('admin.employers.request', compact('employers'));
    }

    public function updatePrioritize($id)
    {
        $employer = $this->employerRepository->getInfo($id);

        $this->employerRepository->changePrioritize($employer);
        
        return redirect()->back()->with('success', 'Kích hoạt ưu tiên cho employer thành công');
    }

    public function updateStatus($id)
    {
        $this->employerRepository->changeStatus($id);
        
        return redirect()->back()->with('success', 'Chuyển đổi trạng thái thành công');
    }
}
