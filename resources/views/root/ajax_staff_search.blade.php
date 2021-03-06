<div class="table-responsive" page="{{ $page ?? 1 }}">
    <table id="dataTable" class="table align-items-center table-dark table-flush">
        @if($staffs->isEmpty())
            <div class="card-container">
                <h1 style="color: #4a5871 !important; text-align: center; padding: 225px 0; font-size: 45px;">
                    Không tìm thấy nhân viên nào có tên như kìa cả<br />
                    <i class="fas fa-user-times mt-5" style="font-size: 100px;"></i>
                </h1>
            </div>
        @else
        <thead class="thead-dark">
            <tr>
                <th>
                    <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                        <input id="checkboxAll" class="custom-control-input" type="checkbox">
                        <label class="custom-control-label" for="checkboxAll"></label>
                    </div>
                </th>
                <th scope="col">#</th>
                <th scope="col">Tên</th>
                <th scope="col">Tài khoản</th>
                <th scope="col">Email</th>
                <th scope="col">Phòng ban</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $staff)
            @if ($staffs->count() == 1 && $staff->role == 1)
                <div class="card-container">
                    <h1 style="color: #4a5871 !important; text-align: center; padding: 225px 0; font-size: 45px;">
                        Bạn đang tìm trúng nhân vật có quyền sát phạt tối cao!<br />
                        <i class="fas fa-user-times mt-5" style="font-size: 100px;"></i>
                    </h1>
                </div>
            @elseif ($staff->role != 1)
                <tr><a href="#">
                        <td style="width: 1px;">
                            <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                <input data-id="{{ $staff->id }}" class="custom-control-input chkbox"
                                    id="checkbox-{{ $staff->id }}" type="checkbox">
                                <label class="custom-control-label" for="checkbox-{{ $staff->id }}"></label>
                            </div>
                        </td>
                        <td scope="row">
                            <div class="media align-items-center">
                                {{ $staff->id }}
                            </div>
                        </td>
                        <td>
                            {{ $staff->name ?? 'Chưa cập nhật tên' }}
                        </td>
                        <td>
                            {{ $staff->username }}
                        </td>
                        <td>
                            {{ $staff->email }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-group">
                                    @foreach($staff->departments()->take(10)->get() as $department)
                                    <a href="/department/{{ $department->id }}" class="avatar avatar-sm"
                                        data-toggle="tooltip" data-original-title="{{ $department->name }}" title="{{ $department->name }}">
                                        <img alt="" src="" class="rounded-circle">
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a href="/profile/{{$staff->id}}" 
                                        class="dropdown-item">Xem thông tin cá nhân</a>
                                    <a href="javascript:void(0);" class="dropdown-item _resetPassword"
                                        data-id="{{ $staff->id }}">Khôi phục mật khẩu</a>
                                    <a class="dropdown-item" href="/edit/{{ $staff->id }}">Sửa</a>
                                    <a class="dropdown-item _deleteA_Staff" href="javascript:void(0);"
                                        data-id="{{ $staff->id }}">Xoá</a>
                                </div>
                            </div>
                        </td>
                    </a>
                </tr>
            @endif
            @endforeach
        </tbody>
        @endif
    </table>
</div>
