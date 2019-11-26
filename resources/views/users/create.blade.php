@extends('container.index')
@section('content')
<nav class="nav-top">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('users.index')}}" class="breadcrumb hide-on-med-and-down">Người dùng</a>
        <a href="{{route('users.create')}}" class="breadcrumb hide-on-med-and-down">Thêm mới người dùng</a>
    </div>
</nav>
<div class="card-panel">
    <form method="POST" action="{{route('users.store')}}">
        @csrf
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <input id="name">
                    <label for="name">Họ và tên</label>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <input id="email">
                    <label for="email">Email</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <label for="path">Ảnh đại diện</label>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>File</span>
                        <input type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input id="path" class="file-path validate" type="text">
                    </div>
                </div>
            </div>
            <div class="col s6">
                <label for="gender">Giới tính</label>
                <p>
                    <label>
                        <input class="gender" name="gender" type="radio" checked />
                        <span>Nam</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input class="gender" name="gender" type="radio" />
                        <span>Nữ</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <input id="birthdate" type="text" class="datepicker">
                    <label for="birthdate">Ngày sinh</label>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <input id="phone" type="number">
                    <label for="phone">Số điện thoại</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <input id="password" type="password">
                    <label for="password">Mật khẩu</label>
                </div>
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
@section('script')
<script>
    console.clear();
    $(document).ready(() => {
        $(".datepicker").datepicker();
    });
</script>
@endsection
