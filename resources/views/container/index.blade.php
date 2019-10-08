<!DOCTYPE html>
<html>

<head>
    <title>Hệ thống quản lý giao dịch chuyển hàng | Admin</title>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/png" href="{{ url("material/img/favicon.png") }}">
    <!--Import Google Icon Font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="{{ url("material/css/materialize.min.css") }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ url("material/css/main.css") }}" />
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/tabulator-tables@4.4.1/dist/css/tabulator.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <style>
        .pointer {
            cursor: pointer;
        }

        @media(max-width: 650px) {
            .brand-logo {
                display: none !important;
            }
        }

        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
            opacity: 1;
            transition: opacity 0.6s;
            margin-bottom: 15px;
        }

        .alert.success {
            background-color: #4CAF50;
        }

        .alert.info {
            background-color: #2196F3;
        }

        .alert.warning {
            background-color: #ff9800;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }

    </style>
    @yield('style')
</head>

<body class="grey lighten-4">
    <nav class="grey darken-4">
        <div class="container">
            <div class="nav-wrapper">
                <a href="" class="brand-logo center hide-on-med-and-down">Quản lý chuyển hàng</a>
                <a href="#" title="Danh sách điều hướng" data-activates="side-nav"
                    class="button-collapse show-on-large right">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="{{route('dashboard')}}" title="Bảng điều khiển"><i
                                class="material-icons">dashboard</i></a>
                    </li>
                </ul>
                <ul id="side-nav" class="side-nav">
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <div style="width: 1280px; height: 720px; background-color: #212121">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="{{route('dashboard')}}" title="Bảng điều khiển"><i
                                class="material-icons">dashboard</i>Quản
                            lý chuyển hàng</a>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li>
                        <a href="{{route('roles.index')}}">
                            Nhóm người dùng
                        </a>
                    </li>
                    <li>
                        <a href="{{route('prices.index')}}">
                            Cài đặt giá
                        </a>
                    </li>
                    <li>
                        <a href="{{route('pays.index')}}">
                            Cài đặt phần trăm
                        </a>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    {{-- <li>
                        <a href=""><i class="material-icons">exit_to_app</i>
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
        {{--<div class="fixed-action-btn">--}}
        {{--<a class="btn-floating btn-large pink">--}}
        {{--<i class="material-icons">add</i>--}}
        {{--</a>--}}
        {{--</div>--}}
    </section>
    <footer class="section grey darken-4 white-text center">
        <p><b>&copy; 2019</b> <i class="icon ion-heart"></i> <b>Github</b></p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>
    <script src="https://unpkg.com/tabulator-tables@4.4.1/dist/js/tabulator.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script src="{{ url("material/js/materialize.min.js") }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $('.button-collapse').sideNav();
        var close = document.getElementsByClassName("closebtn");
        var i;

        for (i = 0; i < close.length; i++) {
            close[i].onclick = function () {
                var div = this.parentElement;
                div.style.opacity = "0";
                setTimeout(function () {
                    div.style.display = "none";
                }, 600);
            }
        }

    </script>
    @yield('script')
</body>

</html>
