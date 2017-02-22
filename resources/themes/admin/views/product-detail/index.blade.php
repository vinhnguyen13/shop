@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Product', 'h1_href'=>route('admin.product-detail.index'), 'h1_small'=>'Product Detail Management']])
@endsection

@section('grid')
    <div class="grid-action">
    </div>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Product Detail Management</h3>
        </div>
        {!! $grid->table() !!}
    </div>

    <div class="modal fade" id="modal-qrcode" data-backdrop="static">
        <div class="modal-dialog" style="width: 350px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-book"></i> QR Code </h4>
                </div>
                <div class="modal-body">
                    <p class="SKU">SKU: <span> </span></p>
                    <p class="productUrl">Product Url: <span> </span></p>
                    <img class="imgQrCode" src="/">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button id="btn-delete" type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var url = "{{route('admin.product-detail.qrcode')}}";
        $('.box').on('click', '#view-qrcode', function (e) {
            var dataImgSrc = $(this).attr('data-img-src');
            var dataSKU = $(this).attr('data-sku');
            var dataProductUrl = $(this).attr('data-product-url');
            $('#modal-qrcode').find('.SKU span').html(dataSKU);
            $('#modal-qrcode').find('.productUrl span').html(dataProductUrl);
            $('#modal-qrcode').find('.imgQrCode').attr('src', dataImgSrc);
            $('#modal-qrcode').modal('show');
        });
    });
</script>
@endpush