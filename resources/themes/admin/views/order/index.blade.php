@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Order', 'h1_href'=>route('admin.order.index'), 'h1_small'=>'Order Management']])
@endsection

@section('grid')
    <div class="grid-action"><a href="{{ route('admin.order.create') }}" class="btn btn-success">Create</a></div>
    <div style="clear: both; margin-left: 0px;" class="span3 tlo2 my_height_box"></div>
    <div class="container">
        <div class="row-fluid">
            {{--<form id="DebtForm" method="get">--}}
                <div class="box-header ui-sortable-handle">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Filter</h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-4">
                        <input type="text" class="form-control date" placeholder="Invoice" name="invoice_code" value="{{input('invoice_code')}}">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control date" placeholder="Phone" name="phone" value="{{input('phone')}}">
                    </div>
                    <div class="col-xs-4">
                        {{--<input type="text" class="form-control date" placeholder="Status" name="status" value="{{input('status')}}">--}}
                        {!! Form::select('status', array_merge(['0'=>'Choose Status'], \App\Models\ShopOrderStatus::getStatus()), input('status'), ['class' => 'form-control status-list']) !!}
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-filter">Find</button>
                    </div>
                </div>
            {{--</form>--}}
        </div>
    </div>
@endsection

@section('content')
    <div class="box wrapOrder">
        <div class="box-header">
            <h3 class="box-title">Order Management</h3>
        </div>
        {!! $grid->table() !!}
    </div>

    <div class="modal fade" id="modal-update-order" data-backdrop="static">
        <div class="modal-dialog" style="width: 350px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-book"></i> Update Status </h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <p>This is an important part, please verify your account</p>
                    </div>
                    <div class="alert alert-danger alert-dismissable hide">
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <p></p>
                    </div>
                    <div class="form-group">
                        <label>Order Status</label>
                        <div class="opt-status"></div>
                    </div>
                    <div class="form-group">
                        <label>Member Access</label>
                        <input type="text" class="form-control" placeholder="Email" name="email">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-update-order-status"><i class="fa fa-check"></i> Update</button>
                </div>
            </div>
        </div>
    </div>
    <div id="iframeplaceholder"></div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script type="text/javascript">
    $(function() {
        var urlOrderUpdateStatus = '{{route('admin.order.updateStatus')}}';
        var urlOrderFetStatusForUpdate = '{{route('admin.order.getStatusForUpdate')}}';
        $('.wrapOrder').on('click', '.btn-update-order', function (e) {
            var orderID = $(this).attr('data-order');
            var orderStatus = $(this).attr('data-order-status');
            if (orderStatus) {
                $('#modal-update-order').loading({display: true});
                $.ajax({
                    type: "post",
                    dataType: 'html',
                    url: urlOrderFetStatusForUpdate,
                    data: {status: orderStatus},
                    success: function (data) {
                        $('#modal-update-order').loading({display: false});
                        $('#modal-update-order').find('.opt-status').html(data);
                        $('#modal-update-order').find('.btn-update-order-status').attr('data-order', orderID);
                        $('#modal-update-order').modal('show');
                    },
                    error: function (error) {
                    }
                });
            }
            return false;
        });

        $('#modal-update-order').on('click', '.btn-update-order-status', function (e) {
            var orderID = $(this).attr('data-order');
            var status = $('select[name="status"]').val();
            var email = $('input[name="email"]').val();
            var password = $('input[name="password"]').val();
            console.log(orderID, status);
            if (orderID) {
                $('#modal-update-order').loading({display: true});
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    url: urlOrderUpdateStatus,
                    data: {orderID: orderID, status: status, email: email, password: password},
                    success: function (data) {
                        $('#modal-update-order').loading({display: false});
                        location.reload();
                    },
                    error: function (error) {
                    }
                });
            }

        });

        $('.wrapOrder').on('click', '.btn-print', function (e) {
            var url = $(this).attr('data-url');
            loadiFrame(url);
            $("#printIframe").load(
                    function () {
                        window.frames['myname'].focus();
                        window.frames['myname'].print();
                    }
            );
        });
        function loadiFrame(src) {
            $("#iframeplaceholder").html("<iframe id='printIframe' style='display:none;' name='myname' src='" + src + "' />");
        }
    });
</script>
@endpush