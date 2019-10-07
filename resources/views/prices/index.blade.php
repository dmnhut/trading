@extends('container.index')
@section('content')
<nav>
    <div class="nav-wrapper">
        <div class="col s12">
            <a href="{{route('dashboard')}}" class="breadcrumb">Bảng điều khiển</a>
            <a href="{{route('prices.index')}}" class="breadcrumb">Cài đặt giá</a>
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
                <th>Số Kg</th>
                <th>Giá Tiền</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $value)
            <tr>
                <td>{{$value->kg}}</td>
                <td>{{$value->amount}}</td>
                <td id="prices-{{$value->id}}"></td>
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
        <a class="btn-floating btn-large pink modal-trigger" href="#modal">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
<!-- Modal Structure -->
<div id="modal" class="modal">
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
        <button id="btn-cancel" class="waves-effect waves-light btn">Hủy</button>
        <button id="btn-add" class="waves-effect waves-light btn pink lighten-1">Thêm mới</button>
    </div>
</div>
@endsection
@section('script')
<script>
    console.clear();
    $(document).ready(function() {
        $(".modal").modal();
    });
    document.querySelector("#btn-cancel").addEventListener("click", function() {
        $(".modal").modal();
        document.querySelector("#kg").value = "";
        document.querySelector("#amount").value = "";
    });
    document.querySelector("#btn-add").addEventListener("click", function() {
        axios.post("{{route('prices.store')}}", {
                _token: "{{ csrf_token() }}",
                "kg": document.querySelector("#kg").value,
                "amount": document.querySelector("#amount").value
            })
            .then(function(response) {
                $(".modal").modal();
                toastr.success(response.data.message);
                document.querySelector("#kg").value = "";
                document.querySelector("#amount").value = "";
                console.log(response.data.message);
            })
            .catch(function(error) {
                console.log(error);
            });
    });
    document.querySelector("#txt").addEventListener("input", function() {
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
