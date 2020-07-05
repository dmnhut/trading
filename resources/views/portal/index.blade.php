@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('portal.index')}}" class="breadcrumb hide-on-med-and-down">Xử lý đơn hàng</a>
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
<div class="card-panel grey darken-3 white-text">
    <div class="row">
        <div class="col s12">
            <ul class="tabs tabs-fixed-width grey darken-3 white-text">
                @if($role === App\Fun\__::ROLES['ADMIN'])
                <li class="tab col s3"><a @if($tab === \App\Fun\__::get_tab('ASSIGN')) class="active"
                    @endif href="#tab-assign">Phân công đơn hàng</a></li>
                @endif
                <li class="tab col s3"><a @if($tab === \App\Fun\__::get_tab('SHIPPING')) class="active"
                    @endif href="#tab-shipping">Đang vận chuyển</a></li>
                @if($role === App\Fun\__::ROLES['ADMIN'])
                <li class="tab col s3"><a @if($tab === \App\Fun\__::get_tab('TRANSFERS')) class="active"
                    @endif href="#tab-transfers">Chờ thanh toán</a></li>
                @endif
            </ul>
        </div>
        @if($role === App\Fun\__::ROLES['ADMIN'])
        <div id="tab-assign" class="col s12">
            <div style="overflow-x:auto;">
                <table id="tbl-assign">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại khách hàng</th>
                            <th>Địa chỉ chuyển đến</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Ghi chú</th>
                            <th>Phân công đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td data-label="Mã đơn hàng">
                                {{$value->code}}
                            </td>
                            <td data-label="Tên khách hàng">
                                {{$value->user_name}}
                            </td>
                            <td data-label="Số điện thoại khách hàng">
                                {{$value->user_phone}}
                            </td>
                            <td data-label="Địa chỉ chuyển đến">
                                {{$value->ship_address}}
                            </td>
                            <td data-label="Trạng thái đơn hàng">
                                {{\App\Fun\__::status_name($value->name_status)}}
                            </td>
                            <td data-label="Ghi chú">
                                {{$value->note}}
                            </td>
                            <td data-label="Phân công đơn hàng">
                                <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-assign" data-position="top" data-tooltip="Phân Công" data="{{$value->id}}" code="{{$value->code}}">
                                    <i class="material-icons">assignment</i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <div id="tab-shipping" class="col s12">
            <div style="overflow-x:auto;">
                <table id="tbl-shipping">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Địa chỉ chuyển đến</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Người chuyển</th>
                            <th>Ghi chú</th>
                            <th>Cập nhật trạng thái</th>
                            <th>Quan sát chuyển hàng</th>
                            <th>Chuyển hàng</th>
                            <th>Theo dõi đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td data-label="Mã đơn hàng">
                                {{$value->code}}
                            </td>
                            <td data-label="Khách hàng">
                                {{$value->user_name}} - {{$value->user_phone}}
                            </td>
                            <td data-label="Địa chỉ chuyển đến">
                                {{$value->ship_address}}
                            </td>
                            <td data-label="Trạng thái đơn hàng">
                                {{\App\Fun\__::status_name($value->name_status)}}
                            </td>
                            <td data-label="Người chuyển">
                                {{$value->shipper_name}} - {{$value->shipper_phone}}
                            </td>
                            <td data-label="Ghi chú">
                                {{$value->note}}
                            </td>
                            <td data-label="Cập nhật trạng thái">
                                <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-change-status" data-position="top" data-tooltip="Cập nhật trạng thái" data="{{$value->id}}" code="{{$value->code}}"
                                    status="{{$value->id_status}}">
                                    <i class="material-icons">edit</i>
                                </button>
                            </td>
                            <td data-label="Quan sát chuyển hàng">
                                <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-map" data-position="top" data-tooltip="Quan sát chuyển hàng" data="{{$value->id}}">
                                    <i class="material-icons">explore</i>
                                </button>
                            </td>
                            <td data-label="Chuyển hàng">
                                <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-location" data-position="top" data-tooltip="Chuyển hàng" data="{{$value->id}}">
                                    <i class="material-icons">gps_fixed</i>
                                </button>
                            </td>
                            <td data-label="Theo dõi đơn hàng">
                                <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-traces" data-position="top" data-tooltip="Theo dõi đơn hàng" data="{{$value->id}}" code="{{$value->code}}">
                                    <i class="material-icons">forward</i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($role === App\Fun\__::ROLES['ADMIN'])
        <div id="tab-transfers" class="col s12">
            <div class="message" style="display:none">
                <div class="section error" style="display:none">
                    <div class="alert">
                        <span class="closebtn" onclick="removeMessage($(this))">&times;</span>
                    </div>
                </div>
            </div>
            <div style="overflow-x:auto;">
                <table id="tbl-transfers">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Địa chỉ chuyển đến</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Người chuyển</th>
                            <th>Ghi chú</th>
                            <th>Chuyển tiền shipper</th>
                            <th>Cập nhật đang vận chuyển</th>
                            <th>Theo dõi đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td data-label="Mã đơn hàng">
                                {{$value->code}}
                            </td>
                            <td data-label="Khách hàng">
                                {{$value->user_name}} - {{$value->user_phone}}
                            </td>
                            <td data-label="Địa chỉ chuyển đến">
                                {{$value->ship_address}}
                            </td>
                            <td data-label="Trạng thái đơn hàng">
                                {{\App\Fun\__::status_name($value->name_status)}}
                            </td>
                            <td data-label="Người chuyển">
                                {{$value->shipper_name}} - {{$value->shipper_phone}}
                            </td>
                            <td data-label="Ghi chú">
                                {{$value->note}}
                            </td>
                            <td data-label="Chuyển tiền shipper">
                                <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-transfers" data-position="top" data-tooltip="Chuyển tiền" data="{{$value->id}}">
                                    <i class="material-icons">attach_money</i>
                                </button>
                            </td>
                            <td data-label="Cập nhật đang vận chuyển">
                                <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-shipping" data-position="top" data-tooltip="Trả về trạng thái đơn hàng đang vận chuyển" data="{{$value->id}}">
                                    <i class="material-icons">arrow_back</i>
                                </button>
                            </td>
                            <td data-label="Theo dõi đơn hàng">
                                <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-traces" data-position="top" data-tooltip="Theo dõi đơn hàng" data="{{$value->id}}" code="{{$value->code}}">
                                    <i class="material-icons">forward</i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
<ul class="pagination">
    @for ($i = 1; $i
    <= $page_number; $i++) @if($page_active == $i)
    <li class="active"><a href="{{route('portal.index', ['tab' => $tab, 'page' => $i])}}">{{$i}}</a></li>
    @else
    <li class="waves-effect"><a href="{{route('portal.index', ['tab' => $tab, 'page' => $i])}}">{{$i}}</a></li>
    @endif
    @endfor
</ul>
@if($role === App\Fun\__::ROLES['ADMIN'])
<div id="modal-assign" class="modal grey darken-3">
    <div class="modal-content grey darken-3 white-text">
        <div class="message" style="display:none">
            <div class="section error" style="display:none">
                <div class="alert">
                    <span class="closebtn" onclick="removeMessage($(this))">&times;</span>
                </div>
            </div>
        </div>
        <h5>Phân công đơn hàng
            <div class="chip">
                <span class="code"></span>
            </div>
        </h5>
        <div class="row">
            <div style="overflow-x:auto;">
                <table class="activated">
                    <thead>
                        <tr>
                            <th id="th-shippers-name">Họ tên</th>
                            <th id="th-shippers-email">Email</th>
                            <th id="th-shippers-phone">Số điện thoại</th>
                            <th id="th-shippers-province">Tỉnh thành</th>
                            <th id="th-shippers-district">Quận huyện</th>
                            <th id="th-shippers-ward">Phường xã</th>
                            <th id="th-shippers-assign">Phân công</th>
                        </tr>
                    </thead>
                    <tbody id="tbl-shippers">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer grey darken-3 white-text">
        <button class="modal-close waves-effect btn btn-close grey darken-2">Hủy</button>
    </div>
</div>
@endif
<div id="modal-shipping" class="modal grey darken-3">
    <div class="modal-content grey darken-3 white-text">
        <div class="message" style="display:none">
            <div class="section error" style="display:none">
                <div class="alert">
                    <span class="closebtn" onclick="removeMessage($(this))">&times;</span>
                </div>
            </div>
        </div>
        <h5>Cập nhật trạng thái đơn hàng
            <div class="chip">
                <span class="code"></span>
            </div>
        </h5>
        <div class="row">
            @foreach ($status as $value)
            @if(\App\Fun\__::INDEX%\App\Fun\__::MOD === 1)
            <div class="col s6">
                @endif
                <p>
                    <label>
                        @if(\App\Fun\__::status('assign') == $value->id)
                        <input name="status" type="radio" disabled value="{{$value->id}}" />
                        @else
                        <input name="status" type="radio" value="{{$value->id}}" />
                        @endif
                        <span>{{$value->name}}</span>
                    </label>
                </p>
                @if(\App\Fun\__::INDEX%\App\Fun\__::MOD === 1)
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="modal-footer grey darken-3 white-text">
        <button class='waves-effect waves-light btn green darken-3 btn-modal-shipping'>Cập nhật</button>
        <button class="modal-close waves-effect btn btn-close grey darken-2">Hủy</button>
    </div>
</div>
<div id="modal-message" class="modal" style="width:30%!important;">
    <div class="modal-content">
        <form method="GET" action="{{route('portal.index')}}">
            <input type="hidden" name="page" />
            <input type="hidden" name="tab" />
            <span id="message"></span>
            <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat">OK</button>
            </div>
        </form>
    </div>
</div>
<form method="GET" action="" name="frm-map">
    <input type="hidden" name="order" />
    <button type="submit" style="display:none" id="btn-map-submit"></button>
</form>
<input type="hidden" name="_tab_active" value="{{$tab}}" />
<input type="hidden" name="_order" />
<input type="hidden" name="_url" value="{{route('portal.index')}}" />
<input type="hidden" name="_url_shippers" value="{{route('portal.shippers')}}" />
<input type="hidden" name="_url_assign" value="{{route('portal.assign')}}" />
<input type="hidden" name="_url_status" value="{{route('portal.status')}}" />
<input type="hidden" name="_url_transfers" value="{{route('portal.transfers')}}" />
<input type="hidden" name="_url_map_check" value="{{route('map.check')}}" />
<input type="hidden" name="_url_map" value="{{route('map.index')}}" />
<input type="hidden" name="_url_map_location" value="{{route('map.location')}}" />
<input type="hidden" name="_url_timeline" value="{{route('portal.timeline')}}" />
<input type="hidden" name="_radio_assign" value="{{\App\Fun\__::status('assign')}}" />
@csrf
@endsection
@section('script')
@if($role === App\Fun\__::ROLES['ADMIN'])
<script>
    document.querySelector("#tbl-assign").style.display = "none";
    document.querySelector("#tbl-shipping").style.display = "none";
    document.querySelector("#tbl-transfers").style.display = "none";
</script>
@endif
<script type="module" src="{{url('js/portal/index/app.js')}}"></script>
@endsection