<!DOCTYPE html>
<html>

<head>
    <title>Hệ thống quản lý giao dịch chuyển hàng | Admin</title>
    <meta charset="UTF-8">
    <meta name="description" content="LAMP stack on Heroku" />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/png" href="{{ url("img/favicon.png") }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/tabulator-tables@4.5.1/dist/css/tabulator.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="{{url('css/index.css')}}" />
    @yield('style')
</head>

<body class="grey darken-3">
    <nav class="grey darken-3">
        <div class="container">
            <div class="nav-wrapper">
                <a href="{{route('dashboard')}}" class="brand-logo center hide-on-med-and-down">Quản lý chuyển hàng</a>
                <a href="#" title="Danh sách điều hướng" data-target="slide-out" class="sidenav-trigger button-collapse show-on-large right">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="{{route('dashboard')}}" title="Bảng điều khiển"><i class="material-icons">dashboard</i></a>
                    </li>
                </ul>
                <ul id="slide-out" class="sidenav grey darken-3">
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <div style="width: 1280px; height: 720px;" class="grey darken-3">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="{{Request::is('/*') ? 'active' : ''}}">
                        <a href="{{route('dashboard')}}" title="Bảng điều khiển" class="white-text"><i class="material-icons white-text">dashboard</i>Quản
                            lý chuyển hàng</a>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li class="{{Request::is('portal*') ? 'active' : ''}}">
                        <a href="{{route('portal.index')}}" class="white-text">
                            Portal
                        </a>
                    </li>
                    <li class="{{Request::is('roles*') ? 'active' : ''}}">
                        <a href="{{route('roles.index')}}" class="white-text">
                            Nhóm người dùng
                        </a>
                    </li>
                    <li class="{{Request::is('users*') ? 'active' : ''}}">
                        <a href="{{route('users.index')}}" class="white-text">
                            Người dùng
                        </a>
                    </li>
                    <li class="{{Request::is('prices*') ? 'active' : ''}}">
                        <a href="{{route('prices.index')}}" class="white-text">
                            Cài đặt giá
                        </a>
                    </li>
                    <li class="{{Request::is('pays*') ? 'active' : ''}}">
                        <a href="{{route('pays.index')}}" class="white-text">
                            Cài đặt phần trăm
                        </a>
                    </li>
                    <li class="{{Request::is('detail-shippers*') ? 'active' : ''}}">
                        <a href="{{route('detail-shippers.index')}}" class="white-text">
                            Cài đặt shipper
                        </a>
                    </li>
                    <li class="{{Request::is('orders*') ? 'active' : ''}}">
                        <a href="{{route('orders.index')}}" class="white-text">
                            Đơn hàng
                        </a>
                    </li>
                    <li class="{{Request::is('units*') ? 'active' : ''}}">
                        <a href="{{route('units.index')}}" class="white-text">
                            Đơn vị tính
                        </a>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    {{-- <li>
                        <a href="" class="white-text"><i class="material-icons white-text">exit_to_app</i>
                            Đăng xuất
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>
    <section class="section section-visitors lighten-4">
        <div class="row">
            <div class="col s12 m12 l12">
                @yield('content')
            </div>
        </div>
        @yield('fix-btn')
    </section>
    <div class="main-loader" style="display:none;">
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-black-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
    <footer class="section grey darken-3 white-text center">
        <p><b>#2020</b> <i class="icon ion-heart"></i> <i class="ion-social-tux"></i> <i class="ion-social-octocat"></i></p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>
    <script src="{{url('app/qrcode.js')}}"></script>
    <script src="{{url('app/container/index.js')}}"></script>
    @yield('script')
</body>

</html>