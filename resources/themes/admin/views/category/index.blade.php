@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Profit', 'h1_href'=>route('admin.order.index'), 'h1_small'=>'Profit Management']])
@endsection

@section('content')
    <div class="box wrapRevenue">
        <div class="box-header with-border">
            <h3 class="box-title">Profit Management</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="box-body-grid">
                @if(!empty($categories))
                    <table class="table table-bordered">
                        <tbody><tr>
                            <th style="width: 10px">ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
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
                                <td>{{$category->updated_at}}</td>
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

        <div class="modal fade" id="modal-consignment" data-backdrop="static">
            <div class="modal-dialog" style="width: 100%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-book"></i> Thanh toán cho CH03 </h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-xs-12">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-print" data-dismiss="modal"><i class="fa fa-check"></i> Print & Update Payment Status</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Modal -->
    </div>

    <div id="iframeplaceholder"></div>
@endsection

@push('styles')
<link rel="stylesheet" href="/themes/admin/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="/themes/admin/plugins/select2/select2.min.css">
@endpush

@push('scripts')
<script src="/themes/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/themes/admin/plugins/select2/select2.js"></script>
<script type="text/javascript">
    $(function() {
        var urlLoadGrid = '{{route('admin.profit.index')}}';
        var urlUserVerify = '{{route('admin.user.verify')}}';
        var urlDebtPaymentDueDate = '{{route('admin.profit.debtPaymentDueDate')}}';

        $('.date').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });

        $( ".supplier-list" ).select2();

        $('.wrapRevenue').on('click', '.btn-reset', function (e) {
            $('.wrapRevenue').trigger('revenue/loadGrid', [1]);
            return false;
        });

        $('.wrapRevenue').on('click', '.btn-filter', function (e) {
            var params = $('#revenueForm').serialize();
            var supplierVal = $('.supplier-list').val();
            $('.wrapRevenue').trigger('revenue/loadGrid', [params]);
            return false;
        });


        $('.wrapRevenue').bind('revenue/loadGrid', function (event, params) {
            if (urlLoadGrid) {
                $('.wrapRevenue').loading({display: true});
                $.ajax({
                    type: "post",
                    dataType: 'html',
                    url: urlLoadGrid,
                    data: params,
                    success: function (data) {
                        $('.wrapRevenue .box-body-grid').html(data);
                        $('.wrapRevenue').loading({display: false});
                    },
                    error: function (error) {
                    }
                });
            }
        });

    });
</script>
@endpush