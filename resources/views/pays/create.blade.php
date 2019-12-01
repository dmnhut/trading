@extends('container.index')
@section('content')
<nav class="nav-top">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('pays.index')}}" class="breadcrumb hide-on-med-and-down">Cài đặt phần trăm</a>
        <a href="{{route('pays.create')}}" class="breadcrumb hide-on-med-and-down">Thêm mới phần trăm</a>
    </div>
</nav>
<div class="card-panel">
    <form method="POST" action="{{route('pays.store')}}">
        @csrf
        <div class="row">
            <div class="input-field col s12">
                <select name="percent">
                    <option value="" disabled selected>Phần trăm %</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                    <option value="45">45</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <button class="waves-effect waves-light btn">Thêm</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="{{url('js/pays/create.js')}}"></script>
@endsection
