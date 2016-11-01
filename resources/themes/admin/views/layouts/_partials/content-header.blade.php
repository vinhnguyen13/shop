<!-- Content Header (Page header) -->
@if ($data)
    <section class="content-header">
        <h1>
            <a href="{{!empty($data['h1_href']) ? $data['h1_href'] : '#'}}">{{!empty($data['h1']) ? $data['h1'] : 'Admin'}}</a>
            <small>{{!empty($data['h1_small']) ? $data['h1_small'] : 'Admin Management'}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.home.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="{{!empty($data['h1_href']) ? $data['h1_href'] : '#'}}">{{!empty($data['h1']) ? $data['h1'] : 'Admin'}}</a></li>
        </ol>
    </section>
@else
    <section class="content-header">
        <h1>
            Admin
            <small>Admin Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.home.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Admin</li>
        </ol>
    </section>
@endif