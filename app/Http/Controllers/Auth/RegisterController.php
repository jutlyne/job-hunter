<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\Verify\VerifyCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Nexmo\Laravel\Facade\Nexmo;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $to = substr_replace($request->phone, '+84', 0, 1);
        $code = rand(100000,1000000);
        $ads = \session()->has('ads') ? \session()->pull('ads') : null;

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password,
            'verification_code' => $code,
            'ads' => $ads
        ]);

        Nexmo::message()->send([
            'to' => $to,
            'from' => config('app.name'),
            'text' => "Code: $code",
            'type' => 'unicode'
        ]);

        Auth::login($user);

        return redirect()->route('user.verify');
    }

    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function sendCodeVerify()
    {
        $user = auth('user')->user();
        $to = substr_replace($user->phone, '+84', 0, 1);
        $code = rand(100000,1000000);

        Nexmo::message()->send([
            'to' => $to,
            'from' => config('app.name'),
            'text' => "Code: $code",
            'type' => 'unicode'
        ]);

        $user->update(['verification_code' => $code]);

        return response()->json([], 200);
    }

    public function verify(VerifyCode $request)
    {
        $user = auth('user')->user();

        $user->update([
            'phone_verified_at' => Carbon::now(),
            'verification_code' => null
        ]);

        return redirect('/');
    }

    public function updateDeviceId(Request $request)
    {
        $user = auth('user')->user();
        $user->device_id = $request->input('id');
        $user->save();
        return \response()->json([], 200);
    }
}
