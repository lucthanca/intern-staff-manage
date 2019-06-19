<?php

namespace App\Http\Controllers\User;

use App\Models\Root;
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

class RootController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass');
        } else {
            return view('root.index');
        }
    }

    public function StaffIndex()
    {

        if (Gate::allows('view-staff-manage')) {
            if (auth()->user()->logged_flag == 0) {
                return view('components.changePass');
            } else {
                dd(auth()->user()->logged_flag);
                $staffs = User::paginate(10);
                return view('root.staff_index', compact('staffs'));
            }
        } else {
            abort(401);
        }
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
        $user = User::create([
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
    public function show(Root $root)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function edit(Root $root)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Root $root)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function destroy(Root $root)
    {
        //
    }
}
