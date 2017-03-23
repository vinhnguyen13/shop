@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Order', 'h1_href'=>route('admin.order.index'), 'h1_small'=>'Revenue Management']])
@endsection

@section('grid')
    <div class="grid-action"><a href="{{ route('admin.order.create') }}" class="btn btn-success">Create</a></div>
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
                        {{Form::select('status', \App\Models\ShopOrderStatus::getStatus(), null, ['class'=>'form-control'])}}
                    </div>
                    <div class="form-group">
                        <label>Member Access</label>
                        <input type="text" class="form-control" placeholder="Email" name="email">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-payment-supplier-verified"><i class="fa fa-check"></i> Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script type="text/javascript">
    $(function() {
        $('.wrapOrder').on('click', '.btn-update-order', function (e) {
            $('#modal-update-order').modal('show');
            return false;
        });
    });
</script>
@endpush