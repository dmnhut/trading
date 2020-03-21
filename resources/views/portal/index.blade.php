@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('portal.index')}}" class="breadcrumb hide-on-med-and-down">Trạng thái đơn hàng</a>
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
                <li class="tab col s3"><a @if($tab === \App\Fun\__::get_tab('ASSIGN')) class="active"
                    @endif href="#tab-assign">Phân công đơn hàng</a></li>
                <li class="tab col s3"><a @if($tab === \App\Fun\__::get_tab('SHIPPING')) class="active"
                    @endif href="#tab-shipping">Đang vận chuyển</a></li>
                <li class="tab col s3"><a @if($tab === \App\Fun\__::get_tab('TRANSFERS')) class="active"
                    @endif href="#tab-transfers">Chờ thanh toán</a></li>
            </ul>
        </div>
        <div id="tab-assign" class="col s12">
            <table id="tbl-assign" class="highlight responsive-table">
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
                        <td>
                            {{$value->code}}
                        </td>
                        <td>
                            {{$value->user_name}}
                        </td>
                        <td>
                            {{$value->user_phone}}
                        </td>
                        <td>
                            {{$value->ship_address}}
                        </td>
                        <td>
                            {{\App\Fun\__::status_name($value->name_status)}}
                        </td>
                        <td>
                            {{$value->note}}
                        </td>
                        <td>
                            <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-assign" data-position="top" data-tooltip="Phân Công" data="{{$value->id}}" code="{{$value->code}}">
                                <i class="material-icons">assignment</i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="tab-shipping" class="col s12">
            <table id="tbl-shipping" class="highlight responsive-table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Địa chỉ chuyển đến</th>
                        <th>Trạng thái đơn hàng</th>
                        <th>Người chuyển</th>
                        <th>Ghi chú</th>
                        <th>Cập nhật trạng thái</th>
                        <th>Theo dõi đơn hàng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                    <tr>
                        <td>
                            {{$value->code}}
                        </td>
                        <td>
                            {{$value->user_name}} - {{$value->user_phone}}
                        </td>
                        <td>
                            {{$value->ship_address}}
                        </td>
                        <td>
                            {{\App\Fun\__::status_name($value->name_status)}}
                        </td>
                        <td>
                            {{$value->shipper_name}} - {{$value->shipper_phone}}
                        </td>
                        <td>
                            {{$value->note}}
                        </td>
                        <td>
                            <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-change-status" data-position="top" data-tooltip="Cập nhật trạng thái" data="{{$value->id}}" code="{{$value->code}}"
                              status="{{$value->id_status}}">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>
                        <td>
                            <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-traces" data-position="top" data-tooltip="Theo dõi đơn hàng" data="{{$value->id}}" code="{{$value->code}}">
                                <i class="material-icons">forward</i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="tab-transfers" class="col s12">
            <div class="message" style="display:none">
                <div class="section error" style="display:none">
                    <div class="alert">
                        <span class="closebtn" onclick="removeMessage($(this))">&times;</span>
                    </div>
                </div>
            </div>
            <table id="tbl-transfers" class="highlight responsive-table">
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
                        <td>
                            {{$value->code}}
                        </td>
                        <td>
                            {{$value->user_name}} - {{$value->user_phone}}
                        </td>
                        <td>
                            {{$value->ship_address}}
                        </td>
                        <td>
                            {{\App\Fun\__::status_name($value->name_status)}}
                        </td>
                        <td>
                            {{$value->shipper_name}} - {{$value->shipper_phone}}
                        </td>
                        <td>
                            {{$value->note}}
                        </td>
                        <td>
                            <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-transfers" data-position="top" data-tooltip="Chuyển tiền" data="{{$value->id}}">
                                <i class="material-icons">attach_money</i>
                            </button>
                        </td>
                        <td>
                            <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped btn-shipping" data-position="top" data-tooltip="Trả về trạng thái đơn hàng đang vận chuyển" data="{{$value->id}}">
                                <i class="material-icons">arrow_back</i>
                            </button>
                        </td>
                        <td>
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
</div>
<ul class="pagination">
    @for ($i = 1; $i
    <= $page_number; $i++) @if($page_active == $i)
    <li class="active"><a href="{{route('portal.index', ['page' => $i, 'tab' => $tab])}}">{{$i}}</a></li>
    @else
    <li class="waves-effect"><a href="{{route('portal.index', ['page' => $i, 'tab' => $tab])}}">{{$i}}</a></li>
    @endif
    @endfor
</ul>
<div id="modal-assign" class="modal">
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
                    </tr>
                </thead>
                <tbody id="tbl-shippers">
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer grey darken-3 white-text">
        <button class="modal-close waves-effect btn btn-close grey darken-2">Hủy</button>
    </div>
</div>
<div id="modal-shipping" class="modal">
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
            @if(\App\Fun\__::INDEX%\App\Fun\__::MOD == 1)
            <div class="col s6">
                @endif
                <p>
                    <label>
                        <input name="status" type="radio" value="{{$value->id}}" />
                        <span>{{$value->name}}</span>
                    </label>
                </p>
                @if(\App\Fun\__::INDEX%\App\Fun\__::MOD == 1)
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
<input type="hidden" name="_tab_active" value="{{$tab}}" />
<input type="hidden" name="_order" />
<input type="hidden" name="_url" value="{{route('portal.index')}}" />
<input type="hidden" name="_url_shippers" value="{{route('portal.shippers')}}" />
<input type="hidden" name="_url_assign" value="{{route('portal.assign')}}" />
<input type="hidden" name="_url_status" value="{{route('portal.status')}}" />
<input type="hidden" name="_url_transfers" value="{{route('portal.transfers')}}" />
@csrf
@endsection
@section('script')
<script src="{{url('app/portal/index.js')}}"></script>
@endsection