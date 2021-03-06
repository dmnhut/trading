@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('orders.index')}}" class="breadcrumb hide-on-med-and-down">Đơn hàng</a>
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
    @if(!empty($data))
    <div style="overflow-x:auto;">
        <table class="activated">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại khách hàng</th>
                    <th>Địa chỉ chuyển đến</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>Ghi chú</th>
                    <th></th>
                    <th></th>
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
                    <td>
                        <form method="GET" action="{{route('orders.edit', [$value->id])}}">
                            <button class="waves-effect waves-light btn btn-small green darken-3 tooltipped" data-position="top" data-tooltip="Cập Nhật">
                                <i class="material-icons">edit</i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{route('orders.destroy', [$value->id])}}">
                            @method('DELETE')
                            @csrf
                            <button class="waves-effect waves-light btn btn-small grey darken-2 tooltipped" data-position="top" data-tooltip="Hủy">
                                <i class="material-icons">cancel</i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
<ul class="pagination">
    @for ($i = 1; $i
    <= $page_number; $i++) @if($page_active == $i)
    <li class="active"><a href="{{route('orders.index', ['page' => $i])}}">{{$i}}</a></li>
    @else
    <li class="waves-effect"><a href="{{route('orders.index', ['page' => $i])}}">{{$i}}</a></li>
    @endif
    @endfor
</ul>
<input type="hidden" id="object" value="PageCommon" />
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large grey darken-3" href="{{route('orders.create')}}">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
@section('script')
<script type="module" src="{{url('js/app.js')}}"></script>
@endsection