@extends('container.index')
@section('content')
<nav>
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('pays.index')}}" class="breadcrumb hide-on-med-and-down">Cài đặt phần trăm</a>
    </div>
</nav>
<div class="row">
    <div class="input-field col s12">
        <input id="txt" type="text" class="validate">
        <label for="txt">Tìm kiếm</label>
    </div>
</div>
@if(!empty(Session::get('message')))
<div class="alert success">
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
    document.querySelector("#txt").addEventListener("input", function () {
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
