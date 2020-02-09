@extends('container.index')
@section('content')
<nav class="nav-top cyan darken-4">
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
<div class="card-panel grey darken-3 white-text">
    @if(!empty($data))
    <table class="highlight responsive-table">
        <thead>
            <th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </th>
        </thead>
        <tbody>
        </tbody>
    </table>
    @endif
</div>
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