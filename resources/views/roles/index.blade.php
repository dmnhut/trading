@extends('container.index')
@section('content')
<nav class="nav-top blue darken-1">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('roles.index')}}" class="breadcrumb hide-on-med-and-down">Nhóm người dùng</a>
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
                <th>ID</th>
                <th>Tên</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $value)
            <tr>
                <td>{{$value->id}}</td>
                <td>{{$value->name}}</td>
            </tr>
            @endforeach
            @if($data->count() == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endif
        </tbody>
    </table>
</div>
<div class="row">
    {{ $data->links() }}
</div>
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large pink" href="{{route('roles.create')}}">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
