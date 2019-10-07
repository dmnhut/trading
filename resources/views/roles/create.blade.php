@extends('container.index')
@section('content')
<nav>
    <div class="row nav-wrapper">
        <div class="col s12">
          <a href="{{route('dashboard')}}" class="breadcrumb">Bảng điều khiển</a>
          <a href="{{route('roles.index')}}" class="breadcrumb">Nhóm người dùng</a>
          <a href="{{route('roles.create')}}" class="breadcrumb">Thêm mới nhóm người dùng</a>
        </div>
    </div>
</nav>
<div class="row card-panel">
  <form method="POST" action="{{route('roles.store')}}">
    @csrf
      <div class="row">
        <div class="input-field col s6">
          <input name="name" type="text">
          <label>Tên nhóm người dùng</label>
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
