@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'User', 'h1_href'=>route('admin.user.index'), 'h1_small'=>'User Management']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">User Management</h3>
        </div>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Cache</th>
                <th>Description</th>
                <th style="width: 40px">Action</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>Meta</td>
                <td>
                    Cache for meta data
                </td>
                <td>
                    <a href="{{route('admin.cache.clear', ['key'=>'meta'])}}" class="glyphicon glyphicon-trash glyphicon-last-child" data-toggle="tooltip" data-original-title="Delete"></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
