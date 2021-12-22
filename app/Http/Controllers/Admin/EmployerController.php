<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employer\Update as EmployerUpdateRequest;
use App\Http\Requests\Admin\Employer\Create as EmployerCreateRequest;
use App\Models\Staff;
use App\Models\Employer;
use App\Models\Application;
use App\Models\Recruitment;
use App\Repositories\Employer\EmployerRepository;
use App\Repositories\Province\ProvinceRepository;


class EmployerController extends Controller
{
    protected $employerRepository;
    protected $provinceRepository;

    public function __construct(
        EmployerRepository $employerRepository,
        ProvinceRepository $provinceRepository
    ) {
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
            $filename = Storage::disk('s3')->put('employer', $request->thumbnail, '');
            $attributes['thumbnail'] = $filename;
        }
        if ($request->hasFile('public')) {
            $filename = Storage::disk('s3')->put('avatars', $request->avatar, '');
            $attributes['avatar'] = $filename;
        }
        $attributes['status'] = 1;

        $employers = Employer::create($attributes);
        $request['employer_id'] = $employers->id;
        $to_email = $request->email;
        $data = [
            'mail' => $to_email,
            'password' => $request->password,
            'name' => $request->name
        ];
        Mail::send('mail.create-employer', $data, function ($message) use ($to_email) {
            $message->to($to_email)->subject('Gửi thông báo tạo nhà tuyển dụng');
            $message->from('vocaoky290999@gmail.com', 'Jobs Hunt');
        });
        $credentials = $request->only(['phone', 'password', 'email', 'name', 'phone_verified_at', 'employer_id']);
        Staff::create($credentials);

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

        return view('admin.employers.edit', \compact('employer', 'provinces'));
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
            $filename = Storage::disk('s3')->put('employer', $request->thumbnail, '');
            $attributes['thumbnail'] = $filename;
            if ($employer->thumbnail) {
                Storage::disk('s3')->delete($employer->thumbnail);
            }
        } else {
            unset($attributes['thumbnail']);
        }

        if ($request->hasFile('avatar')) {
            $filename = Storage::disk('s3')->put('avatars', $request->avatar, '');
            $attributes['avatar'] = $filename;
            if ($employer->avatar) {
                Storage::disk('s3')->delete($employer->avatar);
            }
        } else {
            unset($attributes['avatar']);
        }

        if ($request->filled('password')) {
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
        $id = $employer->id;
        Application::where('employer_id', $id)->delete();
        Recruitment::where('employer_id', $id)->delete();
        Staff::where('employer_id', $id)->delete();
        $employer->delete();

        return redirect()->back();
    }

    public function requestForm()
    {
        $employers = $this->employerRepository
            ->where('status', 0)
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
