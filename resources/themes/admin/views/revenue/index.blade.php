@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Order', 'h1_href'=>route('admin.order.index'), 'h1_small'=>'Order Management']])
@endsection

@section('content')
    <div class="box wrapRevenue">
        <div class="box-header with-border">
            <h3 class="box-title">Order Management</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-12">
                <div class="box-body">
                    <div class="row">
                        <form id="revenueForm">
                            <div class="col-xs-2">
                                <input type="text" class="form-control date" placeholder="FROM" name="from_date">
                            </div>
                            <div class="col-xs-2">
                                <input type="text" class="form-control date" placeholder="TO" name="to_date">
                            </div>
                            <div class="col-xs-2">
                                <input type="text" class="form-control supplier" placeholder="SUPPLIER" name="supplier">
                            </div>
                            <div class="col-xs-2">
                                {!! Form::select('', [''], null, ['class'=>'form-control', 'placeholder'=>'Payment Status']) !!}
                            </div>
                            <div class="col-xs-2">
                                {!! Form::select('', [''], null, ['class'=>'form-control', 'placeholder'=>'Payment Status']) !!}
                            </div>
                            <div class="col-xs-1">
                                <button type="submit" class="btn btn-primary btn-filter">Find</button>
                            </div>
                            <div class="col-xs-1">
                                <button type="submit" class="btn btn-primary btn-filter">Payment for supplier</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-body -->
            </div>
            <div class="box-body-grid">
                @include('revenue.partials.grid')
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="/themes/admin/plugins/datepicker/datepicker3.css">
@endpush

@push('scripts')
<script src="/themes/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function() {
        var urlLoadGrid = '{{route('admin.revenue.index')}}';

        $('.date').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });

        $('.wrapRevenue').on('click', '.btn-filter', function (e) {
            var params = $('#revenueForm').serialize();
            $('.wrapRevenue').trigger('revenue/loadGrid', [params]);
            return false;
        });

        $('.wrapRevenue').bind('revenue/loadGrid', function (event, params) {
            console.log(params);
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