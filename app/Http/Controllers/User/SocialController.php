<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LoginCounter;
use App\Models\Social;
use App\Models\User;
use App\Repositories\Login\LoginRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Enums\UserStatus;
use App\Repositories\User\UserRepository;

class SocialController extends Controller
{
    protected $loginRepository;
    protected $userRepository;

    public function __construct(LoginRepository $loginRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->loginRepository = $loginRepository;
    }

    public function login_google()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        $users = Socialite::driver('google')->stateless()->user();
        $authUser = User::where('email', $users->email)->first();
        session()->put('email', $users->email);
        
        if (!$authUser) {
            $authUser = User::create([
                'name' => $users->name,
                'email' => $users->email,
                'provider_id' => $users->id,
                'provider' => 'google',
                'password' => null,
                'phone' => '',
                'status' => UserStatus::PENDING
            ]);

            return view('auth.create_password');
        } elseif ($authUser->status == UserStatus::PENDING) {
            return view('auth.create_password');
        }

        auth('user')->login($authUser);

        $name = auth('user')->user()->name;
        $data = $this->loginRepository->loginInfo();
        $data['user_name'] = $name;

        LoginCounter::create($data);

        return redirect()->intended(route('user.home'));
    }

    public function showPasswordForm()
    {
        if (Session()->get('email')) {
            return view('auth.create_password');
        } else {
            return redirect()->intended(route('user.home'));
        }
    }

    public function create_password(Request $request)
    {
        $email = Session()->get('email');

        $user = $this->userRepository->findWhere(['email' => $email])->first();

        $user->update([
            'password' => $request->password,
            'status' => UserStatus::ACTIVE,
        ]);

        Session()->forget('email');
        
        auth('user')->login($user);

        $name = auth('user')->user()->name;
        $data = $this->loginRepository->loginInfo();
        $data['user_name'] = $name;

        LoginCounter::create($data);

        return redirect()->intended(route('user.home'));
    }
}
