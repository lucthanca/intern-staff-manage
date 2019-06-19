<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'min:8', 'max:16','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[
            'username.required'=>'Tên đăng nhập không được để trống',
            'username.min'=>'Độ dài tối thiểu :min ký tự',
            'username.max'=>'Độ dài tối đa :max ký tự',
            'username.unique'=>'Tênn đăng nhập đã tồn tại trong hệ thống',
            'email.required'=>':attributes không được để trống',
            'email.email'=>'Hãy nhập đúng định dạng mail',
            'email.max'=>'Độ dài tối đa :max ký tự',
            'email.unique'=>':attributes đã tồn tại trong hệ thống',
            'password.required'=>'Không nhập mật khẩu là không được đâu ra',
            'password.min'=>'Độ dài mật khẩu tối thiểu :min ký tự nhé',
            'password.confirmed'=>'Mật khẩu xác nhận không khớp',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
