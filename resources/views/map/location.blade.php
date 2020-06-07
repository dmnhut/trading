@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('portal.index')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Xử lý đơn hàng</a>
        <a href="{{route('map.location')}}" class="breadcrumb hide-on-med-and-down">Gởi vị trí</a>
    </div>
</nav>
<div class="card-panel grey darken-3 white-text">
    <div class="row">
        <p id="status"></p>
        <p>
            Vĩ độ (Latitude): <div id="lat"></div>
        </p>
        <p>
            Kinh độ (Longitude): <div id="lng"></div>
        </p>
    </div>
</div>
@method('PUT')
@csrf
<input name="_url_location_store" type="hidden" value="{{route('map.store')}}" />
<input name="order" type="hidden" value="{{$order}}" />
<input name="shipper" type="hidden" value="{{$shipper}}" />
@endsection
@section('script')
<script src="{{url('app/map/location.js')}}"></script>
@endsection