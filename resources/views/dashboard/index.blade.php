@extends('container.index')
@section('content')
<nav>
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
    </div>
</nav>
<div class="col s12 m4 l4 pointer">
    <a href="{{route('roles.index')}}">
        <div class="hoverable card-panel pink lighten-1 white-text center">
            <h5>Nhóm người dùng</h5>
        </div>
    </a>
</div>
<div class="col s12 m4 l4 pointer">
    <a href="{{route('users.index')}}">
        <div class="hoverable card-panel pink-text center">
            <h5>Người dùng</h5>
        </div>
    </a>
</div>
<div class="col s12 m4 l4 pointer">
    <a href="{{route('prices.index')}}">
        <div class="hoverable card-panel pink lighten-1 white-text center">
            <h5>Cài đặt giá</h5>
        </div>
    </a>
</div>
<div class="col s12 m4 l4 pointer">
    <a href="{{route('pays.index')}}">
        <div class="hoverable card-panel pink-text center">
            <h5>Phần trăm</h5>
        </div>
    </a>
</div>
@endsection
