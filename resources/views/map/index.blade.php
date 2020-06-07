@extends('container.index')
@section('style')
<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
@endsection
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('portal.index')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Xử lý đơn hàng</a>
        <a href="{{route('map.index')}}" class="breadcrumb hide-on-med-and-down">Quan sát giao hàng</a>
    </div>
</nav>
<div class="card-panel grey darken-3 white-text">
    <div class="row">
        <div id="map"></div>
    </div>
</div>
<input type="hidden" id="title-location" value="{{$title['location']}}" />
<input type="hidden" id="title-address" value="{{$title['address']}}" />
<input type="hidden" id="destination" value='@json($destination)' />
<input type="hidden" name="order" value="{{$order}}" />
<input type="hidden" name="_url_map_get" value="{{route('map.get')}}" />
@endsection
@section('script')
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<script src="{{url('app/map/index.js')}}"></script>
@endsection