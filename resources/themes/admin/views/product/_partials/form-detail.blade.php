<?php
$suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('name', 'id', '')->prepend('- Please Select -', 0);
$total = 0;
?>
<table id="productDetail" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <td class="text-left" style="width: 10%;">Size</td>
        <td class="text-left" style="width: 12%;">Supplier</td>
        <td class="text-left" style="width: 12%;">Consignment Fee</td>
        <td class="text-left" style="width: 5%;">Consignment Fee Type</td>
        <td class="text-left">Price In</td>
        <td class="text-left">Price</td>
        <td class="text-left" style="width: 5%;">New/Used</td>
        <td class="text-left">Condition</td>
        <td class="text-left" style="width: 5%;">Total</td>
        <td style="width: 5%;"></td>
    </tr>
    </thead>
    <tbody>
    @if (!empty($details))
        @php
        $total = $details->count();
        @endphp
        @foreach($details as $key=>$detail)
            @include('product._partials.form-detail-item')
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="9"></td>
        <td class="text-left"><button type="button" onclick="addMoreProductDetail();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Detail"><i class="fa fa-plus-circle"></i></button></td>
    </tr>
    </tfoot>
</table>
@if (!empty($details))
    <a class="btn btn-primary btn-xs" href="{{route('admin.product-detail.index', ['product_id'=>$model->id])}}">Product Detail Management</a>
@endif

@push('styles')
<link rel="stylesheet" href="/themes/admin/plugins/select2/select2.min.css">
<style>
    .select2-dropdown.select2-dropdown--below{
        /*width: 300px !important;*/
        display: inline-block;
        display: table;
    }
</style>
@endpush

@push('scripts')
<script src="/themes/admin/plugins/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#productDetail').trigger('product/import/supplier');
    });

    var detail_row = parseInt({{$total}});
    function addMoreProductDetail() {
        var dropdownSipplier = '{!! Form::select('', $suppliers, null, ['class' => 'form-control']) !!}';
        var dropdownSizes = '{!! Form::select('', $sizes, null, ['class' => 'form-control']) !!}';
        html  = '<tr id="detail-row' + detail_row + '">';
        html += '  <td class="text-left"><select class="form-control dd_sizes" name="product_detail[' + detail_row + '][size]">'+$(dropdownSizes).html()+'</select></td>';
        html += '  <td class="text-left"><select class="form-control dd_supplier" name="product_detail[' + detail_row + '][supplier_id]">'+$(dropdownSipplier).html()+'</select></td>';
        html += '  <td class="text-left"><input type="text" name="product_detail[' + detail_row + '][consignment_fee]" value="0" placeholder="Consignment Fee" class="form-control consignment_fee" /></td>';
        html += '  <td class="text-left"><input type="radio" name="product_detail[' + detail_row + '][consignment_fee_type]" value="1" class="consignment_fee_type" checked="checked"/>% ' +
                '<input type="radio" name="product_detail[' + detail_row + '][consignment_fee_type]" value="2" class="consignment_fee_type" />VND</td>';
        html += '  <td class="text-left"><input type="text" name="product_detail[' + detail_row + '][price_in]" value="" placeholder="Price In" class="form-control price_in" /></td>';
        html += '  <td class="text-left"><input type="text" name="product_detail[' + detail_row + '][price]" value="" placeholder="Price" class="form-control price" /></td>';
        html += '  <td class="text-left"><input type="radio" name="product_detail[' + detail_row + '][new_status]" value="1" checked="checked"/> New';
        html += '  <input type="radio" name="product_detail[' + detail_row + '][new_status]" value="0"/> Used </td>';
        html += '  <td class="text-left"><input type="text" name="product_detail[' + detail_row + '][condition]" value="" placeholder="Condition" class="form-control" /></td>';
        html += '  <td class="text-left"><input type="text" name="product_detail[' + detail_row + '][total]" value="1" placeholder="Total" class="form-control" /></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#detail-row' + detail_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#productDetail tbody').append(html);
        $('.date').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy"
        });
        detail_row++;
        $('#productDetail').trigger('product/import/supplier');
    }

    function removeProductDetail(key) {
        var pid = $('#detail-row' + key).attr('data-product-detail');
        $('#detail-row' + key).remove();
        $.ajax({
            type: "POST",
            url: '{{ route('admin.product.deleteReference', ['_token' => csrf_token()]) }}',
            data: {type: '{{\App\Models\Backend\ShopProduct::TYPE_DETAIL}}', id: pid},
            success: function (data) {
                reloadProductDetail();
            }
        });
    }

    function addMoreProductDetailWithSupplier(key) {
        var pid = $('#detail-row' + key).attr('data-product-detail');
        $.ajax({
            type: "POST",
            url: '{{ route('admin.product.addProductDetail', ['_token' => csrf_token()]) }}',
            data: {id: pid},
            success: function (data) {
                reloadProductDetail();
            }
        });
    }

    function reloadProductDetail() {
        $.ajax({
            type: "POST",
            url: '{{ route('admin.product.productDetailGroup', ['_token' => csrf_token()]) }}',
            data: {pid: '{{$model->id}}'},
            success: function (data) {
                $('#productDetail tbody').html(data.html);
            }
        });
    }

    $('#productDetail').on('click', '.viewSKU', function(){
        reloadProductDetail();
    });

    $('#productDetail').on('change', '.dd_supplier', function(){
        var parent = $(this).closest('tr');
        var val = $(this).val();
        $.ajax({
            type: "POST",
            url: '{{ route('admin.supplier.get')}}',
            data: {id: val},
            success: function (data) {
                parent.find('.consignment_fee').val(data.consignment_fee);
                parent.find('.consignment_fee_type[value="'+data.consignment_fee_type+'"]').prop('checked', true);
                $('#productDetail').trigger('product/import/priceRule', [parent]);
            }
        });
    });

    $('#productDetail').on('keypress change keyup', '.consignment_fee', function(){
        var parent = $(this).closest('tr');
        $('#productDetail').trigger('product/import/priceRule', [parent]);
    });

    $('#productDetail').bind('product/import/priceRule', function (event, parent) {
        var val = parent.find('.consignment_fee').val();
        if(val && val != 0){
            parent.find('.price_in').prop('disabled', true);
        }else{
            parent.find('.price_in').prop('disabled', false);
        }
    });

    $('#productDetail').bind('product/import/supplier', function (event) {
        $(".dd_supplier").select2({
            ajax: {
                url: "{{ route('admin.supplier.lists')}}",
                dataType: 'json',
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                delay: 250,
                type: 'POST',
                data: function (params) {
                    return {
                        input: params.term, // search term
                    };
                },
                processResults: function (data) {
                    var arr = []
                    $.each(data, function (index, value) {
                        arr.push({
                            id: index,
                            text: value
                        })
                    })
                    return {
                        results: arr
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 0,
        });
    });
</script>
@endpush