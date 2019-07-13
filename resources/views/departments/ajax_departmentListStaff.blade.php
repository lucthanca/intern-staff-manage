<div class="table-responsive">
    <table id="dataTable" class="table align-items-center table-dark table-flush">
        <thead class="thead-dark">
            <tr>
                @if(auth()->user()->role == 1)
                    <th>
                        <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                            <input id="checkboxAll" class="custom-control-input" type="checkbox">
                            <label class="custom-control-label" for="checkboxAll"></label>
                        </div>
                    </th>
                @endif
                <th scope="col">#</th>
                <th scope="col">Tên</th>
                <th scope="col">Tài khoản</th>
                <th scope="col">Email</th>
                <th scope="dol">Chức vụ</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $staff)
            <tr><a href="#">
                    @if(auth()->user()->role == 1)
                        <td style="width: 1px;">
                            <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                <input data-id="{{ $staff->id }}" class="custom-control-input chkbox" id="checkbox-{{ $staff->id }}" type="checkbox">
                                <label class="custom-control-label" for="checkbox-{{ $staff->id }}"></label>
                            </div>
                        </td>
                    @endif
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
                    <td role="permission" title="{{ $staff->pivot->permission == 1 ? 'Quản lý' : 'Nhân viên' }}">
                        {{ $staff->pivot->permission == 1 ? 'Quản lý' : 'Nhân viên' }}
                    </td>
                    <td class="text-right">
                        <!-- Nếu user đang đăng nhập là root, quản lý hoặc là chính họ -->
                        @if(auth()->user()->role == 1 || auth()->user()->id == $staff->id)
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    @if(auth()->user()->role == 1 )
                                        @if($staff->pivot->permission != 1)
                                            <a href="javascript:void(0);" class="dropdown-item _set_as_manage">Tăng thành siêu cấp quản lý</a>
                                        @else
                                            <a href="javascript:void(0);" class="dropdown-item _set_as_staff" user-id={{ $staff->id }}>Bãi thành hạ phẩm nhân viên</a>
                                        @endif
                                        <a href="/profile/{{$staff->id}}" class="dropdown-item _show_profile">Xem thông tin cá nhân</a>
                                        <a href="javascript:void(0);" class="dropdown-item _resetPassword" data-id="{{ $staff->id }}">Khôi phục mật khẩu</a>
                                        <a class="dropdown-item" href="/edit/{{ $staff->id }}">Sửa</a>
                                        <a class="dropdown-item _kick_Staff" href="javascript:void(0);" user-id="{{ $staff->id }}">Đá khỏi phòng ban</a>
                                    @elseif(auth()->user()->departments->find($department->id)->pivot->permission == 1 || auth()->user()->id == $staff->id)
                                        <a href="/profile/{{$staff->id}}" class="dropdown-item">Xem thông tin cá nhân</a>
                                        <a class="dropdown-item" href="/edit/{{ $staff->id }}">Sửa</a>
                                    @endif
                                </div>
                            </div>
                        @elseif(auth()->user()->role != 1 && auth()->user()->departments->find($department->id))
                            @if(auth()->user()->departments->find($department->id)->pivot->permission == 1 || auth()->user()->id == $staff->id)
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="/profile/{{$staff->id}}" class="dropdown-item">Xem thông tin cá nhân</a>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </td>
                </a>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $staffs->render('pagination.argon') }}