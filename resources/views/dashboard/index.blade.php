@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
    </div>
</nav>
<div class="col s12 m4 l4 pointer">
    <a href="{{route('portal.index')}}">
        <div class="hoverable card-panel cyan darken-3 white-text center">
            <h5>Xử lý đơn hàng</h5>
        </div>
    </a>
</div>
@if(App\Fun\__::get_role_code(Auth::user()->id) === App\Fun\__::ROLES['ADMIN'])
    <div class="col s12 m4 l4 pointer">
        <a href="{{route('roles.index')}}">
            <div class="hoverable card-panel cyan darken-3 white-text center">
                <h5>Nhóm người dùng</h5>
            </div>
        </a>
    </div>
    @endif
    <div class="col s12 m4 l4 pointer">
        <a href="{{route('users.index')}}">
            <div class="hoverable card-panel cyan darken-3 white-text center">
                <h5>Người dùng</h5>
            </div>
        </a>
    </div>
    @if(App\Fun\__::get_role_code(Auth::user()->id) === App\Fun\__::ROLES['ADMIN'])
        <div class="col s12 m4 l4 pointer">
            <a href="{{route('prices.index')}}">
                <div class="hoverable card-panel cyan darken-3 white-text center">
                    <h5>Cài đặt giá</h5>
                </div>
            </a>
        </div>
        @endif
        @if(App\Fun\__::get_role_code(Auth::user()->id) === App\Fun\__::ROLES['ADMIN'])
            <div class="col s12 m4 l4 pointer">
                <a href="{{route('pays.index')}}">
                    <div class="hoverable card-panel cyan darken-3 white-text center">
                        <h5>Phần trăm</h5>
                    </div>
                </a>
            </div>
            @endif
            <div class="col s12 m4 l4 pointer">
                <a href="{{route('detail-shippers.index')}}">
                    <div class="hoverable card-panel cyan darken-3 white-text center">
                        <h5>Cài đặt shipper</h5>
                    </div>
                </a>
            </div>
            <div class="col s12 m4 l4 pointer">
                <a href="{{route('orders.index')}}">
                    <div class="hoverable card-panel cyan darken-3 white-text center">
                        <h5>Đơn hàng</h5>
                    </div>
                </a>
            </div>
            @if(App\Fun\__::get_role_code(Auth::user()->id) === App\Fun\__::ROLES['ADMIN'])
                <div class="col s12 m4 l4 pointer">
                    <a href="{{route('units.index')}}">
                        <div class="hoverable card-panel cyan darken-3 white-text center">
                            <h5>Đơn vị tính</h5>
                        </div>
                    </a>
                </div>
                @endif
                <input type="hidden" id="object" value="PageCommon" />
                @endsection
                @section('script')
                <script type="module" src="{{url('js/app.js')}}"></script>
                @endsection