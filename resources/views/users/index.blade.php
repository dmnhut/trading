@extends('container.index')
@section('content')
<nav>
    <div class="nav-wrapper">
        <a href="" class="breadcrumb">Bảng điều khiển</a>
        <a href="" class="breadcrumb">Tài khoản người dùng</a>
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
                <th>Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Tên tài khoản</th>
                <th>Giới tính</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@endsection
@section('script')
<script>
    console.clear();
    document.querySelector('#txt').addEventListener('input', function () {
        let count = 0;
        let rows = document.getElementsByTagName('table')[0].rows;
        for (let i = 1; i < rows.length; i++) {
            for (let cell = 0; cell < rows[i].childNodes.length; cell++) {
                if (rows[i].childNodes[cell].childNodes.length !== 0) {
                    if (rows[i].childNodes[cell].childNodes[0].nodeValue.toUpperCase().indexOf(this.value
                            .toUpperCase()) > -1) {
                        rows[i].style.display = '';
                        count++;
                        break;
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
        if (count === 0) {
            rows[0].style.display = 'none';
        } else {
            rows[0].style.display = '';
        }
    });

</script>
@endsection
