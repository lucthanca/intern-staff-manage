<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\PasswordReset;
use Illuminate\Support\Carbon;

class LogoutUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        /**
         * Nếu nhân viên này có cờ đăng nhập bằng -1 ~ Reset mật khẩu 
         * thì buộc phải đăng xuất
         * */
        if ($user) {
            if ($user->logout) {
                $user->logout = false;
                $user->save();
                Auth::logout();
                return redirect('/login')->withErrors(['errorMsg' => 'Bạn có yêu cầu đổi mật khẩu từ root và bị buộc phải đăng xuất!']);
            }
        }
        return $next($request);
    }
}
