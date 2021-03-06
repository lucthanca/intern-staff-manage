<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Export extends Model implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $type, $department, $permission;

    public function __construct($type, $department, $permission)
    {
        $this->type = $type;
        $this->department = $department;
        $this->permission = $permission;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $e) {
                $cellRange = 'A1:W1';
                $e->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            }
        ];
    }

    public function collection()
    {
        $this->type == ALL_STAFF ? $staffs = User::all() : $staffs = $this->department->users;
        if ($this->type == ALL_STAFF) {
            foreach ($staffs as $row) {
                if ($row->role != IS_ROOT) {
                    $staff[] = array(
                        '0' => $row->id,
                        '1' => $row->username,
                        '2' => $row->email,
                        '3' => $row->name,
                        '4' => $row->birthday,
                        '5' => $row->address,
                        '6' => $row->city,
                        '7' => $row->phone,
                        '8' => $row->created_at
                        //'8' => $this->type == ALL_STAFF ? $row->created_at : $row->pivot->permission == IS_MANAGER ? 'Quản lý' : 'Nhân viên',
                    );
                }
            }
        } else {
            if ($this->permission == IS_MANAGER) {
                foreach ($staffs as $row) {
                    $staff[] = array(
                        '0' => $row->id,
                        '1' => $row->username,
                        '2' => $row->email,
                        '3' => $row->name,
                        '4' => $row->birthday,
                        '5' => $row->address,
                        '6' => $row->city,
                        '7' => $row->phone,
                        '8' => $row->pivot->permission == IS_MANAGER ? 'Quản lý' : 'Nhân viên',
                        //'8' => $this->type == ALL_STAFF ? $row->created_at : $row->pivot->permission == 1 ? 'Quản lý' : 'Nhân viên',
                    );
                }
            } else {
                foreach ($staffs as $row) {
                    $staff[] = array(
                        '0' => $row->id,
                        '3' => $row->name,
                        '8' => $row->pivot->permission == IS_MANAGER ? 'Quản lý' : 'Nhân viên',
                        //'8' => $this->type == ALL_STAFF ? $row->created_at : $row->pivot->permission == 1 ? 'Quản lý' : 'Nhân viên',
                    );
                }
            }
        }
        return (collect($staff));
    }

    public function headings(): array
    {
        return $this->type == ALL_STAFF || $this->permission == IS_MANAGER ? [
            'ID',
            'Tài khoản',
            'Email',
            'Tên',
            'Ngày sinh',
            'Địa chỉ',
            'Thành phố',
            'Số điện thoại',
            $this->type == ALL_STAFF ? 'Ngày tạo' : 'Chức vụ',
        ] : [
            'ID',
            'Tên',
            'Chức vụ',
            //$this->type == ALL_STAFF ? 'Ngày tạo' : 'Chức vụ',
        ];
    }
}
