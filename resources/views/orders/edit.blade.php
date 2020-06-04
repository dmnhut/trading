@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('orders.index')}}" class="breadcrumb hide-on-med-and-down">Đơn hàng</a>
        <a href="{{route('orders.edit', $id)}}" class="breadcrumb hide-on-med-and-down">Cập nhật đơn hàng</a>
    </div>
</nav>
<div class="message form" style="display:none">
    <div class="section error" style="display:none">
        <div class="alert">
            <span class="closebtn" onclick="removeMessage($(this))">&times;</span>
        </div>
    </div>
</div>
<form id="orders-edit" action="{{route('orders.update', $id)}}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="card-panel grey darken-3 white-text">
        <div class="row">
            <div class="right">
                <button id="btn-back" class="waves-effect waves-light btn grey darken-2">Trở lại</button>
                <button id="btn-reload" class="waves-effect waves-light btn grey darken-2">Tải lại</button>
                <button id="btn-edit" class="waves-effect waves-light btn green darken-3">Cập nhật</button>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <ul class="tabs tabs-fixed-width grey darken-3 white-text">
                    <li class="tab col s3"><a class="active" href="#tab-info">Thông tin đơn hàng</a></li>
                    <li class="tab col s3"><a href="#tab-items">Chi tiết đơn hàng</a></li>
                    <li class="tab col s3"><a href="#tab-code">Mã code</a></li>
                </ul>
            </div>
            <div id="tab-info" class="col s12">
                <div class="col m6 s12">
                    <h5>Thông tin đơn hàng</h5>
                    <div class="card-panel grey darken-3 white-text">
                        <div class="input-field">
                            <input id="code" name="code" type="text" value="{{$code}}" disabled />
                            <label for="code">Mã số đơn hàng</label>
                        </div>
                        <div class="input-field">
                            <select id="user" name="user">
                                @foreach ($users as $value)
                                @if($data->id_user == $value->id)
                                    <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                    @else
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endif
                                    @endforeach
                            </select>
                            <label for="user">Khách hàng</label>
                        </div>
                    </div>
                    <h5>Chuyển đến</h5>
                    <div class="card-panel grey darken-3 white-text">
                        <div class="input-field">
                            <select id="province" name="province">
                                <option value="0" disabled>---</option>
                                @foreach ($provinces as $value)
                                @if($data->id_province == $value->id)
                                    <option value="{{$value->id}}" selected>{{$value->text}}</option>
                                    @else
                                    <option value="{{$value->id}}">{{$value->text}}</option>
                                    @endif
                                    @endforeach
                            </select>
                            <label for="province">Tỉnh thành</label>
                        </div>
                        <div class="input-field">
                            <select id="district" name="district">
                                <option value="0" disabled>---</option>
                                @foreach ($districts as $value)
                                @if($data->id_district == $value->id)
                                    <option value="{{$value->id}}" selected>{{$value->text}}</option>
                                    @else
                                    <option value="{{$value->id}}">{{$value->text}}</option>
                                    @endif
                                    @endforeach
                            </select>
                            <label for="district">Quận huyện</label>
                        </div>
                        <div class="input-field">
                            <select id="ward" name="ward">
                                <option value="0" disabled>---</option>
                                @foreach ($wards as $value)
                                @if($data->id_ward == $value->id)
                                    <option value="{{$value->id}}" selected>{{$value->text}}</option>
                                    @else
                                    <option value="{{$value->id}}">{{$value->text}}</option>
                                    @endif
                                    @endforeach
                            </select>
                            <label for="ward">Phường xã</label>
                        </div>
                        <div class="input-field">
                            <input id="address" name="address" type="text" value="{{$data->address}}" />
                            <label for=" address">Địa chỉ</label>
                        </div>
                    </div>
                </div>
                <div class="col m6 s12">
                    <h5>Tổng tiền</h5>
                    <div class="card-panel grey darken-3 white-text">
                        <div class="input-field">
                            <input id="total-amount" class="right-align" name="total-amount" type="text" value="{{$data->total_amount}} VND" disabled />
                            <label for="total-amount">Tổng tiền</label>
                        </div>
                    </div>
                    <h5>Tổng trọng lượng &le; (kg)</h5>
                    <div class="card-panel grey darken-3 white-text">
                        <div class="input-field">
                            <select id="kg" name="kg">
                                <option value="0" disabled>---</option>
                                @foreach ($prices as $value)
                                @if($data->id_price == $value->id)
                                    <option value="{{$value->id}}-{{$value->amount}}" selected>bé hơn hoặc bằng {{$value->kg}} kg</option>
                                    @else
                                    <option value="{{$value->id}}-{{$value->amount}}">bé hơn hoặc bằng {{$value->kg}} kg</option>
                                    @endif
                                    @endforeach
                            </select>
                            <label for="kg">Tổng trọng lượng</label>
                        </div>
                    </div>
                    <h5>Người nhận</h5>
                    <div class="card-panel grey darken-3 white-text">
                        <div class="input-field">
                            <input id="receiver" name="receiver" type="text" value="{{$data->receiver}}" />
                            <label for="receiver">Họ tên người nhận</label>
                        </div>
                        <div class="input-field">
                            <input id="phone" name="phone" type="text" value="{{$data->phone}}" />
                            <label for="phone">Số điện thoại người nhận</label>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab-items" class="col s12">
                <div class="col m12 s12">
                    <h5>Chi tiết đơn hàng</h5>
                    <div class="message items" style="display:none">
                        <div class="alert">
                            <span class="closebtn" onclick="removeMessage($(this))">&times;</span>
                        </div>
                    </div>
                    <div class="card-panel grey darken-3 white-text">
                        <div class="row">
                            <div class="col s6">
                                <div class="input-field">
                                    <input id="item" name="item" type="text" />
                                    <label for="item">Tên sản phẩm / dịch vụ</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="input-field">
                                    <select id="unit" name="unit">
                                        @foreach ($units as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="unit">Đơn vị tính</label>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="input-field">
                                    <input id="quantity" name="quantity" type="text" class="validate" />
                                    <label for="quantity">Số lượng</label>
                                </div>
                            </div>
                        </div>
                        <button id="btn-add-item" class="btn-floating btn-large waves-effect waves-light grey darken-3 right">
                            <i class="material-icons">add</i>
                        </button>
                        <div style="overflow-x:auto;">
                            <table class="centered">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm / dịch vụ</th>
                                        <th>Đơn vị tính</th>
                                        <th>Số lượng</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="items">
                                    @foreach ($details as $value)
                                    <tr>
                                        <td data="{{$value->item_name}}">{{$value->item_name}}</td>
                                        <td data="{{$value->id_unit}}">{{$value->name_unit}}</td>
                                        <td data="{{$value->quantity}}">{{$value->quantity}}</td>
                                        <td><button class="waves-effect waves-light btn red" onclick="removeRow($(this))"><i class="small material-icons">close</i></button></td>
                                    </tr>
                                    @endforeach()
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab-code" class="col s12">
                <div class="col m12 s12">
                    <div class="card-panel grey darken-3 white-text">
                        <div class="row">
                            <div class="col m8 s12 valign-wrapper">
                                <svg id="barcode"></svg>
                            </div>
                            <div class="col m4 s12 valign-wrapper">
                                <div id="qrcode"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
    </div>
</form>
<div id="modal-message" class="modal" style="width:30%!important;">
    <div class="modal-content">
        <form method="GET" action="{{route('orders.index')}}">
            <span id="message"></span>
            <div class="modal-footer">
                <button class="modal-close waves-effect waves-green btn-flat">OK</button>
            </div>
        </form>
    </div>
</div>
<input type="hidden" name="_messages" value='@json($messages)' />
<input type="hidden" name="_validator" value='@json($validator)' />
<input type="hidden" name="_url_provinces" value="{{route('provinces.index')}}" />
<input type="hidden" name="_url_districts" value="{{route('districts.index')}}" />
<input type="hidden" name="_url_wards" value="{{route('wards.index')}}" />
@endsection
@section('script')
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script src="{{url('app/orders/edit.js')}}"></script>
@endsection