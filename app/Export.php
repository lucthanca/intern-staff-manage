<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Export extends Model implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $type, $department;

    public function __construct($type, $department)
    {
        $this->type = $type;
        $this->department = $department;
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
        $this->type == 1 ? $staffs = User::all() : $staffs = $this->department->users;

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
                '8' => $this->type == 1 ? $row->created_at : $row->pivot->permission == 1 ? 'Quản lý' : 'Nhân viên',
            );
        }
        return (collect($staff));
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tài khoản',
            'Email',
            'Tên',
            'Ngày sinh',
            'Địa chỉ',
            'Thành phố',
            'Số điện thoại',
            $this->type == 1 ? 'Ngày tạo' : 'Chức vụ',
        ];
    }
}
