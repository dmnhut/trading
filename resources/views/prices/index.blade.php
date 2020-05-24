@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('prices.index')}}" class="breadcrumb hide-on-med-and-down">Cài đặt giá</a>
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
    <div style="overflow-x:auto;">
        <table class="activated">
            <thead>
                <tr>
                    <th id="th-kg">Số Kg &le;</th>
                    <th id="th-amount">Giá Tiền</th>
                    <th id="th-status">Trạng Thái</th>
                    <th id="th-delete">Xóa</th>
                </tr>
            </thead>
            <tbody id="tbl">
                @foreach ($data as $value)
                <tr>
                    <td data-label="Số Kg &le;">{{$value->kg}}</td>
                    <td data-label="Giá Tiền">{{$value->amount}}</td>
                    <td data-label="Trạng Thái">
                        <form method="POST" action="{{route('prices.status')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$value->id}}" />
                            @if($value->turn_on == 0)
                                <button class="waves-effect waves-light btn btn-small green darken-3">bật</button>
                                @elseif($value->turn_on == 1)
                                    <button class="waves-effect waves-light btn btn-small green darken-3">tắt</button>
                                    @endif
                        </form>
                    </td>
                    <td data-label="Xóa">
                        <form method="POST" action="{{route('prices.destroy', [$value->id])}}">
                            @method('DELETE')
                            @csrf
                            <button class="waves-effect waves-light btn btn-small grey darken-2">xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($data->count() == 0)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endif
            </tbody>
        </table>
    </div>
</div>
<ul class="pagination">
    @for ($i = 1; $i
    <= $page_number; $i++) @if($page_active == $i)
    <li class="active"><a href="{{route('prices.index', ['page' => $i])}}">{{$i}}</a></li>
    @else
    <li class="waves-effect"><a href="{{route('prices.index', ['page' => $i])}}">{{$i}}</a></li>
    @endif
    @endfor
</ul>
@csrf
<div id="modal-add" class="modal">
    <div class="modal-content grey darken-3 white-text">
        <h4>Thêm mới cài đặt giá</h4>
        <div class="input-field">
            <input id="kg" name="kg" type="text" />
            <label for="kg">Số kg</label>
        </div>
        <div class="input-field">
            <input id="amount" name="amount" type="text" />
            <label for="amount">Giá Tiền</label>
        </div>
    </div>
    <div class="modal-footer grey darken-3 white-text">
        <button id="btn-add" class="waves-effect waves-light btn green darken-3">Thêm mới</button>
        <button id="btn-cancel" class="waves-effect waves-light btn btn-cancel grey darken-2">Hủy</button>
    </div>
</div>
<input type="hidden" name="_messages" value='@json($messages)' />
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large modal-trigger grey darken-3" href="#modal-add">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
@section('script')
<script src="{{url('app/prices/index.js')}}"></script>
@endsection