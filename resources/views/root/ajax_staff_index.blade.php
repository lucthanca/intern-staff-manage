<div class="table-responsive" page="{{ $page ?? 1 }}">
    <table id="dataTable" class="table align-items-center table-dark table-flush">
        @if($staffs->isEmpty())
        <h1>Không có bản ghi nào</h1>
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
                <th scope="col">Trạng thái</th>
                <th scope="col">Tài khoản</th>
                <th scope="col">Email</th>
                <th scope="col">Phòng ban</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $staff)

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
                    <td role="status">
                        {!! $staff->logged_flag == -1 ? '<span style="color: #ff2e2e; text-shadow: 0px 0px 10px #ff3737eb;"><i class="fas fa-exclamation-circle"></i>&nbsp;Reset mật khẩu</span>' : ($staff->logged_flag === 0 ? '<span style="color: #ffa243; text-shadow: 0px 0px 10px #ffa243eb;"><i class="fas fa-exclamation-circle"></i>&nbsp;Chưa đăng nhập</span>' : '<span style="color: #00ff00; text-shadow: 0px 0px 10px #46ff46c7;"><i class="fas fa-user-check    "></i>&nbsp;Bình thường</span>') !!}
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
            @endforeach
        </tbody>
        @endif
    </table>
</div>
{{ $staffs->render('pagination.argon') }}
