@if($departments->isEmpty())
            <div class="card-container">
                <h1 style="color: #4a5871 !important; text-align: center; padding: 200px 0; font-size: 45px;">
                    Không tìm thấy phòng ban nào với tên như kia cả<br />
                    <i class="fas fa-building mt-5" style="font-size: 100px;"></i>
                </h1>
            </div>
        @else
<div class="row px-3">
    @foreach($departments as $depart)
    @if(auth()->user()->role == 1)
    <div class="card-container col-md-3">
        <a href="javascript:void(0);">
            <div class="department-card">
                <div class="additional">
                    <div class="user-card">
                        <div class="level center">
                            Quản lý
                        </div>
                        @if($depart->users()->where('permission', 1)->count() == 0)
                        <img src="{{ asset('/img/no-user.png') }}" alt="" width="75">
                        @else
                        @foreach($depart->users as $user)
                        @if($user->pivot->permission == 1)
                        <img src="{{ $user->getAvatar() }}" alt="" width="75" title="{{ $user->name }}">
                        @endif
                        @endforeach
                        @endif
                    </div>
                    <div class="more-info">
                        <h1>{{ $depart->name }}</h1>
                        <div class="coords">
                            <span>Quản lý: </span>
                            @if($depart->users()->where('permission', 1)->count() == 0)
                            <span>Chưa có quản lý</span>
                            @else
                            @foreach($depart->users as $user)
                            @if($user->pivot->permission == 1)
                            <span>{{ $user->name ?? 'Chưa cập nhật tên'}}</span>
                            @endif
                            @endforeach
                            @endif
                        </div>
                        <div class="coords">
                            <span>Ngày tạo: </span>
                            <span>{{ $depart->created_at->isoFormat('DD-MM-YYYY') }}</span>
                        </div>
                        <div class="stats">
                            <div>
                                <div class="title">Số nhân viên</div>
                                <i class="fas fa-users"></i>
                                <div class="value">{{ $depart->users->count() }}</div>
                            </div>
                        </div>
                        <div class="toggle" id="toggle" status="0">
                            <i class="fa fa-plus" id="plus"></i>
                        </div>
                        <div class="menu menu-func" id="menu">
                            <a href="/department/{{ $depart->id }}" class="_show" title="Xem thông tin phòng ban">
                                <i class="fas fa-building    "></i>
                            </a>
                            <a href="/department/{{ $depart->id }}/edit" class="_edit" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="_delete" data-id="{{ $depart->id }}" title="Xoá">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="general">
                    <h1>{{ $depart->name }}</h1>
                    <p>{{ $depart->description }}.</p>
                </div>
            </div>
        </a>
    </div>
    @else
    @foreach($depart->users as $user)
    @if($user->id == auth()->user()->id)
    <div class="card-container col-md-3">
        <a href="/department/{{ $depart->id }}">
            <div class="department-card">
                <div class="additional">
                    <div class="user-card">
                        <div class="level center">
                            Quản lý
                        </div>
                        @if($depart->users()->where('permission', 1)->count() == 0)
                        <img src="{{ asset('/img/no-user.png') }}" alt="" width="75">
                        @else
                        @foreach($depart->users as $user)
                        @if($user->pivot->permission == 1)
                        <img src="{{ $user->getAvatar() }}" alt="" width="75" title="{{ $user->name }}">
                        @endif
                        @endforeach
                        @endif
                    </div>
                    <div class="more-info">
                        <h1>{{ $depart->name }}</h1>
                        <div class="coords">
                            <span>Quản lý: </span>
                            @if($depart->users()->where('permission', 1)->count() == 0)
                            <span>Chưa có quản lý</span>
                            @else
                            @foreach($depart->users as $user)
                            @if($user->pivot->permission == 1)
                            <span>{{ $user->name ?? 'Chưa cập nhật tên'}}</span>
                            @endif
                            @endforeach
                            @endif
                        </div>
                        <div class="coords">
                            <span>Ngày tạo: </span>
                            <span>{{ $depart->created_at->isoFormat('DD-MM-YYYY') }}</span>
                        </div>
                        <div class="stats">
                            <div>
                                <div class="title">Số nhân viên</div>
                                <i class="fas fa-users"></i>
                                <div class="value">{{ $depart->users->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="general">
                    <h1>{{ $depart->name }}</h1>
                    <p>{{ $depart->description }}.</p>
                </div>
            </div>
        </a>
    </div>
    @endif
    @endforeach
    @endif
    @endforeach
    @endif
</div>