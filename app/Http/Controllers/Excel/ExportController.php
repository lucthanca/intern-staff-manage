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

class ExportController extends Controller
{
    /**
     * Xuất toàn bộ nhân viên ra file excel
     */
    public function exportStaff()
    {
        if (auth()->user()->role != 1) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Xin lỗi bạn không có quyền này đâu nạ.',
            ]);
        }
        if (User::all()->count() == 0) {
            return redirect()->back()->withErrors([
                'errorMsg' => 'Phòng này chưa có nhân viên cậu ei.',
            ]);
        }
        return Excel::download(new Export(1, null, null), 'danh-sach-nhan-vien.xlsx');
    }

    /**
     * Xuất toàn bộ nhân viên của 1 phòng ban
     * @param id của phòng ban
     * @return excel file
     */
    public function exportStaffFromDepartment(Department $department)
    {
        if (auth()->user()->role != 1 && !$department->users->contains(auth()->user()->id)) {
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
        if ($manage->pivot->permission == 1 || auth()->user()->role == 1) {
            return Excel::download(new Export(2, $department, 1), 'danh sách nhân viên phòng ' . $department->name . '.xlsx');
        }
        return Excel::download(new Export(2, $department, 0), 'danh sách nhân viên phòng ' . $department->name . '.xlsx');
    }
}
