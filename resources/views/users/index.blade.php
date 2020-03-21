@extends('container.index')
@section('content')
<nav class="nav-top teal darken-3">
    <div class="nav-wrapper">
        <a href="{{route('dashboard')}}" class="breadcrumb hide-on-med-and-down">&nbsp;&nbsp;Bảng điều khiển</a>
        <a href="{{route('users.index')}}" class="breadcrumb hide-on-med-and-down">Người dùng</a>
    </div>
</nav>
<div class="section">
    <div class="row">
        <div class="col s12">
            <nav class="cyan darken-3">
                <div class="nav-wrapper">
                    <div class="input-field">
                        <input id="txt" class="tooltipped" type="search" data-position="bottom" data-tooltip="Nhập vào thông tin cần tìm kiếm">
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
<div class="card-panel grey darken-3 white-text">
    <table class="highlight responsive-table activated">
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
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data))
            @foreach ($data as $value)
            <tr>
                <td>{{$value->name}}</td>
                <td>
                    @if(empty($value->path))
                        <img class="materialboxed" width="100" src="https://via.placeholder.com/100" />
                        @else
                        <img class="materialboxed" width="100" src="{{url('img') . '/' .$value->path}}" />
                        @endif
                </td>
                <td>{{$value->email}}</td>
                <td>{{$value->gender}}</td>
                <td>{{$value->birthdate}}</td>
                <td>{{$value->phone}}</td>
                <td>{{$value->identity_card}}</td>
                <td>
                    <form method="GET" action="{{route('users.edit', [$value->id])}}">
                        <button class="waves-effect waves-light btn btn-small green darken-3">cập nhật</button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{route('users.status')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$value->id}}" />
                        @if($value->status == App\Fun\__::STATUS[0])<button class="waves-effect waves-light btn btn-small light-green darken-3">khóa</button>
                            @elseif($value->status == App\Fun\__::STATUS[1])<button class="waves-effect waves-light btn btn-small light-green darken-3">mở khóa</button>
                                @endif
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{route('users.destroy', [$value->id])}}">
                        @method('DELETE')
                        @csrf
                        <button class="waves-effect waves-light btn btn-small grey darken-2">xóa</button>
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
                <th>&nbsp;</th>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<ul class="pagination">
    @for ($i = 1; $i
    <= $page_number; $i++) @if($page_active == $i)
    <li class="active"><a href="{{route('users.index', ['page' => $i])}}">{{$i}}</a></li>
    @else
    <li class="waves-effect"><a href="{{route('users.index', ['page' => $i])}}">{{$i}}</a></li>
    @endif
    @endfor
</ul>
@endsection
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large modal-trigger grey darken-3" href="{{route('users.create')}}">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection