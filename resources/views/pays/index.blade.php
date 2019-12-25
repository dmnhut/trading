@extends('container.index')
@section('content')
<nav class="nav-top blue darken-1">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('pays.index')}}" class="breadcrumb hide-on-med-and-down">Cài đặt phần trăm</a>
    </div>
</nav>
<div class="section">
    <div class="row">
        <div class="col s12">
            <nav class="blue darken-2">
                <div class="nav-wrapper">
                    <div class="input-field">
                        <input id="txt" type="search" required>
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
<div class="card-panel">
    <table class="highlight responsive-table">
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
                <td>{{$value->percent}}</td>
                <td>
                    <form method="POST" action="{{route('pays.status')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$value->id}}"></input>
                        @if($value->turn_on == 0)
                            <button class="waves-effect waves-light btn btn-small pink lighten-1">bật</button>
                            @elseif($value->turn_on == 1)
                                <button class="waves-effect waves-light btn btn-small green accent-3 lighten-1">tắt</button>
                                @endif
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{route('pays.destroy', [$value->id])}}">
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
                </tr>
                @endif
        </tbody>
    </table>
</div>
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large pink modal-trigger" href="{{route('pays.create')}}">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
