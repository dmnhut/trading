@extends('container.index')
@section('content')
<nav class="nav-top blue darken-1">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('orders.index')}}" class="breadcrumb hide-on-med-and-down">Đơn hàng</a>
        <a href="{{route('orders.create')}}" class="breadcrumb hide-on-med-and-down">Thêm mới đơn hàng</a>
    </div>
</nav>
<div class="card-panel">
    <form id="orders-create" action="{{route('orders.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="right">
                <button id="btn-back" class="waves-effect waves-light btn grey lighten-1">Trở lại</button>
                <button id="btn-add" class="waves-effect waves-light btn">Thêm</button>
            </div>
        </div>
        <div class="row">
            <div class="col m5 s12">
                <h5>Thông tin đơn hàng</h5>
                <div class="card-panel">
                    <div class="input-field">
                        <input id="code" name="code" type="text" value="{{$code}}" disabled />
                        <label for="code">Mã số đơn hàng</label>
                    </div>
                    <div class="input-field">
                        <select id="user" name="user">
                            @foreach ($users as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                        <label for="user">Khách hàng</label>
                    </div>
                </div>
                <h5>Chuyển đến</h5>
                <div class="card-panel">
                    <div class="input-field">
                        <select id="province" name="province">
                            @foreach ($provinces as $value)
                            <option value="{{$value->id}}">{{$value->text}}</option>
                            @endforeach
                        </select>
                        <label for="province">Tỉnh thành</label>
                    </div>
                    <div class="input-field">
                        <select id="district" name="district" disabled>
                        </select>
                        <label for="district">Quận huyện</label>
                    </div>
                    <div class="input-field">
                        <select id="ward" name="ward" disabled>
                        </select>
                        <label for="ward">Phường xã</label>
                    </div>
                    <div class="input-field">
                        <input id="address" name="address" type="text" />
                        <label for="address">Địa chỉ</label>
                    </div>
                </div>
            </div>
            <div class="col m7 s12">
                <h5>Chi tiết đơn hàng</h5>
                <div class="card-panel">
                    <div class="row">
                        <div class="col s4">
                            <div class="input-field">
                                <input id="item" name="item" type="text" />
                                <label for="item">Tên sản phẩm / dịch vụ</label>
                            </div>
                        </div>
                        <div class="col s4">
                            <div class="input-field">
                                <select id="unit" name="unit">
                                    @foreach ($units as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                                <label for="unit">Đơn vị tính</label>
                            </div>
                        </div>
                        <div class="col s4">
                            <div class="input-field">
                                <input id="quantity" name="quantity" type="number" class="validate" />
                                <label for="quantity">Số lượng</label>
                            </div>
                        </div>
                    </div>
                    <a class="btn-floating btn-large waves-effect waves-light pink right">
                        <i class="material-icons">add</i>
                    </a>
                </div>
                <h5>Tổng tiền</h5>
                <div class="card-panel">
                    <div class="input-field">
                        <input id="total-amount" class="right-align" name="total-amount" type="text" value="0" disabled />
                        <label for="total-amount">Tổng tiền</label>
                    </div>
                </div>
                <div class="card-panel show-code">
                    <div class="row">
                        <div class="col s8">
                            <svg id="barcode"></svg>
                        </div>
                        <div class="col s4">
                            <div id="qrcode"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
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
<input type="hidden" name="_url_provinces" value="{{route('provinces.index')}}" />
<input type="hidden" name="_url_districts" value="{{route('districts.index')}}" />
<input type="hidden" name="_url_wards" value="{{route('wards.index')}}" />
@endsection
@section('script')
<script src="{{url('js/orders/create.js')}}"></script>
@endsection
