<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployerImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Employer\ProfileRequest;
use App\Repositories\Employer\EmployerRepository;
use App\Http\Requests\Employer\SosEmployerRequest;
use App\Repositories\Province\ProvinceRepository;

class ProfileController extends Controller
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

    public function index()
    {
        $employer = auth('store')->user()->employer;
        $provinces = $this->provinceRepository->all();
        
        return view('employer.profile', compact('employer', 'provinces'));
    }

    public function update(Request $request)
    {
        $employerId = auth('store')->user()->employer_id;
        $attributes = $request->all();

        if ($request->thumbnail) {
            $image = base64_decode($request->thumbnail);
            $filename = Str::random(16);
            $f = finfo_open();
            $extension = finfo_buffer($f, $image, FILEINFO_EXTENSION);
            $filename = "Employers/$filename.$extension";
            Storage::disk('public')->put($filename, $image, 'public');
            $attributes['thumbnail'] = $filename;
            $employer = $this->employerRepository->find($employerId);
            if ($employer->thumbnail) {
                Storage::disk('public')->delete($employer->thumbnail);
            }
        } else {
            unset($attributes['thumbnail']);
        }
        $this->employerRepository->update($attributes, $employerId);
        return redirect(route('employer.profile.index'))->with('success', 'Update successful');
    }

    public function uploadBanner(Request $request)
    {
        $employerId = auth('store')->user()->employer_id;
        if ($request->banner) {
            $filename = Storage::disk('public')->put('employers', $request->banner, 'public');
            $attributes['thumbnail'] = $filename;
            $employer = $this->employerRepository->find($employerId);
            $employer->images()->create([
                'url' => $filename,
            ]);

            return redirect()->back()->with('success', 'Successfully added photo');
        } else {
            return redirect()->back()->withErrors('Add photo failed');
        }
    }

    public function deleteBanner($id)
    {
        $img = EmployerImage::where('id', $id)->delete();
        if ($img) {
            return redirect()->back()->with('success', 'Delete photo successfully');
        }

        return redirect()->back()->withErrors('Deleting failed photos');
    }
}
