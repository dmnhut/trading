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
    <div style="overflow-x:auto;">
        <table class="activated">
            <thead>
                <tr>
                    <th>Họ tên</th>
                    <th>Ảnh đại diện</th>
                    <th>Email</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Số CMND</th>
                    <th>Cập nhật</th>
                    @if($role === App\Fun\__::ROLES['ADMIN'])
                    <th>Trạng thái</th>
                    <th>Xóa</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if(!empty($data))
                @foreach ($data as $value)
                <tr>
                    <td data-label="Họ tên">{{$value->name}}</td>
                    <td data-label="Ảnh đại diện">
                        @if(empty($value->path))
                            <img class="materialboxed" width="100" src="https://via.placeholder.com/100" />
                            @else
                            <img class="materialboxed" width="100" src="{{url('img') . '/' .$value->path}}" />
                            @endif
                    </td>
                    <td data-label="Email">{{$value->email}}</td>
                    <td data-label="Giới tính">{{$value->gender}}</td>
                    <td data-label="Ngày sinh">{{$value->birthdate}}</td>
                    <td data-label="Số điện thoại">{{$value->phone}}</td>
                    <td data-label="Số CMND">{{$value->identity_card}}</td>
                    <td data-label="Cập nhật">
                        <form method="GET" action="{{route('users.edit', [$value->id])}}">
                            <button class="waves-effect waves-light btn btn-small green darken-3">cập nhật</button>
                        </form>
                    </td>
                    @if($role === App\Fun\__::ROLES['ADMIN'])
                    <td data-label="Trạng thái">
                        <form method="POST" action="{{route('users.status')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$value->id}}" />
                            @if($value->status == App\Fun\__::STATUS[0])<button class="waves-effect waves-light btn btn-small light-green darken-3">khóa</button>
                                @elseif($value->status == App\Fun\__::STATUS[1])<button class="waves-effect waves-light btn btn-small light-green darken-3">mở khóa</button>
                                    @endif
                        </form>
                    </td>
                    <td data-label="Xóa">
                        <form method="POST" action="{{route('users.destroy', [$value->id])}}">
                            @method('DELETE')
                            @csrf
                            <button class="waves-effect waves-light btn btn-small grey darken-2">xóa</button>
                        </form>
                    </td>
                    @endif
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
                    @if($role === App\Fun\__::ROLES['ADMIN'])
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    @endif
                </tr>
                @endif
            </tbody>
        </table>
    </div>
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
<input type="hidden" id="object" value="PageCommon" />
@endsection
@if($role === App\Fun\__::ROLES['ADMIN'])
@section('fix-btn')
<div class="row">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large modal-trigger grey darken-3" href="{{route('users.create')}}">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection
@endif
@section('script')
<script type="module" src="{{url('js/app.js')}}"></script>
@endsection