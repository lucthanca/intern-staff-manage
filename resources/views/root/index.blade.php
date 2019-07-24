@extends('master')
@section('title')Tổng quan
@endsection
@section('content')
<div class="container-fluid mt-3">
    @if (auth()->user()->role == 1)
        <div class="row mt-3">
            <a href="/staff/">
                <div class="card card-stats mb-4 mb-lg-0 ml-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Tổng số nhân viên</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $users->count() }} mạng</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $users->where('created_at', '>=', \Carbon\Carbon::now()->subDays(30)->toDateTimeString())->count() }}</span>
                            <span class="text-nowrap">nhân viên mới trong 30 ngày qua</span>
                        </p>
                    </div>
                </div>
            </a>
            <a href="{{ $departments->count() > 0 ? '/departments/' : 'javascript:void(0);' }}">
                <div class="card card-stats mb-4 mb-lg-0 ml-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Tổng số phòng ban</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $departments->count() }} phòng</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fas fa-building"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $departments->where('created_at', '>=', \Carbon\Carbon::now()->subDays(30)->toDateTimeString())->count() }}</span>
                            <span class="text-nowrap">phòng ban mới trong 30 ngày qua</span>
                        </p>
                    </div>
                </div>
            </a>
        </div>
    @else 
        <div class="row mt-3">
                <div class="card card-stats mb-4 mb-lg-0 ml-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Tổng số phòng ban bạn thuộc về</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $user->departments->count() }} phòng</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fas fa-building"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                            <span class="text-nowrap">được thêm vào </span>
                            <span class="text-success mr-1"> {{ !$user->departments ? '0' : $user->departments->where('created_at', '>=', \Carbon\Carbon::now()->subDays(30)->toDateTimeString())->count() }}</span>
                            <span class="text-nowrap">phòng ban mới trong 30 ngày qua</span>
                        </p>
                    </div>
                </div>
        </div>
    @endif
</div>
@endsection