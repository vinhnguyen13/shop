@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Debt', 'h1_href'=>route('admin.order.index'), 'h1_small'=>'Debt Management']])
@endsection

@section('content')
    @php
    $suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('name', 'id')->prepend('- Supplier -', 0);
    @endphp
    <div class="box wrapDebt">
        <div class="box-header with-border">
            <h3 class="box-title">Debt Management</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="DebtForm">
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
                                <button type="submit" class="btn btn-reset">Reset</button>
                                <button type="submit" class="btn btn-primary btn-payment-supplier">Debt payment</button>
                                <button type="button" class="btn btn-print" data-dismiss="modal"><i class="fa fa-check"></i> Print Example</button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div>
            <div class="box-body-grid">
                @include('profit.partials.grid-debt')
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

        $('.btn-payment-supplier').addClass('hide');
        $('.btn-print').addClass('hide');

        $( ".supplier-list" ).select2();

        $('.wrapDebt').on('click', '.btn-reset', function (e) {
            $('.wrapDebt').trigger('Debt/loadGrid', [1]);
            return false;
        });

        $('.wrapDebt').on('click', '.btn-filter', function (e) {
            var params = $('#DebtForm').serialize();
            var supplierVal = $('.supplier-list').val();
            if(supplierVal > 0){
                $('.btn-payment-supplier').removeClass('hide');
                $('.btn-print').removeClass('hide');
            }else{
                $('.btn-payment-supplier').addClass('hide');
                $('.btn-print').addClass('hide');
            }
            $('.wrapDebt').trigger('Debt/loadGrid', [params]);
            return false;
        });

        $('.wrapDebt').on('click', '.btn-payment-supplier', function (e) {
            $('#modal-relogin').modal('show');
            return false;
        });

        $('.wrapDebt').on('click', '.btn-payment-supplier-verified', function (e) {
            var email = $('input[name="email"]').val();
            var password = $('input[name="password"]').val();
            $('#modal-relogin .alert-danger').addClass('hide');
            if (urlUserVerify) {
                $('#modal-relogin').loading({display: true});
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    url: urlUserVerify,
                    data: {email: email, password: password},
                    success: function (data) {
                        if(data.code == 0){
                            var params = $('#DebtForm').serialize();
                            $.ajax({
                                type: "get",
                                dataType: 'html',
                                url: urlDebtPaymentDueDate+'?'+params,
                                success: function (data) {
                                    $('#modal-relogin').modal('hide');
                                    $('#modal-consignment .modal-body div div').html(data);
                                    $('#modal-consignment').modal('show');
                                },
                                error: function (error) {
                                }
                            });
                        }else{
                            $('#modal-relogin .alert-danger p').html(data.message);
                            $('#modal-relogin .alert-danger').removeClass('hide');

                        }
                        $('#modal-relogin').loading({display: false});
                    },
                    error: function (error) {
                    }
                });
            }

            return false;
        });

        $('.wrapDebt').bind('Debt/loadGrid', function (event, params) {
            if (urlLoadGrid) {
                $('.wrapDebt').loading({display: true});
                $.ajax({
                    type: "post",
                    dataType: 'html',
                    url: urlLoadGrid,
                    data: params,
                    success: function (data) {
                        $('.wrapDebt .box-body-grid').html(data);
                        $('.wrapDebt').loading({display: false});
                    },
                    error: function (error) {
                    }
                });
            }
        });

        $('.wrapDebt').on('click', '.btn-print', function (e) {
            var params = $('#DebtForm').serialize();
            var url = urlDebtPaymentDueDate+'?'+params+'&print=1';
            loadiFrame(url);
            $("#printIframe").load(
                    function() {
                        window.frames['myname'].focus();
                        window.frames['myname'].print();
                    }
            );
//            var _window = window.open(url);
//            _window.window.print();
        });
        function loadiFrame(src)
        {
            $("#iframeplaceholder").html("<iframe id='printIframe' style='display:none;' name='myname' src='" + src + "' />");
        }
    });
</script>
@endpush