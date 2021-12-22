<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $verification_code = strtoupper(substr(md5(microtime()), rand(0, 26), 6));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'verification_code' => $verification_code,
            'status' => UserStatus::PENDING
        ]);

        $data = [
            'name' => $user->name,
            'body' => $verification_code,
            'mail' => $user->email,
            'password' => $request->password
        ];

        $to_email = $user->email;

        Mail::send('mail.verify', $data, function ($message) use ($to_email) {
            $message->to($to_email)->subject('Gửi mail mã xác nhận đăng ký tài khoản');
            $message->from('support@job-hunter.com', 'Jobs Hunt');
        });

        Auth::login($user);

        return redirect()->route('user.profile');
    }

    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function resend()
    {
        if (auth('user')->user()) {
            $verification_code = strtoupper(substr(md5(microtime()), rand(0, 26), 6));
            $user = User::find(auth('user')->user()->id);
            $user->update([
                'verification_code' => $verification_code
            ]);
            // dd($user);
            $to_email = $user->email;
            $data = [
                'name' => $user->name,
                'body' => $verification_code,
                'mail' => $user->email,
                'password' => 'null'
            ];

            Mail::send('mail.verify', $data, function ($message) use ($to_email) {
                $message->to($to_email)->subject('Gửi lại mail mã xác nhận tài khoản');
                $message->from('support@job-hunter.com', 'Jobs Hunt');
            });

            return true;
        }

        return abort(404);
    }

    public function verify(Request $request)
    {
        $user = User::find(auth('user')->user()->id);
        if ($user->verification_code == $request->code) {
            $user->update([
                'email_verified_at' => Carbon::now(),
                'verification_code' => null,
                'status' => UserStatus::ACTIVE
            ]);

            return redirect()->route('user.profile');;
        } else {
            return redirect()->back()->with('error', 'Verification code is wrong');
        }
    }
}
