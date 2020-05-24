@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('pays.index')}}" class="breadcrumb hide-on-med-and-down">Cài đặt phần trăm</a>
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
    <div style="overflow-x:auto;">
        <table class="activated">
            <thead>
                <tr>
                    <th>Phần Trăm %</th>
                    <th>Trạng Thái</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $value)
                <tr>
                    <td data-label="Phần Trăm %">{{$value->percent}}</td>
                    <td data-label="Trạng Thái">
                        <form method="POST" action="{{route('pays.status')}}">
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
                        <form method="POST" action="{{route('pays.destroy', [$value->id])}}">
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
                    </tr>
                    @endif
            </tbody>
        </table>
    </div>
</div>
<ul class="pagination">
    @for ($i = 1; $i
    <= $page_number; $i++) @if($page_active == $i)
    <li class="active"><a href="{{route('pays.index', ['page' => $i])}}">{{$i}}</a></li>
    @else
    <li class="waves-effect"><a href="{{route('pays.index', ['page' => $i])}}">{{$i}}</a></li>
    @endif
    @endfor
</ul>
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large modal-trigger grey darken-3" href="{{route('pays.create')}}">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection