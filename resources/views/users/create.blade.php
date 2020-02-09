@extends('container.index')
@section('content')
<nav class="nav-top cyan darken-4">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('users.index')}}" class="breadcrumb hide-on-med-and-down">Người dùng</a>
        <a href="{{route('users.create')}}" class="breadcrumb hide-on-med-and-down">Thêm mới người dùng</a>
    </div>
</nav>
<div class="card-panel grey darken-3 white-text">
    <form id="users-create" action="{{route('users.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <input id="name" name="name" type="text" />
                    <label for="name">Họ và tên</label>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <input id="identity_card" name="identity_card" type="number" />
                    <label for="identity_card">Số chứng minh nhân dân</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <label for="path">Ảnh đại diện</label>
                <div class="file-field input-field">
                    <div class="btn grey darken-2">
                        <span>File</span>
                        <input id="path" name="path" type="file" />
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" />
                    </div>
                </div>
            </div>
            <div class="col s6">
                <label for="gender">Giới tính</label>
                <p>
                    <label>
                        <input class="gender" name="gender" type="radio" value="1" checked />
                        <span>Nam</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input class="gender" name="gender" type="radio" value="0" />
                        <span>Nữ</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <input id="birthdate" name="birthdate" type="text" class="datepicker" />
                    <label for="birthdate">Ngày sinh</label>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <input id="phone" name="phone" type="number" />
                    <label for="phone">Số điện thoại</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <input id="password" name="password" type="password" />
                    <label for="password">Mật khẩu</label>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <input id="email" name="email" type="text" />
                    <label for="email">Email</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <button id="btn-add" class="waves-effect waves-light btn green darken-3">Thêm</button>
            </div>
        </div>
    </form>
</div>
<div id="modal-message" class="modal" style="width:30%!important;">
    <div class="modal-content">
        <form method="GET" action="{{route('users.index')}}">
            <span id="message"></span>
            <div class="modal-footer">
                <button class="modal-close waves-effect waves-green btn-flat">OK</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script src="{{url('app/users/create.js')}}"></script>
@endsection