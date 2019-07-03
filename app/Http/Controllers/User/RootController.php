<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Mail\NewStaff;
use Illuminate\Support\Facades\Mail;
use App\PasswordReset;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Carbon;

class RootController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['showFormResetPassword', 'resetPswd']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        } else if (auth()->user()->logged_flag == -1) {
            $passwordReset = PasswordReset::where('email', auth()->user()->email)->first();
            // Kiểm tra token hết hạn hay chưa
            if ($passwordReset) {
                // Mã token sống 3 ngày
                if (Carbon::parse($passwordReset->updated_at)->addDays(3)->isPast()) {
                    // Xoá token
                    $passwordReset->delete();
                    return view('errors.tokenTimeOut');
                }
                return view('components.changePass', ['status' => -1, 'token' => $passwordReset->token]);
            } else {
                return view('errors.tokenTimeOut');
            }
        } else {
            return view('root.index');
        }
    }

    public function ajaxLoadStaff()
    {
        $staffs = User::where('id', '!=', (auth()->user()->id))->paginate(10);
        // Lấy biến page để đẩy ra ngoài view
        $page = request()->page;
        if (request()->ajax()) {
            return response()->json([
                'html' => view('root.ajax_staff_index', compact('staffs', 'page'))->render(),
            ]);
        }
    }

    public function StaffIndex()
    {
        // cho phép người có quyền truy cập vào Nhân viên
        if (Gate::allows('view-staff-manage')) {
            // nếu người đăng nhập lần đầu thì bay sang bên đổi mk
            if (auth()->user()->logged_flag == 0) {
                return view('components.changePass', ['status' => 0]);
            } else {
                $staffs = User::where('id', '!=', (auth()->user()->id))->paginate(10);
                return view('root.staff_index', compact('staffs'));
            }
        } else {
            abort(401);
        }
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
            if (Carbon::parse($passwordReset->updated_at)->addDays(3)->isPast()) {
                // Xoá token
                $passwordReset->delete();
                return view('errors.tokenTimeOut');
            }
            return view('components.changePass', ['status' => -1, 'token' => $passwordReset->token]);
        } else {
            return view('errors.tokenTimeOut', ['status' => 'not found']);
        }
    }

    public function resetPswd()
    {
        // Nếu có người đang đăng nhập thì logout người đó ra
        if (auth()->user()) {
            auth()->logout();
        }
        $data = request()->validate(
            [
                'password' => ['required', 'min:8', 'max:255', 'confirmed'],
            ],
            [
                'password.required' => 'Hãy nhập :attributes',
                'password.min' => ':attributes yêu cầu tối thiểu :min ký tự',
                'password.max' => ':attributes tối đa :max ký tự',
                'password.confirmed' => ':attributes xác nhận không giống',
            ],
            [
                'password' => 'Mật khẩu'
            ]
        );
        $token = request()->token;
        $passwordReset = PasswordReset::where('token', $token)->first();
        // Kiểm tra xem mã token có tồn tại hay nhập bừa
        if ($passwordReset) {
            // Mã token sống 3 ngày
            if (Carbon::parse($passwordReset->updated_at)->addDays(3)->isPast()) {
                // Xoá token
                $passwordReset->delete();
                return view('errors.tokenTimeOut');
            }
            // lấy ra user cần cập nhật mk
            $user = User::where('email', $passwordReset->email)->first();
            // Cập nhật mk
            $user->update([
                'password' => Hash::make($data['password']),
                'logged_flag' => 1,
            ]);
            // Xoá token
            $passwordReset->delete();
            return redirect('/');
        } else {
            // Không tìm thấy return về notfound
            return view('errors.tokenTimeOut', ['status' => 'not found']);
        }
    }

    public function resetPasswordFirst()
    {
        // Validate input
        $data = request()->validate(
            [
                'password' => ['required', 'min:8', 'max:255', 'confirmed'],
            ],
            [
                'password.required' => 'Hãy nhập :attributes',
                'password.min' => ':attributes yêu cầu tối thiểu :min ký tự',
                'password.max' => ':attributes tối đa :max ký tự',
                'password.confirmed' => ':attributes xác nhận không giống',
            ],
            [
                'password' => 'Mật khẩu'
            ]
        );
        $user = User::find(auth()->user()->id);
        $user->update(
            [
                'password' => Hash::make($data['password']),
                'logged_flag' => 1,
            ]
        );
        return redirect('/');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $randomPassword = Str::random(8);
        return view('root.create', compact('randomPassword'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->validate(
            [
                'username' => ['required', 'string', 'max:32', 'unique:users', 'min:3'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'max:255'],
            ],
            [
                'username.required' => ':attribute không được để trống',
                'username.min' => ':attributes tối thiểu :min ký tự',
                'username.max' => ':attributes chỉ được tối đa :max ký tự',
                'username.unique' => ':attributes đã tồn tại trong hệ thống',
                'email.required' => ':attribute không được để trống',
                'email.email' => 'Hãy nhập đúng định dạng là email',
                'email.max' => ':attributes nhận tối đa :max ký tự',
                'email.unique' => ':attributes đã tồn tại trong hệ thống',
                'password.required' => ':attribute không được để trống',
                'password.min' => ':attributes tối thiểu :min ký tự',
                'password.max' => ':attributes tối đa :max ký tự'
            ],
            [
                'username' => 'Tên đăng nhập',
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );
        if (request()->has('image')) {
            $imagePath = request()->image->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }
        $user = User::updateOrCreate([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'name' => request()->name ?? null,
            'birthday' => request()->birthday ?? null,
            'address' => request()->address ?? null,
            'city' => request()->city ?? null,
            'image' => $imageArray['image'] ?? null,
            'phone' => request()->phone ?? null,
        ]);

        if ($user) {
            $password = request()->password;;
            Mail::to($user->email)->send(new NewStaff($password));
            return redirect('/staff');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('root.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $data = request()->validate(
            [
                'username' => ['required', 'string', 'max:32', 'unique:users,username,' . request()->id, 'min:3'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . request()->id],
            ],
            [
                'username.required' => ':attribute không được để trống',
                'username.min' => ':attributes tối thiểu :min ký tự',
                'username.max' => ':attributes chỉ được tối đa :max ký tự',
                'username.unique' => ':attributes đã tồn tại trong hệ thống',
                'email.required' => ':attribute không được để trống',
                'email.email' => 'Hãy nhập đúng định dạng là email',
                'email.max' => ':attributes nhận tối đa :max ký tự',
                'email.unique' => ':attributes đã tồn tại trong hệ thống',
                'password.required' => ':attribute không được để trống',
                'password.min' => ':attributes tối thiểu :min ký tự',
                'password.max' => ':attributes tối đa :max ký tự'
            ],
            [
                'username' => 'Tên đăng nhập',
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]

        );
        $user = User::find(request()->id);
        if (request()->has('image')) {
            $imagePath = request()->image->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }
        $user->update([
            'username' => $data['username'],
            'email' => $data['email'],
            'name' => request()->name ?? null,
            'birthday' => request()->birthday ?? null,
            'address' => request()->address ?? null,
            'city' => request()->city ?? null,
            'image' => $imageArray['image'] ?? null,
            'phone' => request()->phone ?? null,
        ]);
        return redirect('/staff');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    { }

    public function deleteA()
    {
        $user = User::find(request('id'));
        if ($user->delete())
            return response()->json([
                'status' => 'success',
                // Đẩy page về view
                'page' => request('page'),
            ]);
    }

    // Gửi email reset mật khẩu
    public function sendEmailReset(User $user)
    {
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
            'token' => Str::random(60),
        ]);
        if ($passwordReset) {
            $user->logged_flag = -1;
            $user->save();
            Mail::to($user->email, $user->name)
                ->send(new ResetPasswordMail($user, $passwordReset->token));
        }

        return redirect('/staff/');
        // return view('emails.resetPassword-email');
    }
}
