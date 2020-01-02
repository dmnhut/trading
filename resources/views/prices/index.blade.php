@extends('container.index')
@section('content')
<nav class="nav-top blue darken-1">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('prices.index')}}" class="breadcrumb hide-on-med-and-down">Cài đặt giá</a>
    </div>
</nav>
<div class="section">
    <div class="row">
        <div class="col s12">
            <nav class="blue darken-2">
                <div class="nav-wrapper">
                    <div class="input-field">
                        <input id="txt" type="search" required />
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="card-panel">
    <table class="highlight responsive-table">
        <thead>
            <tr>
                <th>Số Kg &le;</th>
                <th>Giá Tiền</th>
                <th>Trạng Thái</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody id="tbl">
            @foreach ($data as $value)
            <tr>
                <td>{{$value->kg}}</td>
                <td>{{$value->amount}}</td>
                <td>
                    <form method="POST" action="{{route('prices.status')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$value->id}}" />
                        @if($value->turn_on == 0)
                            <button class="waves-effect waves-light btn btn-small pink lighten-1">bật</button>
                            @elseif($value->turn_on == 1)
                                <button class="waves-effect waves-light btn btn-small green accent-3 lighten-1">tắt</button>
                                @endif
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{route('prices.destroy', [$value->id])}}">
                        @method('DELETE')
                        @csrf
                        <button class="waves-effect waves-light btn btn-small red darken-2 lighten-1">xóa</button>
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
@csrf
<div id="modal-add" class="modal">
    <div class="modal-content">
        <h4>Thêm mới cài đặt giá</h4>
        <div class="input-field">
            <input id="kg" name="kg" type="number" />
            <label for="kg">Số kg</label>
        </div>
        <div class="input-field">
            <input id="amount" name="amount" type="number" />
            <label for="amount">Giá Tiền</label>
        </div>
    </div>
    <div class="modal-footer">
        <button id="btn-add" class="waves-effect waves-light btn">Thêm mới</button>
        <button id="btn-cancel" class="waves-effect waves-light btn btn-cancel pink lighten-1">Hủy</button>
    </div>
</div>
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large pink modal-trigger" href="#modal-add">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
@section('script')
<script src="{{url('js/prices/index.js')}}"></script>
@endsection
