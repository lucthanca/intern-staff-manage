<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\User;
use App\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
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
     * Phòng ban địa khu
     */
    public function departmentIndex()
    {
        // Nếu người dùng đăng nhập lần đầu thì kich ra màn hình đổi mật khẩu
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        // Nếu người dùng đăng nhập lần đầu thì kich ra màn hình đổi mật khẩu
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        if (auth()->user()->role != 1) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Bạn không có quyền vào trang đó đâu na !',
            ]);
        }
        return view('departments.create');
    }

    public function store(DepartmentRequest $r)
    {
        // Nếu người dùng đăng nhập lần đầu thì kich ra màn hình đổi mật khẩu
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        if (auth()->user()->role != 1) {
            return abort(401);
        }
        $department = Department::create([
            'name' => $r->name,
            'description' => request()->description ?? null,
        ]);
        if (!$department) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi bạn không có quyền này đâu nạ.',
            ]);
        }
        return redirect('/department');
    }

    /**
     * Hiển thị form cập nhật
     */
    public function edit(Department $department)
    {
        // Nếu người dùng đăng nhập lần đầu thì kich ra màn hình đổi mật khẩu
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        if (auth()->user()->role != 1) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi bạn không có quyền này đâu nạ.',
            ]);
        }
        return view('departments.edit', compact('department'));
    }

    /**
     * Thực hiện vêicj cập nhật
     */
    public function update(DepartmentRequest $r)
    {
        // Nếu người dùng đăng nhập lần đầu thì kich ra màn hình đổi mật khẩu
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        if (auth()->user()->role != 1) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi bạn không có quyền này đâu nạ.',
            ]);
        }
        $depart = Department::find($r->id);
        if ($depart) {
            $depart->update([
                'name' => $r->name,
                'description' => $r->description ?? null,
            ]);
            return redirect('/department');
        }
    }

    /**
     * Thực hiện việc xoá phòng ban
     */
    public function deleteADepartment()
    {
        // Nếu người dùng đăng nhập lần đầu thì kich ra màn hình đổi mật khẩu
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        if (auth()->user()->role != 1) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi bạn không có quyền này đâu nạ.',
            ]);
        }
        $depart = Department::find(request()->id);
        if ($depart) {
            if ($depart->users()->count() > 0) {
                $depart->users()->detach();
            }
            if ($depart->delete()) {
                return response()->json([
                    'status' => 'success',
                ]);
            }
            return response()->json([
                'status' => 'somethings',
            ]);
        }
        return response()->json([
            'status' => 'failed',
        ]);
    }

    /**
     * Hiển thị phòng ban
     */
    public function showDepartment(Department $department)
    {
        // Nếu người dùng đăng nhập lần đầu thì kich ra màn hình đổi mật khẩu
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        /**
         * auth()->user()->departments->contains($department->id) --- Nếu user đang đăng nhập này có trong phòng ban này
         */
        if (auth()->user()->role != 1 && !auth()->user()->departments->contains($department->id)) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Bạn hong có quyền vào xem phòng ban này đâu nạ!',
            ]);
        }
        $staffs = $department->users()->orderBy('permission', 'desc')->paginate(10);
        return view('departments.showDepartment', compact('department', 'staffs'));
    }

    /**
     * Thêm các nhân viên vào phòng ban
     */
    public function addStaffToDepartment()
    {
        // Nếu người dùng đăng nhập lần đầu thì kich ra màn hình đổi mật khẩu
        if (auth()->user()->logged_flag == 0) {
            return view('components.changePass', ['status' => 0]);
        }
        if (request()->ajax()) {
            if (auth()->user()->role == 1) {
                $ids = request()->ids;
                $department = Department::find(request()->departmentId);
                $meiJia = [];
                if ($department) {
                    foreach ($ids as $id) {
                        // Kiểm tra xem nhân viên này đã có trong phòng hay chưa, nếu có rồi thì ko thêm nữa
                        if (!$department->users->contains($id))
                            $department->users()->attach($id, ['permission' => 0]);
                        else {
                            $user = User::find($id);
                            array_push($meiJia, $user->name);
                        }
                    }
                    if (count($meiJia) == count($ids)) {
                        return response()->json([
                            'status' => 3,
                        ]);
                    }
                    if (count($meiJia) > 0) {
                        return response()->json([
                            'status' => 2,
                            'data' => $meiJia,
                        ]);
                    }
                    return response()->json([
                        'status' => 1,
                    ]);
                }
                return response()->json([
                    'status' => 0,
                    'errorMsg' => 'Không tìm thấy phòng ban này nha'
                ]);
            } else {
                return response()->json([
                    'status' => 403,
                    'errorMsg' => 'Xin lỗi, bạn không có quyền này !'
                ]);
            }
        }
    }

    /**
     * Tìm kiếm nhân viên
     */
    public function searchStaff()
    {
        // Nếu request là ajax thì trả về json
        if (request()->ajax()) {
            $staffs = User::where('name', 'like', "%" . request()->name . "%")->get();
            $page = request()->page;
            if (request()->type) {
                return response()->json([
                    'html' => view('root.ajax_staff_search', compact('staffs'))->render(),
                ]);
            }
            return response()->json([
                'data' => $staffs,
            ]);
        }
    }

    /**
     * Đá 1 nhân viên khỏi phòng ban
     * @param id của user, id của phòng ban
     * @return response 
     */
    public function kickAStaff()
    {
        if (auth()->user()->role != 1) {
            return response()->json([
                'status' => 401,
                'errorMsg' => 'Xin lỗi bạn hỏng có quyền này đâu nhoé!',
            ]);
        }
        $department = Department::find(request()->departmentId);
        if (request()->ajax()) {
            if ($department) {
                if ($department->users()->detach(request()->userId)) {
                    return response()->json([
                        'status' => 200,
                    ]);
                }
                return response()->json([
                    'status' => 500,
                    'errorMsg' => 'Nhân viên này làm gì có trong đây ta?',
                ]);
            }
            return response()->json([
                'status' => 404,
                'errorMsg' => 'Kỳ lạ, sao không tìm thấy phòng ban này ta?',
            ]);
        }
    }

    /**
     * Hạ cấp 1 user thành nhân viên
     * @param id của user và phòng ban
     * @return response
     */
    public function setToStaff()
    {
        if (auth()->user()->role != 1) {
            return response()->json([
                'status' => 401,
                'errorMsg' => 'Bạn hỏng có quyền làm chuyện ấy đâu nhoé !',
            ]);
        }
        if (request()->ajax()) {
            $department = Department::find(request()->departmentId);
            if ($department) {
                if ($department->users->contains(request()->userId)) {
                    $department->users()->updateExistingPivot(request()->userId, ['permission' => 0]);
                    return response()->json([
                        'status' => 200,
                    ]);
                }
                return response()->json([
                    'status' => 4042,
                    'errorMsg' => 'Hỏng tìm thấy nhân viên này trong phòng đâu á!',
                ]);
            }
            return response()->json([
                'status' => 4041,
                'errorMsg' => 'Hỏng có tìm thấy phòng ban này',
            ]);
        }
    }

    /**
     * Kiểm tra xem trong phòng ban đã có quản lý hay chưa
     * @param id của phòng ban
     * @return response
     */
    public function hasManage()
    {
        $department = Department::find(request('departmentId'));
        if ($department) {
            if ($department->users()->where('permission', 1)->get()->count() > 0)
                return response()->json([
                    'status' => 401,
                    'errorMsg' => 'Phòng đã có quản lý.'
                ]);
            return response()->json([
                'status' => 200,
                'errorMsg' => 'Phòng chưa có quản lý',
            ]);
        }
        return response()->json([
            'status' => 404,
            'errorMsg' => 'Hỏng có tìm thấy phòng ban này',
        ]);
    }

    /**
     * Tăng cấp 1 user thành siêu cấp quản lý
     * @param id của user và id của phòng ban
     * @return response
     */
    public function setAsManage()
    {
        $a = 'ltc';
        if (auth()->user()->role != 1) {
            return response()->json([
                'status' => 401,
                'errorMsg' => 'Bạn hỏng có quyền làm chuyện ấy đâu nhoé !',
            ]);
        }
        if (request()->ajax()) {
            $department = Department::find(request()->departmentId);
            if ($department) {
                if (!$department->users->contains(request()->userId)) {
                    return response()->json([
                        'status' => 404,
                        'errorMsg' => 'Hỏng có tìm thấy nhân viên này trong phòng ban',
                    ]);
                }
                // Tìm người quản lý cũ và hạ cấp
                $oldManage = $department->users()->where('permission', 1)->first();
                if ($oldManage) {
                    $oldManage->departments()->updateExistingPivot($department->id, ['permission' => 0]);
                    // Tăng cấp cho người mới thánh quản lý
                    $department->users()->updateExistingPivot(request()->userId, ['permission' => 1]);
                } else {
                    $department->users()->updateExistingPivot(request()->userId, ['permission' => 1]);
                }
                return response()->json([
                    'status' => 200,
                    'name' => User::find(request()->userId)->name,
                ]);
            }
            return response()->json([
                'status' => 404,
                'errorMsg' => 'Hỏng có tìm thấy phòng ban này',
            ]);
        }
    }

    /**
     * Đá tập thể các nhân viên
     * @param mảng các id của nhân viên
     * @return response
     */
    public function multiKick()
    {
        if (auth()->user()->role != 1) {
            return response()->json([
                'status' => 401,
                'errorMsg' => 'Bạn hỏng có quyền làm chuyện ấy đâu nhoé !',
            ]);
        }
        $error = [];
        $department = Department::find(request()->departmentId);
        if ($department) {
            foreach (request()->ids as $id) {
                if ($department->users()->detach($id) == 0) {
                    array_push($error, $id);
                }
            }
            if (count($error) == 0) {
                return response()->json([
                    'status' => 200,
                ]);
            }
            if (count($error) == count(request()->ids)) {
                return response()->json([
                    'status' => 500,
                    'errorMsg' => 'Các nhân viên này không có trong phòng ban này',
                ]);
            } else {
                return response()->json([
                    'status' => 555,
                    'errorMsg' => 'Vài nhân viên này không có trong phòng ban này',
                    'data' => $error,
                ]);
            }
        }
        return response()->json([
            'status' => 4041,
            'errorMsg' => 'Hỏng có tìm thấy phòng ban này',
        ]);
    }

    /**
     * Tìm kiếm phòng ban
     * @param tên phòng ban
     * @return danh sách phòng ban
     */
    public function searchDepartment()
    {
        // Nếu request là ajax thì trả về json
        if (request()->ajax()) {
            $departments = Department::where('name', 'like', "%" . request()->name . "%")->get();
            if (request()->type) {
                return response()->json([
                    'html' => view('departments.departmentList', compact('departments'))->render(),
                ]);
            }
            return response()->json([
                'data' => $departments,
            ]);
        }
    }
}
