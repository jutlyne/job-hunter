<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\Update;
use App\Models\UserProfile;
use App\Repositories\Province\ProvinceRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    protected $userRepository;
    protected $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->provinceRepository = $provinceRepository;
    }

    public function index()
    {
        $user = auth('user')->user();
        $provinces = $this->provinceRepository->all();

        return view('user.profile.index', compact('user','provinces'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = auth('user')->user()->id;
        $userId = ['user_id' => $id];

        if(UserProfile::updateOrCreate($userId, $data))
        {
            return redirect()->back()->with('success', 'Update successful');
        }
        
        return redirect()->back()->withErrors('error', 'Update failed!');
    }

    public function password()
    {
        $user = auth('user')->user();

        return view('user.profile.password', compact('user'));
    }

    public function passwordChange(Update $request)
    {
        $this->userRepository->updateProfile($request->validated(), auth('user')->user());
        
        return redirect()->back()->with('success', 'Change password successfully');
    }
}
