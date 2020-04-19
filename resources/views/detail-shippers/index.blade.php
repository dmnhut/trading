@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('detail-shippers.index')}}" class="breadcrumb hide-on-med-and-down">Shipper</a>
    </div>
</nav>
<div class="section">
    <div class="row">
        <div class="col s12">
            <nav class="cyan darken-3">
                <div class="nav-wrapper">
                    <div class="input-field">
                        <input id="txt" class="tooltipped" type="search" data-position="bottom" data-tooltip="Nhập vào thông tin cần tìm kiếm">
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
<div class="card-panel grey darken-3 white-text">
    <table class="highlight responsive-table activated">
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
        <tbody>
            @if(!empty($data))
            @foreach ($data as $value)
            <tr>
                <td>{{$value->name}}</td>
                <td>{{$value->email}}</td>
                <td>{{$value->phone}}</td>
                <td>{{$detail_shippers[$value->id]['province']['name']}}</td>
                <td>{{$detail_shippers[$value->id]['district']['name']}}</td>
                <td>{{$detail_shippers[$value->id]['ward']['name']}}</td>
                @if(empty($detail_shippers[$value->id]['id_shipper']))
                    <td>
                        <button class="waves-effect waves-light btn btn-small btn-cu green darken-3" mode="add" usrname="{{$value->name}}" data="{{$value->id}}" id_shipper="">chọn</button>
                    </td>
                    @else
                    <td>
                        <button class="waves-effect waves-light btn btn-small btn-cu green darken-3" mode="update" usrname="{{$value->name}}" data="{{$value->id}}" id_shipper="{{$detail_shippers[$value->id]['id_shipper']}}"
                          province="{{$detail_shippers[$value->id]['province']['id']}}" district="{{$detail_shippers[$value->id]['district']['id']}}" ward="{{$detail_shippers[$value->id]['ward']['id']}}">cài đặt</button>
                    </td>
                    @endif
                    <td>
                        <button class="waves-effect waves-light btn btn-small btn-detail light-green darken-3" data="{{$value->id}}">chi tiết</button>
                    </td>
                    <td>
                        @if(!empty($detail_shippers[$value->id]['id_shipper']))
                            <form method="POST" action="{{route('detail-shippers.destroy', [$detail_shippers[$value->id]['id_shipper']])}}">
                                @method('DELETE')
                                @csrf
                                <button class="waves-effect waves-light btn btn-small grey darken-2">Xóa cài đặt</button>
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
<ul class="pagination">
    @for ($i = 1; $i
    <= $page_number; $i++) @if($page_active == $i)
    <li class="active"><a href="{{route('detail-shippers.index', ['page' => $i])}}">{{$i}}</a></li>
    @else
    <li class="waves-effect"><a href="{{route('detail-shippers.index', ['page' => $i])}}">{{$i}}</a></li>
    @endif
    @endfor
</ul>
<div id="modal-detail" class="modal" url="{{route('detail-shippers.detail')}}">
    <div class="modal-content grey darken-3 white-text">
        <h5>Thông tin chi tiết
            <div class="chip">
                <span id="detail-name"></span>
            </div>
        </h5>
        <p>Ngày sinh: <span id="detail-birthdate"></span></p>
        <p>Email: <span id="detail-email"></span></p>
        <p>Giới tính: <span id="detail-gender"></span></p>
        <p>Số chứng minh nhân dân: <span id="detail-identity_card"></span></p>
        <p>Số điện thoại: <span id="detail-phone"></span></p>
    </div>
    <div class="modal-footer grey darken-3 white-text">
        <button class="modal-close waves-effect waves-green btn grey darken-2">Đóng</button>
    </div>
</div>
<div id="modal-area" class="modal">
    <div class="modal-content grey darken-3 white-text">
        <h5>Cài đặt khu vực
            <div class="chip">
                <span id="usrname"></span>
            </div>
        </h5>
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
    <div class="modal-footer grey darken-3 white-text">
        <button id="btn-modal-cu" class="waves-effect btn green darken-3">Thêm</button>
        <button class="modal-close waves-effect btn btn-close grey darken-2">Hủy</button>
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
<input type="hidden" name="_mode" />
<input type="hidden" name="_id_shipper" />
<input type="hidden" name="_captions" value='@json($captions)' />
@endsection
@section('script')
<script src="{{url('app/detail-shippers/index.js')}}"></script>
@endsection