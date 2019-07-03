<div style="overflow: initial !important;" class="table-responsive" page="{{ $page ?? 1 }}">
    <table id="dataTable" class="table align-items-center table-dark table-flush">
        @if($staffs->isEmpty())
        <h1>Không có bản ghi nào</h1>
        @else
        <thead class="thead-dark">
            <tr>
                <th>
                    <div class=" checkbox checkbox-success" style="padding: 0;">
                        <input id="checkboxAll" class="styled" type="checkbox">
                        <label for="checkboxAll"></label>
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

            <tr><a href="#">
                    <td style="width: 1px;">
                        <div class=" checkbox checkbox-success" style="padding: 0;">
                            <input data-id="{{ $staff->id }}" id="checkbox-{{ $staff->id }}" class="styled chkbox" type="checkbox">
                            <label for="checkbox-{{ $staff->id }}"></label>
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
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a href="javascript:void(0);" class="dropdown-item _resetPassword" data-id="{{ $staff->id }}">Khôi phục mật khẩu</a>
                                <a class="dropdown-item" href="/edit/{{ $staff->id }}">Sửa</a>
                                <a class="dropdown-item _deleteA_Staff" href="javascript:void(0);" data-id="{{ $staff->id }}">Xoá</a>
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