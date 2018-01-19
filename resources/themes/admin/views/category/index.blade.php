@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Category', 'h1_href'=>route('admin.order.index'), 'h1_small'=>'Category Management']])
@endsection

@section('content')
    <div class="box wrapRevenue">
        <div class="box-header with-border">
            <h3 class="box-title">Category Management</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
        	<div class="col-md-12">
                <div class="box box-info">
                    <div class="box-footer">
                        <div class="col-xs-4">
                            <a href="{{route('admin.category.create')}}" class="btn btn-success">Create</a>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>
            <div class="box-body-grid">
                @if(!empty($categories))
                    <table class="table table-bordered">
                        <tbody><tr>
                            <th style="width: 10px">ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                        @foreach($categories as $category)
                            @php
                            $level = str_repeat("-", $category->depth);
                            @endphp
                            <tr>
                                <td>{{$category->id}}</td>
                                <td>{{$level.' '.$category->name}}</td>
                                <td>{{$category->slug}}</td>
                                <td>{{$category->status}}</td>
                                <td>{{$category->total}}</td>
                                <td>{{date('d-m-Y', strtotime($category->updated_at))}}</td>
                                <td>
                                    <a href="{{route('admin.category.show', ['id'=>$category->id])}}" class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-original-title="View"></a>
                                    <a href="{{route('admin.category.edit', ['id'=>$category->id])}}" class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-original-title="Edit"></a>
                                    <a href="{{route('admin.category.delete', ['id'=>$category->id])}}" class="glyphicon glyphicon-trash glyphicon-last-child" data-toggle="tooltip" data-original-title="Delete"></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination pagination-sm no-margin pull-right">
                    </div>
                @endif
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
        </div>
        <!-- Modal -->

        <!-- /.Modal -->
    </div>

@endsection

@push('styles')
@endpush

@push('scripts')
<script type="text/javascript">
    $(function() {

    });
</script>
@endpush