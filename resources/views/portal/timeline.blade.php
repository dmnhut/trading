@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('portal.index')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Xử lý đơn hàng</a>
        <a href="{{route('portal.timeline')}}" class="breadcrumb hide-on-med-and-down">Theo dõi trạng thái</a>
    </div>
</nav>
<div class="card-panel grey darken-3 white-text">
    <div class="timeline--vertical timeline--right">
        @foreach ($logs as $log)
        <div class="timeline-unit">
            <div class="timeline-flag timeline-flag--full"></div>
            <p>{{$log->note}}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection