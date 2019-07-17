<div class="table-responsive" page="{{ $page ?? 1 }}" user-id="{{ $user->id }}">
    @if (auth()->user()->role == 1)
        <div class="function">
                <i class="ni ni-fat-add btn btn-icon btn-primary"
                    style="
                            position: absolute;
                            top: 15%;
                            right: 10%;
                            /* border: none; */
                            border-radius: 50%;
                            padding: 6px 10px;
                            /* outline: none; */
                            cursor: pointer;
                            font-size: 18px;
                            "
                    data-toggle="modal" 
                    data-target="#_add_to_department_modal"
                    title="Thêm vào phòng ban"
                    ></i>
        </div>
    @endif
    <table id="dataTable" class="table align-items-center">
        @if($user->departments->count() == 0)
            <h1>Không có trong phòng ban nào</h1>
        @else
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên phòng ban</th>
                    <th scope="col">Quản lý</th>
                    @if (auth()->user()->role == 1)
                        <th scope="col"></th>
                    @endif
                </tr>
            </thead>
        <tbody>
            @foreach($userDepartments as $department)

            <tr><a href="#">
                    <td scope="row">
                        <div class="media align-items-center">
                            {{ $department->id }}
                        </div>
                    </td>
                    <td>
                        {{ $department->name ?? 'Chưa cập nhật tên' }}
                    </td>
                    <td title="{{ $department->users()->where('permission', 1)->first()->name ?? 'Chưa có quản lý' }}">
                        {{ $department->users()->where('permission', 1)->first()->name ?? 'Chưa có quản lý' }}
                    </td>
                    @if (auth()->user()->role == 1)
                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a href="javascript:void(0);" class="dropdown-item {{ $department->users($user->id)->first()->pivot->permission == 1 ? '_set_to_staff' : '_set_to_manage'}}" data-id="{{ $department->id }}">{{ $department->users($user->id)->first()->pivot->permission == 1 ? 'Bãi thành hạ phẩm nhân viên của phòng ban' : 'Tăng cấp thành siêu cấp quản lý cho phòng này'}}</a>
                                    <a href="/department/{{$department->id}}" 
                                        class="dropdown-item">Xem phòng ban</a>
                                    <a class="dropdown-item _kickout" href="javascript:void(0);"
                                        data-id="{{ $department->id }}">Đá khỏi phòng ban này</a>
                                </div>
                            </div>
                        </td>
                    @endif
                </a>
            </tr>
            @endforeach
        </tbody>
        @endif
    </table>
</div>
{{ $userDepartments->render('pagination.argon_light') }}
