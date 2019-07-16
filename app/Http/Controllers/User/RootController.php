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
use Illuminate\Support\Facades\Storage;
use App\Department;
use Illuminate\Support\Facades\Validator;

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
        // dd(request());
        // $ids = request()->departments;
        // dd($ids);
        $data = request()->validate(
            [
                'username' => ['required', 'string', 'max:32', 'unique:users', 'min:3'],
                'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-z][a-z0-9_\.]{2,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/i', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'max:255'],
            ],
            [
                'username.required' => ':attribute không được để trống',
                'username.min' => ':attribute tối thiểu :min ký tự',
                'username.max' => ':attribute chỉ được tối đa :max ký tự',
                'username.unique' => ':attribute đã tồn tại trong hệ thống',
                'email.required' => ':attribute không được để trống',
                'email.email' => 'Hãy nhập đúng định dạng là email',
                'email.max' => ':attribute nhận tối đa :max ký tự',
                'email.unique' => ':attribute đã tồn tại trong hệ thống',
                'email.regex' => 'hãy nhập đúng dạng :attribute - bắt đầu bằng chữ cái độ dài 3 ký tự trước @',
                'password.required' => ':attribute không được để trống',
                'password.min' => ':attribute tối thiểu :min ký tự',
                'password.max' => ':attribute tối đa :max ký tự'
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
        try {
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
                Mail::to($user->email)->send(new NewStaff($password, $user));
                return redirect('/staff');
            }
        } catch (Exception $e) {
            Storage::delete('/public/' . $imageArray['image']);
            return redirect()->back()->withErrors(['errorMsg' => 'Có lỗi phát sinh, vui lòng kiểm tra lại!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // Biến cờ xác định xem 2 người có chung phòng ban không!
        $flag = 0;
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        // Nếu auth đang là user đó hoặc là root thì cho phép xem
        if (auth()->user()->id == $user->id || auth()->user()->role == 1) {
            return view('root.profile', compact('user'));
        }
        // nếu người này không có trong phòng ban @return lỗi
        if ($user->departments->count() > 0) {
            // Duyệt lần lượt từng phòng ban của người muốn xem
            foreach ($user->departments as $depart) {
                // nếu user đang đăng nhập ko có trong phòng ban @return lỗi
                if (auth()->user()->departments->count() > 0) {
                    // Duyệt lần lượt từng phòng ban của người đang đăng nhập
                    foreach (auth()->user()->departments as $authDepart) {
                        // Nếu 2 người này trong cùng 1 phòng ban và người đang đăng nhập là quản lý
                        if ($depart->id == $authDepart->id && auth()->user()->departments->find($authDepart->id)->pivot->permission == 1) {
                            $flag++;
                        }
                    }
                } else
                    return redirect()->back()->withErrors([
                        'errorMsg' => 'Bạn không được phép xemn người này!',
                    ]);
            }
            // kiểm tra biến cờ
            if ($flag > 0) {
                return view('root.profile', compact('user'));
            }
            return redirect()->back()->withErrors([
                'errorMsg' => 'Bạn không được phép xemn người này!',
            ]);
        }
        return redirect()->back()->withErrors([
            'errorMsg' => 'Bạn không được phép xemn người này!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        if (auth()->user()->role == 1 || auth()->user()->id == $user->id)
            return view('root.edit', compact('user'));
        return redirect()->back()->withErrors([
            'errorMsg' => 'Bạn không có quyền chỉnh sửa người này đâuuuuuu!',
        ]);
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
        if ($user->image) {
            Storage::delete('/public/' . $user->image);
        }
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
     * Người dùng cập nhật tên và địa chỉ
     */
    public function updateNameAddressBirthdayAndPhone()
    {
        // Tìm ra user
        $user = User::find(request()->id);
        if ($user) {
            // nếu tài khoản đăng nhập hiện tại là root hoặc chính người dùng đó thì mới có quyền sửa
            if (auth()->user()->role != 1 && auth()->user()->id != $user->id) {
                return response()->json([
                    'msg' => 'Xin lỗi nhoé! Bạn hổng có quyền này đâu nạ !',
                ]);
            }
            if (auth()->user()->role == 1) {
                $rules = [
                    'name' => ['required', 'string', 'max:255'],
                    'city' => ['required', 'string', 'max:255'],
                    'birthday' => ['required', 'date_format:Y-m-d'],
                    'phone' => ['required', 'regex:/((\+84|84|0)[9|3])+([0-9]{8})\b/i'],
                    'username' => ['required', 'string', 'max:32', 'unique:users,username,' . $user->id, 'min:3'],
                    'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-z][a-z0-9_\.]{2,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/i', 'unique:users,email,' . $user->id],
                ];
                $messages = [
                    'name.required' => ':attribute không được để trống',
                    'name.string' => 'Hãy nhập vào đúng định dạng chữ',
                    'name.max' => ':attributes chỉ được tối đa :max ký tự',
                    'city.required' => ':attribute không được để trống',
                    'city.string' => 'Hãy nhập vào đúng định dạng chữ',
                    'city.max' => ':attributes chỉ được tối đa :max ký tự',
                    'birthday.required' => ':attribute không được để trống',
                    'birthday.date_format' => 'Hãy nhập đúng định dạng cho ngày sinh nhé',
                    'phone.required' => ':attribute không được để trống',
                    'phone.regex' => 'Hãy nhập đúng định dạng cho :attribute, 10 số đầu 03 09 hoặc 11 số với 84, +84',
                    'username.required' => ':attribute không được để trống',
                    'username.min' => ':attribute tối thiểu :min ký tự',
                    'username.max' => ':attribute chỉ được tối đa :max ký tự',
                    'username.unique' => ':attribute đã tồn tại trong hệ thống',
                    'email.required' => ':attribute không được để trống',
                    'email.email' => 'Hãy nhập đúng định dạng là email',
                    'email.max' => ':attribute nhận tối đa :max ký tự',
                    'email.unique' => ':attribute đã tồn tại trong hệ thống',
                    'email.regex' => 'hãy nhập đúng dạng :attribute - bắt đầu bằng chữ cái độ dài 3 ký tự trước @',
                ];
                $attrNames = [
                    'name' => 'Tên',
                    'city' => 'Thành phố',
                    'birthday' => 'Ngày sinh',
                    'phone' => 'Số điện thoại',
                    'username' => 'Tên đăng nhập',
                    'email' => 'Email',
                ];
                $validator = Validator::make(request()->all(), $rules, $messages, $attrNames);
                if ($validator->fails()) {
                    return response()->json([
                        'msg' => $validator->errors()->first(),
                    ]);
                }
                $user->update([
                    'username' => request()->username,
                    'email' => request()->email,
                    'name' => request()->name,
                    'birthday' => request()->birthday,
                    'address' => request()->address ?? null,
                    'city' => request()->city,
                    'phone' => request()->phone,
                ]);
                return response()->json([
                    'user' => $user,
                    'status' => 'success',
                ]);
            }
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'birthday' => ['required', 'date_format:Y-m-d'],
                'phone' => ['required', 'regex:/((\+84|84|0)[9|3])+([0-9]{8})\b/i'],
            ];
            $messages = [
                'name.required' => ':attribute không được để trống',
                'name.string' => 'Hãy nhập vào đúng định dạng chữ',
                'name.max' => ':attributes chỉ được tối đa :max ký tự',
                'city.required' => ':attribute không được để trống',
                'city.string' => 'Hãy nhập vào đúng định dạng chữ',
                'city.max' => ':attributes chỉ được tối đa :max ký tự',
                'birthday.required' => ':attribute không được để trống',
                'birthday.date_format' => 'Hãy nhập đúng định dạng cho ngày sinh nhé',
                'phone.required' => ':attribute không được để trống',
                'phone.regex' => 'Hãy nhập đúng định dạng cho :attribute, 10 số đầu 03 09 hoặc 11 số với 84, +84',
            ];
            $attrNames = [
                'name' => 'Tên',
                'city' => 'Thành phố',
                'birthday' => 'Ngày sinh',
                'phone' => 'Số điện thoại',
            ];
            $validator = Validator::make(request()->all(), $rules, $messages, $attrNames);
            // Nếu validate lỗi thì đẩy thông báo ra màn hình
            if ($validator->fails()) {
                return response()->json([
                    'msg' => $validator->errors()->first(),
                ]);
            }

            $user->update([
                'name' => request()->name,
                'address' => request()->address ?? null,
                'city' => request()->city,
                'birthday' => request()->birthday,
                'phone' => request()->phone,
            ]);
            return response()->json([
                'user' => $user,
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'msg' => 'Có gì đó sai sai nha, Không tìm thấy người dùng này',
            ]);
        }
    }
    /**
     * Câpj nhật avatar
     */
    public function updateAvatar()
    {
        // Tìmnguowfi dùng có id 
        $user = User::find(request()->id);
        if (auth()->user()->role != 1 && auth()->user()->id != $user->id) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi bạn không có quyền này đâu nạ.',
            ]);
        }
        if ($user) {
            // nếu người dùng upload ảnh
            if (request()->has('image')) {
                // Nếu người dùng đã có ảnh trước đó thì xoá đi
                if ($user->image) {
                    Storage::delete('/public/' . $user->image);
                }
                // Lưu ảnh mới vào
                // echo "<pre>"; var_dump(request()->image);die;
                $imagePath = request()->image->store('uploads', 'public');
                $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
                $image->save();
                $imageArray = ['image' => $imagePath];
                // nếu có lỗi khi update thì xoá ảnh đã up đi
                try {
                    $user->update([
                        'image' => $imageArray['image'],
                    ]);
                    return redirect()->back();
                } catch (Exception $e) {
                    Storage::delete('/public/' . $imageArray['image']);
                    return redirect()->back()->withErrors([
                        'errorMsg' => 'Có lỗi gì đó kỳ kỳ lạ lạ xảy ra.',
                    ]);
                }
            } else {
                return redirect()->back()->withErrors([
                    'errorMsg' => 'Hãy chọn ảnh',
                ]);
            }
        }
        return redirect()->back()->withErrors([
            'errorMsg' => 'Không thấy người dùng này nha.',
        ]);
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
        if ($user) {
            if ($user->delete())
                return response()->json([
                    'status' => 'success',
                    // Đẩy page về view
                    'page' => request('page'),
                ]);
            return response()->json([
                'status' => 'failed',
                // Đẩy page về view
                'page' => request('page'),
            ]);
        }
    }

    // Xoá nhiều nhân viên
    public function multiDelete()
    {
        // danh sách mảng id
        $ids = request('ids');
        // lỗi
        $errors = [];
        foreach ($ids as $id) {
            $user = User::find($id);
            if ($user) {
                $rs = $this->deleteUser($user);
                if ($rs == 0) {
                    array_push($errors, $user->id);
                }
            }
        }
        if (count($errors) == count($ids)) {
            return response()->json([
                'status' => 'failed',
                // Đẩy page về view
                'page' => request('page'),
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                // Đẩy page về view
                'page' => request('page'),
                // đẩy danh sách lỗi nếu có
                'errors' => $errors,
            ]);
        }
    }

    // Hàm xoá nhân viên
    public function deleteUser($user)
    {
        if ($user->delete())
            return 1;
        return 0;
    }

    // Gửi email reset mật khẩu
    public function sendEmailReset()
    {
        if (auth()->user()->role != 1) {
            // Nẻu request gửi đến là dùng ajax thì return về json còn ko thì return về http
            if (request()->ajax()) {
                return response()->json([
                    'errorMsg' => 'Xin lỗi, bạn không có quyền làm chuyện này đâu nhé! Hi...',
                ]);
            }
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi, bạn không có quyền làm chuyện này đâu nhé! Hi...',
            ]);
        }
        $user = User::find(request('id'));
        // Nếu tìm được user
        if ($user) {
            // Gọi hàm gửi mail
            $result = $this->sendMailTo($user);
            if ($result == 1) {
                return response()->json([
                    'status' => 'true',
                ]);
            } else {
                return response()->json([
                    'status' => 'false',
                    'user' => $result,
                ]);
            }
        }
        // return view('emails.resetPassword-email');
    }

    public function sendMultiEmailReset()
    {
        $errors = [];
        // Lấy danh sách id
        $ids = request('ids');
        foreach ($ids as $id) {
            $user = User::find($id);
            // Nếu tìm được user
            if ($user) {
                // Gọi hàm gửi mail
                $result = $this->sendMailTo($user);
                dd($result);
                if ($result != 1) {
                    array_push($errors, $result);
                }
            }
        }
        if (count($errors) == count($ids)) {
            return response()->json([
                'status' => 'false',
            ]);
        }
        return response()->json([
            'status' => 'true',
            'errors' => $errors,
        ]);
    }

    // chức năng gửi mail
    public function sendMailTo($user)
    {
        $passwordReset = PasswordReset::where('email', $user->email)->first();
        if ($passwordReset) {
            $passwordReset->delete();
        }

        $passwordReset = PasswordReset::create([
            'email' => $user->email,
            'token' => Str::random(60),
        ]);

        // Nếu tạo thành công token
        if ($passwordReset) {
            // set trạng thái đăng nhập về -1 -reset pass
            $user->logged_flag = -1;
            $user->save();
            // Gửi mail đến user
            Mail::to($user->email, $user->name)
                ->send(new ResetPasswordMail($user, $passwordReset->token));
            // Trả kq 
            return 1;
        }
        return $user->id;
    }
}
