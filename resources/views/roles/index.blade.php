@extends('container.index')
@section('content')
<nav>
    <div class="nav-wrapper">
        <div class="col s12">
            <a href="{{route('dashboard')}}" class="breadcrumb">Bảng điều khiển</a>
            <a href="{{route('roles.index')}}" class="breadcrumb">Nhóm người dùng</a>
        </div>
    </div>
</nav>
<div class="row">
    <div class="input-field col s12">
        <input id="txt" type="text" class="validate">
        <label for="txt">Tìm kiếm</label>
    </div>
</div>
<div class="card-panel">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $value)
            <tr>
                <td>{{$value->id}}</td>
                <td>{{$value->name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    <center>
      {{ $data->links() }}
    </center>
</div>
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large pink" href="{{route('roles.create')}}">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
@section('script')
<script>
    console.clear();
    document.querySelector("#txt").addEventListener("input", () => {
        let count = 0;
        let rows = document.getElementsByTagName("table")[0].rows;
        for (let i = 1; i < rows.length; i++) {
            for (let cell = 0; cell < rows[i].childNodes.length; cell++) {
                if (rows[i].childNodes[cell].childNodes.length !== 0) {
                    if (rows[i].childNodes[cell].childNodes[0].nodeValue.toUpperCase().indexOf(this.value.toUpperCase()) > -1) {
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
