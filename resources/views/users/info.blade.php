@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('info')}}" class="breadcrumb hide-on-med-and-down">Thông tin tài khoản</a>
    </div>
</nav>
<div class="card-panel grey darken-3 white-text">
    <div class="row">
        <div class="col s6">
            <div class="input-field">
                <input id="name" name="name" type="text" value="{{$data->name}}" disabled />
                <label for="name">Họ và tên</label>
            </div>
        </div>
        <div class="col s6">
            <div class="input-field">
                <input id="identity_card" name="identity_card" type="text" value="{{$data->identity_card}}" disabled />
                <label for="identity_card">Số chứng minh nhân dân</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s6">
            <label for="path">Ảnh đại diện</label>
            @if(empty($data->path))
                <img class="materialboxed" width="100" src="https://via.placeholder.com/100" />
                @else
                <img class="materialboxed" width="100" src="{{url('img') . '/' .$data->path}}" />
                @endif
        </div>
        <div class="col s6">
            <div class="input-field">
                <input class="gender" name="gender" type="text" @if($data->gender == 0)
                value="Nữ"
                @elseif ($data->gender == 1)
                value="Nam"
                @endif disabled />
                <label for="gender">Giới tính</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s6">
            <div class="input-field">
                <input id="birthdate" name="birthdate" type="text" class="datepicker" value="{{$data->birthdate}}" disabled />
                <label for="birthdate">Ngày sinh</label>
            </div>
        </div>
        <div class="col s6">
            <div class="input-field">
                <input id="phone" name="phone" type="text" value="{{$data->phone}}" disabled />
                <label for="phone">Số điện thoại</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s6">
            <div class="input-field">
                <input id="email" name="email" type="text" value="{{$data->email}}" disabled />
                <label for="email">Email</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6">
            <button id="btn-back" class="waves-effect waves-light btn grey darken-2">Trở lại</button>
        </div>
    </div>
</div>
<input type="hidden" name="_url_back" value="{{route('dashboard')}}" />
@endsection
@section('script')
<script type="module" src="{{url('js/users/info/app.js')}}"></script>
@endsection