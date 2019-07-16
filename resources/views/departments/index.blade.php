@extends('master')
@section('title')Danh sách phòng ban
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/css/card.css') }}">
<style>
    .toggle {
        background-color: #c87f8a;
        text-align: center;
        height: 32px;
        width: 32px;
        border-radius: 50%;
        position: absolute;
        margin: auto;
        top: 5px;
        right: 5px;
        z-index: 2;
    }

    .fa-plus {
        font-size: 16px;
        color: white;
        display: block;
        margin-top: 8px;
        transition: 0.7s;
    }

    .menu {
        background-color: white;
        height: 100px;
        width: 100px;
        transform: scale(2);
        border-radius: 50%;
        border-style: double;
        border-color: #c87f8a;
        position: absolute;
        margin: auto;
        top: -100%;
        right: -100%;
        z-index: 1;
        transition: 0.2s;
    }

    #menu a {
        display: inline-block;
        position: absolute;
        font-size: 12px;
        color: #BBBBBB;
        transition: color .3s;
    }

    #menu ._edit {
        top: 64%;
        left: 25%;
        color: green;
    }

    #menu ._edit:hover {
        color: #01a501;
    }

    #menu ._delete {
        top: 75%;
        left: 50%;
        color: red;
    }

    #menu ._delete:hover {
        color: #ff4f4f;
    }

    #menu ._show {
        top: 43%;
        left: 12%;
        color: #e8a02f;
    }
</style>
@endsection

@section('content')

<!-- Dark table -->
<div class="container-fluid mt-3">
    <div class="row">
        @if(auth()->user()->role === 1)
            <div class="col">
                <a href="/new-department/" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Thêm phòng ban</a>
                <a href="javascript:void(0);" class="btn btn-outline-danger _btn_delete_multi_department"><i class="fas fa-plus-circle"></i> Xoá phòng ban</a>
            </div>
        @endif
    </div>
    <div class="row mt-3">
        <div class="col">
            @if(auth()->user()->role == 1 && $departments->count() == 0)
                <div class="card bg-default shadow">
                    <div class="card-container">
                        <h1 style="color: #4a5871 !important; text-align: center; padding: 250px 0; font-size: 35px;">
                            Chưa có phòng ban nào cả! <br />
                            <i class="fas fa-building mt-5" style="font-size: 100px;"></i>
                        </h1>
                    </div>
                </div>
            @elseif(auth()->user()->role != 1 && auth()->user()->departments->count() == 0)
                <div class="card bg-default shadow">
                    <div class="card-container">
                        <h1 style="color: #4a5871 !important; text-align: center; padding: 250px 0; font-size: 35px;">
                            Bạn vẫn chưa được xếp vào phòng ban nào! <br />
                            <i class="fas fa-building mt-5" style="font-size: 100px;"></i>
                        </h1>
                    </div>
                </div>
            @else
                <div class="card bg-default shadow">
                    <div class="card-header bg-transparent border-0">
                        @if(auth()->user()->role == 1)
                            <h3 class="text-white mb-0">Danh sách các phòng ban</h3>
                        @else
                            <h3 class="text-white mb-0">Danh sách các phòng ban bạn thuộc về</h3>
                        @endif
                    </div>
                    <div id="htmlTableData">
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
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('departmentJs')
<script src="{{ asset('/js/department.js') }}"></script>
@endsection