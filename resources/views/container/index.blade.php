<!DOCTYPE html>
<html>

<head>
    <title>Hệ thống quản lý giao dịch chuyển hàng | Admin</title>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/png" href="{{ url("img/favicon.png") }}">
    <!--Import Google Icon Font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/tabulator-tables@4.4.1/dist/css/tabulator.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="{{url('css/index.css')}}" />
    @yield('style')
</head>

<body class="grey lighten-4">
    <nav class="grey darken-4">
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
                <ul id="slide-out" class="sidenav">
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <div style="width: 1280px; height: 720px; background-color: #212121">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="{{Request::is('/*') ? 'active' : ''}}">
                        <a href="{{route('dashboard')}}" title="Bảng điều khiển"><i class="material-icons">dashboard</i>Quản
                            lý chuyển hàng</a>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li class="{{Request::is('roles*') ? 'active' : ''}}">
                        <a href="{{route('roles.index')}}">
                            Nhóm người dùng
                        </a>
                    </li>
                    <li class="{{Request::is('users*') ? 'active' : ''}}">
                        <a href="{{route('users.index')}}">
                            Người dùng
                        </a>
                    </li>
                    <li class="{{Request::is('prices*') ? 'active' : ''}}">
                        <a href="{{route('prices.index')}}">
                            Cài đặt giá
                        </a>
                    </li>
                    <li class="{{Request::is('pays*') ? 'active' : ''}}">
                        <a href="{{route('pays.index')}}">
                            Cài đặt phần trăm
                        </a>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li>
                        <a href=""><i class="material-icons">exit_to_app</i>
                            Đăng xuất
                        </a>
                    </li>
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
    <footer class="section grey darken-4 white-text center">
        <p><b>2019</b> <i class="icon ion-heart"></i> <i class="ion-social-tux"></i> <i class="ion-social-octocat"></i></p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>
    <script src="https://unpkg.com/tabulator-tables@4.4.1/dist/js/tabulator.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{url('js/container/index.js')}}"></script>
    @yield('script')
</body>

</html>
