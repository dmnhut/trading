@extends('container.index')
@section('content')
<nav>
    <div class="row nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('roles.index')}}" class="breadcrumb hide-on-med-and-down">Nhóm người dùng</a>
        <a href="{{route('roles.create')}}" class="breadcrumb hide-on-med-and-down">Thêm mới nhóm người dùng</a>
    </div>
</nav>
<div class="row card-panel">
    <form method="POST" action="{{route('roles.store')}}">
        @csrf
        <div class="row">
            <div class="input-field col s12">
                <input name="name" type="text">
                <label>Nhóm người dùng</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <button class="waves-effect waves-light btn">Thêm</button>
            </div>
        </div>
    </form>
</div>
@endsection
