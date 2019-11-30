@extends('container.index')
@section('content')
<nav class="nav-top">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('users.index')}}" class="breadcrumb hide-on-med-and-down">Người dùng</a>
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
    <span class="closebtn">&times;</span>
    {{Session::get('message')}}
</div>
@else
<div class="alert success">
    <span class="closebtn">&times;</span>
    {{Session::get('message')}}
</div>
@endif
@endif
<div class="card-panel">
    <table class="highlight responsive-table">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Ảnh đại diện</th>
                <th>Email</th>
                <th>Giớ tính</th>
                <th>Ngày sinh</th>
                <th>Số điện thoại</th>
                <th>Số CMND</th>
                <th>Cập nhật</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody id="tbl">
            @if(!empty($data))
            @foreach ($data as $value)
            <tr>
                <td>{{$value->name}}</td>
                <td><img class="materialboxed" width="100" src="{{url('img') . '/' .$value->path}}" /></td>
                <td>{{$value->email}}</td>
                <td>{{$value->gender}}</td>
                <td>{{$value->birthdate}}</td>
                <td>{{$value->phone}}</td>
                <td>{{$value->identity_card}}</td>
                <td>
                    <form method="GET" action="{{route('users.edit', [$value->id])}}">
                        <button class="waves-effect waves-light btn btn-small red darken-2 lighten-1">xóa</button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{route('users.status')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$value->id}}"></input>
                        @if($value->status == 2)
                            <button class="waves-effect waves-light btn btn-small pink lighten-1">khóa</button>
                            @elseif($value->status == 3)
                                <button class="waves-effect waves-light btn btn-small green accent-3 lighten-1">mở khóa</button>
                                @endif
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
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
        <a class="btn-floating btn-large pink modal-trigger" href="{{route('users.create')}}">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
@section('script')
<script>
    console.clear();
    $('.materialboxed').materialbox();
    document.querySelector("#txt").addEventListener("input", function() {
        let count = 0;
        let rows = document.getElementsByTagName("table")[0].rows;
        for (let i = 1; i < rows.length; i++) {
            for (let cell = 0; cell < rows[i].childNodes.length; cell++) {
                if (rows[i].childNodes[cell].firstChild != null) {
                    if (rows[i].childNodes[cell].firstChild.className === "material-placeholder") {
                        continue;
                    }
                }
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
