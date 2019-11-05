<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Excel;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Department;
use App\Export;

define("ALL_STAFF", 1);
define("IS_ROOT", 1);
define("IS_MANAGER", 1);
define("IN_DEPARTMENT", 2);
define("IS_STAFF", 0);

class ExportController extends Controller
{
    /**
     * Xuất toàn bộ nhân viên ra file excel
     */
    public function exportStaff()
    {
        if (auth()->user()->role != IS_ROOT) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi bạn không có quyền này đâu nạ.',
            ]);
        }
        if (User::all()->count() == 0) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Phòng này chưa có nhân viên cậu ei.',
            ]);
        }
        return Excel::download(new Export(ALL_STAFF, null, null), 'danh-sach-nhan-vien.xlsx');
    }

    /**
     * Xuất toàn bộ nhân viên của 1 phòng ban
     * @param id của phòng ban
     * @return excel file
     */
    public function exportStaffFromDepartment(Department $department)
    {
        if (auth()->user()->role != IS_ROOT && !$department->users->contains(auth()->user()->id)) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi bạn không có quyền này đâu nạ.',
            ]);
        }
        if ($department->users->count() == 0) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Phòng này chưa có nhân viên cậu ei.',
            ]);
        }
        $manage = $department->users()->find(auth()->user()->id);
        if($manage)
            if ($manage->pivot->permission == IS_MANAGER || auth()->user()->role == IS_ROOT) {
                return Excel::download(new Export(IN_DEPARTMENT, $department, IS_ROOT), 'danh sách nhân viên phòng ' . $department->name . '.xlsx');
            }
        return Excel::download(new Export(IN_DEPARTMENT, $department, IS_STAFF), 'danh sách nhân viên phòng ' . $department->name . '.xlsx');
    }
}
