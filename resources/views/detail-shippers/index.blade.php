@extends('container.index')
@section('content')
<nav class="nav-top">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('detail-shippers.index')}}" class="breadcrumb hide-on-med-and-down">Shipper</a>
    </div>
</nav>
<div class="section">
    <div class="row">
        <div class="col s12">
            <nav style="background-color:#e91e63">
                <div class="nav-wrapper">
                    <div class="input-field">
                        <input id="txt" type="search" required>
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
@if(!empty(Session::get('message')))
@if(Session::get('error') == true)
<div class="alert">
    <span class="closebtn">&times;</span>
    {{Session::get('message')}}
</div>
@else
<div class="alert success">
    <span class="closebtn">&times;</span>
    {{Session::get('message')}}
</div>
@endif
@endif
<div class="card-panel">
    <table class="highlight responsive-table">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Tỉnh thành</th>
                <th>Quận huyện</th>
                <th>Phường xã</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tbl">
            @if(!empty($data))
            @foreach ($data as $value)
            <tr>
                <td>{{$value->name}}</td>
                <td>{{$value->email}}</td>
                <td>{{$value->phone}}</td>
                <td>{{$detail_shippers[$value->id]['province']}}</td>
                <td>{{$detail_shippers[$value->id]['district']}}</td>
                <td>{{$detail_shippers[$value->id]['ward']}}</td>
                <td>
                    <form method="GET" action="">
                        <button class="waves-effect waves-light btn btn-small green accent-3 lighten-1">chọn</button>
                    </form>
                </td>
                <td>
                    <form method="GET" action="{{route('users.edit', [$value->id])}}">
                        <button class="waves-effect waves-light btn btn-small blue lighten-1">chi tiết</button>
                    </form>
                </td>
                <td>
                    <form method="GET" action="">
                        <button class="waves-effect waves-light btn btn-small pink lighten-1">hủy</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Thông tin chi tiết</h4>
    </div>
    <div class="modal-footer">
      <button class="modal-close waves-effect waves-green btn-flat">Đóng</button>
    </div>
</div>
@endsection
@section('script')
<script src="{{url('js/detail-shippers/index.js')}}"></script>
@endsection
