@extends('container.index')
@section('content')
<nav class="nav-top blue darken-1">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('detail-shippers.index')}}" class="breadcrumb hide-on-med-and-down">Shipper</a>
    </div>
</nav>
<div class="section">
    <div class="row">
        <div class="col s12">
            <nav class="blue darken-2">
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
                @if(empty($detail_shippers[$value->id]['id_shipper']))
                    <td>
                        <button class="waves-effect waves-light btn btn-small green accent-3 lighten-1 btn-add" data="{{$value->id}}">chọn</button>
                    </td>
                    @else
                    <td>
                        <button class="waves-effect waves-light btn btn-small lighten-1 btn-update" data="{{$value->id}}">cài đặt</button>
                    </td>
                    @endif
                    <td>
                        <button class="waves-effect waves-light btn btn-small blue lighten-1 btn-detail" data="{{$value->id}}">chi tiết</button>
                    </td>
                    <td>
                        @if(!empty($detail_shippers[$value->id]['id_shipper']))
                            <form method="POST" action="{{route('detail-shippers.destroy', [$detail_shippers[$value->id]['id_shipper']])}}">
                                @method('DELETE')
                                @csrf
                                <button class="waves-effect waves-light btn btn-small pink lighten-1">Xóa cài đặt</button>
                            </form>
                            @endif
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
<div id="modal-detail" class="modal" url="{{route('detail-shippers.detail')}}">
    <div class="modal-content">
        <h5>Thông tin chi tiết
            <div class="chip">
                <span id="detail-name"></span>
            </div>
        </h5>
        <p>Ngày sinh: <span id="detail-birthdate"></span></p>
        <p>Email: <span id="detail-email"></p>
        <p>Giới tính: <span id="detail-gender"></p>
        <p>Số chứng minh nhân dân: <span id="detail-identity_card"></p>
        <p>Số điện thoại: <span id="detail-phone"></p>
    </div>
    <div class="modal-footer">
        <button class="modal-close waves-effect waves-green btn-flat">Đóng</button>
    </div>
</div>
<div id="modal-area" class="modal">
    <div class="modal-content">
        <h5>Cài đặt khu vực</h5>
        <input type="hidden" />
        <div class="row">
            <div class="input-field col s4">
                <h6>Chọn tỉnh thành</h6>
                <select id="province" name="province">
                </select>
            </div>
            <div class="input-field col s4">
                <h6>Chọn quận huyện</h6>
                <select id="district" name="district" disabled>
                </select>
            </div>
            <div class="input-field col s4">
                <h6>Chọn phường xã</h6>
                <select id="ward" name="ward" disabled>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button id="btn-modal-add" class="waves-effect btn">Thêm</button>
        <button class="modal-close waves-effect pink lighten-1 btn btn-close">Hủy</button>
    </div>
</div>
<div id="modal-message" class="modal" style="width:30%!important;">
    <div class="modal-content">
      <form method="GET" action="{{route('detail-shippers.index')}}">
        <span id="message"></span>
        <div class="modal-footer">
            <button class="waves-effect waves-green btn-flat">OK</button>
        </div>
      </form>
    </div>
</div>
@csrf
<input type="hidden" id="url" value="{{route('detail-shippers.index')}}" />
<input type="hidden" name="_id" />
@endsection
@section('script')
<script src="{{url('js/detail-shippers/index.js')}}"></script>
@endsection
