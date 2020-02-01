@extends('container.index')
@section('content')
<nav class="nav-top blue darken-1">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('orders.index')}}" class="breadcrumb hide-on-med-and-down">Đơn hàng</a>
        <a href="{{route('orders.create')}}" class="breadcrumb hide-on-med-and-down">Thêm mới đơn hàng</a>
    </div>
</nav>
<div class="message form" style="display:none">
    <div class="section error" style="display:none">
        <div class="alert">
            <span class="closebtn" onclick="removeMessage($(this))">&times;</span>
        </div>
    </div>
</div>
<form id="orders-create" action="{{route('orders.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="card-panel">
        <div class="row">
            <div class="right">
                <button id="btn-back" class="waves-effect waves-light btn grey">Trở lại</button>
                <button id="btn-clear" class="waves-effect waves-light btn grey">Xóa</button>
                <button id="btn-add" class="waves-effect waves-light btn">Thêm</button>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <ul class="tabs tabs-fixed-width">
                    <li class="tab col s3"><a class="active" href="#tab-info">Thông tin đơn hàng</a></li>
                    <li class="tab col s3"><a href="#tab-items">Chi tiết đơn hàng</a></li>
                    <li class="tab col s3"><a href="#tab-code">Mã code</a></li>
                </ul>
            </div>
            <div id="tab-info" class="col s12">
              <div class="col m6 s12">
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
                              <option value="0" selected disabled>---</option>
                              @foreach ($provinces as $value)
                              <option value="{{$value->id}}">{{$value->text}}</option>
                              @endforeach
                          </select>
                          <label for="province">Tỉnh thành</label>
                      </div>
                      <div class="input-field">
                          <select id="district" name="district" disabled>
                              <option value="0" selected disabled>---</option>
                          </select>
                          <label for="district">Quận huyện</label>
                      </div>
                      <div class="input-field">
                          <select id="ward" name="ward" disabled>
                              <option value="0" selected disabled>---</option>
                          </select>
                          <label for="ward">Phường xã</label>
                      </div>
                      <div class="input-field">
                          <input id="address" name="address" type="text" />
                          <label for="address">Địa chỉ</label>
                      </div>
                  </div>
              </div>
              <div class="col m6 s12">
                  <h5>Tổng tiền</h5>
                  <div class="card-panel">
                      <div class="input-field">
                          <input id="total-amount" class="right-align" name="total-amount" type="text" value="0" disabled />
                          <label for="total-amount">Tổng tiền</label>
                      </div>
                  </div>
                  <h5>Tổng trọng lượng &le; (kg)</h5>
                  <div class="card-panel">
                      <div class="input-field">
                          <select id="kg" name="kg">
                              <option value="0" selected disabled>---</option>
                              @foreach ($prices as $value)
                              <option value="{{$value->id}}-{{$value->amount}}">bé hơn hoặc bằng {{$value->kg}} kg</option>
                              @endforeach
                          </select>
                          <label for="kg">Tổng trọng lượng</label>
                      </div>
                  </div>
                  <h5>Người nhận</h5>
                  <div class="card-panel">
                      <div class="input-field">
                          <input id="receiver" name="receiver" type="text" />
                          <label for="receiver">Họ tên người nhận</label>
                      </div>
                      <div class="input-field">
                          <input id="phone" name="phone" type="number" />
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
                  <div class="card-panel">
                      <div class="row">
                          <div class="col s6">
                              <div class="input-field">
                                  <input id="item" name="item" type="text" />
                                  <label for="item">Tên sản phẩm / dịch vụ</label>
                              </div>
                          </div>
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
                      </div>
                      <div class="row">
                          <div class="col s6">
                              <div class="input-field">
                                  <input id="" name="" type="number" class="validate" />
                                  <label for="">Đơn giá</label>
                              </div>
                          </div>
                          <div class="col s6">
                              <div class="input-field">
                                  <input id="quantity" name="quantity" type="number" class="validate" />
                                  <label for="quantity">Số lượng</label>
                              </div>
                          </div>
                      </div>
                      <button id="btn-add-item" class="btn-floating btn-large waves-effect waves-light pink right">
                          <i class="material-icons">add</i>
                      </button>
                      <table class="responsive-table striped centered" style="display:none">
                          <thead>
                              <tr style="width:120px">
                                  <th>Tên sản phẩm / dịch vụ</th>
                                  <th>Đơn vị tính</th>
                                  <th>Số lượng</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody id="items">
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
            <div id="tab-code" class="col s12">
              <div class="col m12 s12">
                  <div class="card-panel">
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
<input type="hidden" name="_url_code" value="{{route('orders.code')}}" />
@endsection
@section('script')
<script src="{{url('app/orders/create.js')}}"></script>
@endsection
