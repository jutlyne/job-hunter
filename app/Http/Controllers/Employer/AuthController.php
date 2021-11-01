<?php

namespace App\Http\Controllers\Employer;

use App\Models\Staff;
use App\Http\Controllers\Controller;
use App\Models\LoginCounter;
use App\Repositories\Login\LoginRepository;
use App\Repositories\Staff\StaffRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $staffRepository;
    protected $loginRepository;
    
    public function __construct(StaffRepository $staffRepository, LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
        $this->staffRepository = $staffRepository;
    }

    public function showLoginForm()
    {
        return view('employer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth('store')->attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Verify information entered incorrectly.',
            ]);
        }
        if (!auth('store')->user()->employer) {
            return back()->withErrors([
                'email' => 'Account has been locked.',
            ]);
        }

        $name = auth('store')->user()->name;
        $data = $this->loginRepository->loginInfo();

        $data['user_name'] = $name;
            
        LoginCounter::create($data);

        return redirect()->intended(route('employer.dashboard'));
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

        return redirect()->intended(route('employer.login'));
    }

    // public function passwordUpdate(PasswordUpdateRequest $request)
    // {
    //     $user = \auth('store')->user();
    //     $currentPassword = $request->input('current_password');
    //     if(!Hash::check($currentPassword, $user->password)) {
    //         return \redirect()->back()->withErrors([
    //             'password' => 'Mật khẩu không đúng.',
    //         ]);
    //     }
    //     $user->password = $request->input('password');
    //     $user->save();
    //     return \redirect()->back()->with('success', 'Đổi mật khẩu thành công');
    // }

    public function showRecoverPasswordForm($code)
    {
        $staff = $this->staffRepository->findWhere(['recover_pass' => $code])->first();
        if ($staff) {
            return view('auth.employer.password.reset', compact('code'));
        } else {
            return redirect()->route('user.home');
        }
    }

    public function showResetPasswordForm()
    {
        if (Session()->get('emailReset')) {
            return view('auth.employer.password.reset');
        } else {
            return redirect()->route('user.home');
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.employer.password.forgot');
    }

    public function sendForgotPasswordCode(Request $request)
    {
        $email = $request->email;
    
        $checkEmail = Staff::where('email', $email)->count();

        if ($checkEmail == 1) {
            $codeReset = strtoupper(substr(md5(microtime()), rand(0, 26), 6));
            $aEmail = md5($email) . $codeReset;

            $staff = $this->staffRepository->findWhere(['email' => $request->email])->first();
        
            $links = route('employer.password.recover.show', $aEmail);
            // dd($links);
            if ($staff) {
                $data = [
                    'name' => $staff->name,
                    'body' => $codeReset,
                    'links' => $links
                ];
                $to_email = $request->email;
                Mail::send('mail.reset-password', $data, function ($message) use ($to_email) {
                    $message->to($to_email)->subject('Gửi mail mã xác nhận đặt lại mật khẩu');
                    $message->from('vocaoky290999@gmail.com', 'Jobs Hunt');
                });
                $staff->update([
                    'reset_password_code' => $codeReset,
                    'recover_pass' => $aEmail
                ]);
                $request->session()->put('emailReset', $email);
                $request->session()->put('code', $codeReset);
                return redirect()->route('employer.password.reset.show');
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
            $staff = $this->staffRepository->findWhere(['recover_pass' => $email])->first();

            $staff->update([
                'password' => $request->password,
                'reset_password_code' => null,
                'recover_pass' => null
            ]);
            auth('store')->login($staff);
    
            return redirect()->route('staff.home');
        } else {
            $email = Session()->get('emailReset');
            $staff = $this->staffRepository->findWhere(['email' => $email])->first();
            
            if ($staff->reset_password_code == $code) {
                $staff->update([
                    'password' => $request->password,
                    'reset_password_code' => null,
                    'recover_pass' => null
                ]);
                auth('store')->login($staff);
                $name = auth('store')->user()->name;
                $data = $this->loginRepository->loginInfo();

                $data['user_name'] = $name;
                    
                LoginCounter::create($data);
                return redirect()->route('employer.dashboard');
            } else {
                return redirect()->route('employer.password.reset.show')->with('msg', 'The verification code is not correct');
            }
        }
    }
    
    public function avatarUpdate(Request $request)
    {
        $this->validate($request, ['avatar' => 'required|mimes:jpeg,png,jpg,gif,svg',]);
        $employer = auth('store')->user()->employer;
        $filename = Storage::disk('public')->put('avatars', $request->avatar, 'public');
        if ($employer->avatar) {
            Storage::disk('public')->delete($employer->avatar);
        }
        $employer->avatar = $filename;
        $employer->save();

        return redirect()->route('employer.profile.index')->with('success', 'Update avatar successfully');
    }
}
