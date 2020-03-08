@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('units.index')}}" class="breadcrumb hide-on-med-and-down">Đơn vị tính</a>
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
    <table class="highlight responsive-table">
        <thead>
            <tr>
                <th>Tên</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $value)
            <tr>
                <td>{{$value->name}}</td>
                <td>
                    <form method="POST" action="{{route('units.destroy', [$value->id])}}">
                        @method('DELETE')
                        @csrf
                        <button class="waves-effect waves-light btn btn-small right grey darken-2">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <ul class="pagination">
        @for ($i = 1; $i
        <= $page_number; $i++) @if($page_active == $i)
        <li class="active"><a href="{{route('units.index', ['page' => $i])}}">{{$i}}</a></li>
        @else
        <li class="waves-effect"><a href="{{route('units.index', ['page' => $i])}}">{{$i}}</a></li>
        @endif
        @endfor
    </ul>
    @endif
</div>
<div id="modal-add" class="modal">
    <div class="modal-content grey darken-3 white-text">
        <h5>Thêm đơn vị tính</h5>
        <div class="row">
            <div class="input-field col s12">
                <input id="name" type="text" />
                <label for="name">Tên đơn vị tính</label>
            </div>
        </div>
    </div>
    <div class="modal-footer grey darken-3 white-text">
        <button id="btn-modal-add" class="waves-effect btn green darken-3">Thêm</button>
        <button class="modal-close waves-effect btn btn-close grey darken-2">Hủy</button>
    </div>
</div>
<div id="modal-message" class="modal" style="width:30%!important;">
    <div class="modal-content">
        <form method="GET" action="{{route('units.index')}}">
            <span id="message"></span>
            <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat">OK</button>
            </div>
        </form>
    </div>
</div>
@csrf
<input type="hidden" id="url" value="{{route('units.index')}}" />
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large grey darken-3">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
@section('script')
<script src="{{url('app/units/index.js')}}"></script>
@endsection