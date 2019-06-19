@extends('master')



@section('content')

<!-- Dark table -->
<div class="container-fluid mt-3">

    <div class="row">
        <div class="col">
            <a href="/new-staff/" class="btn btn-outline-primary"><i class="fas fa-plus-circle    "></i> Thêm nhân
                viên</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card bg-default shadow">
                <div class="card-header bg-transparent border-0">
                    <h3 class="text-white mb-0">Danh sách nhân viên</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-dark table-flush">
                        @if($staffs->isEmpty())
                        <h1>Không có bản ghi nào</h1>
                        @else
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">username</th>
                                <th scope="col">email</th>
                                <th scope="col">department</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($staffs as $staff)
                            @if($staff->id != auth()->user()->id)

                            
                            <tr><a href="#">
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            {{ $staff->id }}
                                        </div>
                                    </th>
                                    <td>
                                        {{ $staff->name ?? 'Chưa cập nhật tên' }}
                                    </td>
                                    <td>
                                        {{ $staff->username }}
                                    </td>
                                    <td>

                                        {{ $staff->email }}
                                        <!-- <div class="avatar-group">
                                        <a href="#" class="avatar avatar-sm" data-toggle="tooltip"
                                            data-original-title="Ryan Tompson">
                                            <img alt="Image placeholder" src="../assets/img/theme/team-1-800x800.jpg"
                                                class="rounded-circle">
                                        </a>
                                        <a href="#" class="avatar avatar-sm" data-toggle="tooltip"
                                            data-original-title="Romina Hadid">
                                            <img alt="Image placeholder" src="../assets/img/theme/team-2-800x800.jpg"
                                                class="rounded-circle">
                                        </a>
                                        <a href="#" class="avatar avatar-sm" data-toggle="tooltip"
                                            data-original-title="Alexander Smith">
                                            <img alt="Image placeholder" src="../assets/img/theme/team-3-800x800.jpg"
                                                class="rounded-circle">
                                        </a>
                                        <a href="#" class="avatar avatar-sm" data-toggle="tooltip"
                                            data-original-title="Jessica Doe">
                                            <img alt="Image placeholder" src="../assets/img/theme/team-4-800x800.jpg"
                                                class="rounded-circle">
                                        </a>
                                    </div> -->
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="#">Sửa</a>
                                                <a class="dropdown-item" href="#">Xoá</a>
                                            </div>
                                        </div>
                                    </td>
                                </a>
                            </tr>
                            @endif
                            @endforeach

                            @endif
                        </tbody>
                    </table>
                    
                </div>
                {{ $staffs->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
