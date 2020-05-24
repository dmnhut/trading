@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('portal.index')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Portal</a>
        <a href="{{route('portal.index')}}" class="breadcrumb hide-on-med-and-down">Gởi vị trí</a>
    </div>
</nav>
<div class="card-panel grey darken-3 white-text">
    <div class="row">
        <p id="status"></p>
        <p>
            Vĩ độ (Latitude): <span id="lat"></span>
        </p>
        <p>
            Kinh độ (Longitude): <span id="lng"></span>
        </p>
    </div>
</div>
@endsection
@section('script')
<script src="{{url('app/map/location.js')}}"></script>
@endsection