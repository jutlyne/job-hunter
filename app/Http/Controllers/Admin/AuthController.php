<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginCounter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\UserSystemInfoHelper;
use App\Repositories\Login\LoginRepository;

class AuthController extends Controller
{
    protected $loginRepository;

    public function __construct(LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->remember;

        if (auth('admin')->attempt($credentials, $remember)) {
            $name = auth('admin')->user()->name;
            $data = $this->loginRepository->loginInfo();
            $data['user_name'] = $name;
            
            LoginCounter::create($data);

            return redirect()->intended(route('admin.dashboard'));
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth('store')->logout();
    
        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()->intended(route('admin.login'));
    }
}
