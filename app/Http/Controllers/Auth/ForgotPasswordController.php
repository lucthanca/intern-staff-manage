<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\PasswordReset;
use Illuminate\Support\Str;
use App\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.forgotPassword');
    }

    public function sendResetPasswordMail()
    {
        $user = User::where('email', request()->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Hong có tìm thấy email nàyyyy',
            ]);
        }

        $passwordReset = PasswordReset::where('email', $user->email)->first();
        // Nếu có tokken cũ thì xoá
        if ($passwordReset) {
            $passwordReset->delete();
        }

        $passwordReset = PasswordReset::create([
            'email' => $user->email,
            'token' => Str::random(60),
        ]);
        // Nếu tạo thành công token
        if ($passwordReset) {
            // Gửi mail đến user
            Mail::to($user->email, $user->name)
                ->send(new ResetPasswordMail($user, $passwordReset->token, 1));
            // Trả kq 
            return redirect('login');
        }
        return redirect()->back()->withErrors([
            'errorMsg' => 'Có lỗi gì đó! Vui lòng thử lại',
        ]);
    }

    public function showFormResetPassword($token)
    {
        // Nếu có người đang đăng nhập thì logout người đó ra
        if (auth()->user()) {
            auth()->logout();
        }
        $passwordReset = PasswordReset::where('token', $token)->first();
        // Kiểm tra xem mã token có tồn tại hay nhập bừa
        if ($passwordReset) {
            // Mã token sống 3 ngày
            if (Carbon::parse($passwordReset->updated_at)->addMinutes(30)->isPast()) {
                // Xoá token
                $passwordReset->delete();
                return view('errors.tokenTimeOut');
            }
            return view('auth.resetPassword', ['status' => -1, 'token' => $passwordReset->token]);
        } else {
            return view('errors.tokenTimeOut', ['status' => 'not found']);
        }
    }
}
