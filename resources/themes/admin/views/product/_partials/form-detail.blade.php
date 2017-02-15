<?php
$suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
$total = 0;
?>
@if (!empty($details))
    <a href="{{route('admin.product-detail.index')}}" target="_blank">Manage Product Detail</a>
@endif
<table id="productDetail" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <td class="text-left">Size</td>
        <td class="text-left">Supplier</td>
        <td class="text-right">Price In</td>
        <td class="text-right">Price</td>
        <td class="text-left">New/Used</td>
        <td class="text-left">Total</td>
        <td style="width: 10%;"></td>
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
        <td colspan="6"></td>
        <td class="text-left"><button type="button" onclick="addMoreProductDetail();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Detail"><i class="fa fa-plus-circle"></i></button></td>
    </tr>
    </tfoot>
</table>

@push('scripts')
<script type="text/javascript">
    var detail_row = parseInt({{$total}});
    function addMoreProductDetail() {
        var dropdownSipplier = '{!! Form::select('', $suppliers, null, ['class' => 'form-control']) !!}';
        html  = '<tr id="detail-row' + detail_row + '">';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + detail_row + '][size]" value="" placeholder="Size" class="form-control" /></td>';
        html += '  <td class="text-right"><select class="form-control" name="product_detail[' + detail_row + '][supplier_id]">'+$(dropdownSipplier).html()+'</select></td>';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + detail_row + '][price_in]" value="" placeholder="Price In" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + detail_row + '][price]" value="" placeholder="Price" class="form-control" /></td>';
        html += '  <td class="text-left" style="width: 20%;"><input type="radio" name="product_detail[' + detail_row + '][new_status]" value="1" checked="checked"/> New';
        html += '  <input type="radio" name="product_detail[' + detail_row + '][new_status]" value="0"/> Used </td>';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + detail_row + '][total]" value="1" placeholder="Total" class="form-control" /></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#detail-row' + detail_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#productDetail tbody').append(html);
        $('.date').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy"
        });
        detail_row++;
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
</script>
@endpush