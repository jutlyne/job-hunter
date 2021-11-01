<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LoginCounter;
use App\Models\User;
use App\Repositories\Login\LoginRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Nexmo\Laravel\Facade\Nexmo;

class AuthController extends Controller
{
    protected $userRepository;
    protected $loginRepository;

    public function __construct(UserRepository $userRepository, LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
        $this->userRepository = $userRepository;
    }

    public function showLoginOption()
    {
        return view('auth.login_option');
    }

    public function showLoginForm(Request $request)
    {
        if($request->filled('redirect')) {
            \redirect()->setIntendedUrl($request->get('redirect'));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->remember;

        if (auth('user')->attempt($credentials, $remember)) {
            $name = auth('user')->user()->name;
            $data = $this->loginRepository->loginInfo();
            $data['user_name'] = $name;
            
            LoginCounter::create($data);

            return redirect()->intended(route('user.profile'));
        }
        return redirect()->back()->with('error', 'The provided credentials do not match our records.');

    }

    public function showForgotPasswordForm()
    {
        return view('auth.password.forgot');
    }

    public function showRecoverPasswordForm($code)
    {
        $user = $this->userRepository->findWhere(['email_md5' => $code])->first();
        if ($user) {
            return view('auth.password.reset', compact('code'));
        } else {
            return redirect()->route('user.home');
        }
    }

    public function showResetPasswordForm()
    {
        if (Session()->get('emailReset')) {
            return view('auth.password.reset');
        } else {
            return redirect()->route('user.home');
        }
    }

    public function sendForgotPasswordCode(Request $request)
    {
        $email = $request->email;
    
        $checkEmail = User::where('email', $email)->count();

        if ($checkEmail == 1) {
            $codeReset = strtoupper(substr(md5(microtime()), rand(0, 26), 6));
            $aEmail = md5($email) . $codeReset;
            // dd($aEmail);
            $user = $this->userRepository->findWhere(['email' => $request->email])->first();
        
            $links = route('user.password.recover.show', $aEmail);
            // dd($links);
            if ($user) {
                $data = [
                    'name' => $user->name,
                    'body' => $codeReset,
                    'links' => $links
                ];
                $to_email = $request->email;
                Mail::send('mail.reset-password', $data, function ($message) use ($to_email) {
                    $message->to($to_email)->subject('Gửi mail mã xác nhận đặt lại mật khẩu');
                    $message->from('vocaoky290999@gmail.com', 'Jobs Hunt');
                });
                $user->update([
                    'reset_password_code' => $codeReset,
                    'email_md5' => $aEmail
                ]);
                $request->session()->put('emailReset', $email);
                $request->session()->put('code', $codeReset);
                return redirect()->route('user.password.reset.show');
            }
        } else {
            return redirect()->back()->with('error', 'Email does not exist on the system.');
        }
    }

    public function resetPassword(Request $request)
    {
        $code = $request->reset_password_code;
        if (isset($request->email)) {
            $email = $request->email;
            $user = $this->userRepository->findWhere(['email_md5' => $email])->first();

            $user->update([
                'password' => $request->password,
                'reset_password_code' => null,
                'email_md5' => null
            ]);
            auth('user')->login($user);
    
            return redirect()->route('user.profile');
        } else {
            $email = Session()->get('emailReset');
            $user = $this->userRepository->findWhere(['email' => $email])->first();
            
            if ($user->reset_password_code == $code) {
                $user->update([
                    'password' => $request->password,
                    'reset_password_code' => null,
                    'email_md5' => null
                ]);
                
                auth('user')->login($user);
        
                return redirect()->route('user.profile');
            } else {
                return redirect()->route('user.password.reset.show')->with('msg', 'The verification code is not correct');
            }
        }
        // if ($user->reset_password_code == $code) {
        //     $user->update([
        //         'password' => $request->password,
        //         'reset_password_code' => null,
        //     ]);
        //     auth('user')->login($user);
    
        //     return redirect()->route('user.home');
        // } else {
        //     return redirect()->route('user.password.reset.show')->with('msg', 'The verification code is not correct');
        // }
        // $code = $request->reset_password_code;
        // $email = Session()->get('emailReset');

        // if ($code == Session()->get('code')) {
        //     $user = $this->userRepository->findWhere(['email' => $email])->first();

        //     $user->update([
        //         'password' => $request->password,
        //         'reset_password_code' => null,
        //     ]);
        //     session()->invalidate();

        //     auth('user')->login($user);

        //     return redirect()->route('user.home');
        // } else {
        //     return redirect()->route('user.password.reset.show')->with('msg', 'The verification code is not correct');
        // }
    }

    public function logout(Request $request)
    {
        Session::flush();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();
        
        auth('user')->logout();

        return redirect()->route('user.login');
    }
}
