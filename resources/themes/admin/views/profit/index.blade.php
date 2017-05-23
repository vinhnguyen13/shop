@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Profit', 'h1_href'=>route('admin.order.index'), 'h1_small'=>'Profit Management']])
@endsection

@section('content')
    @php
    $suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('name', 'id')->prepend('- Supplier -', 0);
    @endphp
    <div class="box wrapRevenue">
        <div class="box-header with-border">
            <h3 class="box-title">Profit Management</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="revenueForm">
                        <div class="box-body">
                            <div class="col-xs-2">
                                <input type="text" class="form-control date" placeholder="FROM" name="from_date" value="">
                            </div>
                            <div class="col-xs-2">
                                <input type="text" class="form-control date" placeholder="TO" name="to_date" value="">
                            </div>
                            <div class="col-xs-2">
                                {!! Form::select('supplier', $suppliers, null, ['class' => 'form-control supplier-list']) !!}
                            </div>
                            <div class="col-xs-2">
                                {!! Form::select('debt', app(\App\Models\ShopProductDetail::class)->getDebtStatus(), null, ['class'=>'form-control', 'placeholder'=>'Payment Status']) !!}
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-filter">Find</button>
                                <button type="submit" class="btn btn-primary btn-reset">Reset</button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div>
            <div class="box-body-grid">
                @include('profit.partials.grid-profit')
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal-relogin" data-backdrop="static">
            <div class="modal-dialog" style="width: 350px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-book"></i> Staff </h4>
                    </div>
                    <div class="modal-body">
                        <p class="hint">
                            Đây là phần thanh toán tiền cho supplier.<br/>
                            Vì vậy chúng tôi cần xác thực bạn có phải là nhân viên của chúng tôi không ?
                        </p>
                        <div class="alert alert-danger alert-dismissable hide">
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <p></p>
                        </div>
                        <input type="text" class="form-control" placeholder="Email" name="email">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-payment-supplier-verified"><i class="fa fa-check"></i> Sign In</button>
                    </div>
                </div>
            </div>
        </div>

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