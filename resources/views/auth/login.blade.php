@extends('container.index')
@section('content')
<div class="container">
    <div class="card-panel grey darken-3 white-text">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="row">
                <div class="input-field">
                    <input id="email" type="email" class="form-control is-invalid" name="email" required autocomplete="email" autofocus>
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <input id="password" type="password" class="form-control is-invalid" name="password" required autocomplete="current-password">
                    <label for="password">Mật khẩu</label>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="waves-effect waves-light btn green darken-3">
                    Đăng nhập
                </button>
            </div>
        </form>
    </div>
</div>
@endsection