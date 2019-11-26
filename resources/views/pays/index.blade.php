@extends('container.index')
@section('content')
<nav class="nav-top">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('pays.index')}}" class="breadcrumb hide-on-med-and-down">Cài đặt phần trăm</a>
    </div>
</nav>
<div class="section">
    <div class="row">
        <div class="col s12">
            <nav style="background-color:#e91e63">
                <div class="nav-wrapper">
                    <div class="input-field">
                        <input id="txt" type="search" required>
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
    @else
    <div class="alert success">
        @endif
        <span class="closebtn">&times;</span>
        {{Session::get('message')}}
    </div>
    @endif
    <div class="card-panel">
        <table class="highlight responsive-table">
            <thead>
                <tr>
                    <th>Phần Trăm %</th>
                    <th>Trạng Thái</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody id="tbl">
                @foreach ($data as $value)
                <tr>
                    <td>{{$value->percent}}</td>
                    <td>
                        <form method="POST" action="{{route('pays.status')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$value->id}}"></input>
                            @if($value->turn_on == 0)
                                <button class="waves-effect waves-light btn btn-small pink lighten-1">bật</button>
                                @elseif($value->turn_on == 1)
                                    <button class="waves-effect waves-light btn btn-small green accent-3 lighten-1">tắt</button>
                                    @endif
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{route('pays.destroy', [$value->id])}}">
                            @method('DELETE')
                            @csrf
                            <button class="waves-effect waves-light btn btn-small red darken-2 lighten-1">xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($data->count() == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="row">

    </div>
    @endsection
    @section('fix-btn')
    <div class="row">
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large pink modal-trigger" href="{{route('pays.create')}}">
                <i class="material-icons">add</i>
            </a>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        console.clear();
        document.querySelector("#txt").addEventListener("input", function() {
            let count = 0;
            let rows = document.getElementsByTagName("table")[0].rows;
            for (let i = 1; i < rows.length; i++) {
                for (let cell = 0; cell < rows[i].childNodes.length; cell++) {
                    if (rows[i].childNodes[cell].childNodes.length !== 0) {
                        if (rows[i].childNodes[cell].childNodes[0].nodeValue.toUpperCase().indexOf(this.value
                                .toUpperCase()) > -1) {
                            rows[i].style.display = "";
                            count++;
                            break;
                        } else {
                            rows[i].style.display = "none";
                        }
                    }
                }
            }
            if (count === 0) {
                rows[0].style.display = "none";
            } else {
                rows[0].style.display = "";
            }
        });
    </script>
    @endsection
