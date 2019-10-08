@extends('container.index')
@section('content')
<nav>
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">Bảng điều khiển</a>
        <a href="{{route('prices.index')}}" class="breadcrumb hide-on-med-and-down">Cài đặt giá</a>
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
                <th>&lt;= Số Kg</th>
                <th>Giá Tiền</th>
                <th>Trạng Thái</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody id="tbl">
            @foreach ($data as $value)
            <tr>
                <td>{{$value->kg}}</td>
                <td>{{$value->amount}}</td>
                <td>
                    <form method="POST" action="{{route('prices.status')}}">
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
                    <form method="POST" action="{{route('prices.destroy', [$value->id])}}">
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
        <a class="btn-floating btn-large pink modal-trigger" href="#modal-add">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
<div id="modal-add" class="modal">
    <div class="modal-content">
        <h5>Thêm mới cài đặt giá</h5>
        <div class="row card-panel">
            <div class="row">
                <div class="input-field col s12">
                    <input id="kg" name="kg" type="number">
                    <label>Số kg</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="amount" name="amount" type="number">
                    <label>Giá Tiền</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button id="btn-cancel" class="waves-effect waves-light btn btn-cancel">Hủy</button>
        <button id="btn-add" class="waves-effect waves-light btn pink lighten-1">Thêm mới</button>
    </div>
</div>
@endsection
@section('script')
<script>
    console.clear();
    $(document).ready(() => {
        $(".modal").modal();
    });
    document.querySelector("#btn-cancel").addEventListener("click", () => {
        $(".modal").modal();
        document.querySelector("#kg").value = "";
        document.querySelector("#amount").value = "";
    });
    document.querySelector("#btn-add").addEventListener("click", () => {
        axios.post("{{route('prices.store')}}", {
                _token: "{{ csrf_token() }}",
                "kg": document.querySelector("#kg").value,
                "amount": document.querySelector("#amount").value
            })
            .then(function (response) {
                $(".modal").modal();
                toastr.success(response.data.message);
                document.querySelector("#kg").value = "";
                document.querySelector("#amount").value = "";
                document.querySelector("#tbl").innerHTML = "";
                let tbody = "";
                response.data.data.map((val) => {
                    tbody += "<tr>";
                    tbody += "<td>" + val.kg + "</td>";
                    tbody += "<td>" + val.amount + "</td>";
                    tbody += "<td>";
                    tbody += "<form method='POST' action='{{route('prices.status')}}'>";
                    tbody += "<input type='hidden' name='_token' value='{{csrf_token()}}'>";
                    tbody += "<input type='hidden' name='id' value='" + val.id + "'></input>";
                    if (val.turn_on == 0) {
                        tbody +=
                            "<button class='waves-effect waves-light btn btn-small pink lighten-1'>bật</button>";
                    } else {
                        tbody +=
                            "<button class='waves-effect waves-light btn btn-small green accent-3 lighten-1'>tắt</button>";
                    }
                    tbody += "</form>";
                    tbody += "</td>";

                    tbody += "<td>";
                    tbody += "<form method='POST' action='" + val.url + "'>";
                    tbody += "<input type='hidden' name='_method' value='DELETE'>";
                    tbody += "<input type='hidden' name='_token' value='{{csrf_token()}}'>";
                    tbody +=
                        "<button class='waves-effect waves-light btn btn-small red darken-2 lighten-1'>xóa</button>";
                    tbody += "</form>";
                    tbody += "</td>";

                    tbody += "</tr>";
                });
                document.querySelector("#tbl").innerHTML = tbody;
            })
            .catch(function (error) {
                console.log(error);
            });
    });
    document.querySelector("#txt").addEventListener("input", () => {
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
