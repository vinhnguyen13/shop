<?php
$suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
$total = 0;
?>
<table id="size" class="table table-striped table-bordered table-hover">
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
            <tr id="detail-row{{$key}}" data-product-detail="{{$detail->id}}">
                <td class="text-right">
                    <input type="hidden" name="product_detail[{{$key}}][id]" value="{{$detail->id}}">
                    <input type="text" name="product_detail[{{$key}}][size]" value="{{$detail->size}}" placeholder="Size" class="form-control"/>
                </td>
                <td class="text-right">
                    {!! Form::select('product_detail['.$key.'][supplier_id]', $suppliers, $detail->supplier_id, ['class' => 'form-control']) !!}
                </td>
                <td class="text-right">
                    <input type="text" name="product_detail[{{$key}}][price_in]" value="{{$detail->price_in}}" placeholder="Price In" class="form-control"/>
                </td>
                <td class="text-right">
                    <input type="text" name="product_detail[{{$key}}][price]" value="{{$detail->price}}" placeholder="Price" class="form-control"/>
                </td>
                <td class="text-left" style="width: 20%;">
                    <input type="radio" name="product_detail[{{$key}}][new_status]" value="1" {{($detail->new_status==1) ? 'checked="checked"' : ''}}/> New
                    <input type="radio" name="product_detail[{{$key}}][new_status]" value="0" {{($detail->new_status==0) ? 'checked="checked"' : ''}}/> Used
                </td>
                <td class="text-right">
                    {{$detail->total}}
                </td>
                <td class="text-left">
                    <button type="button" onclick="removeProductDetail({{$key}});" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>
                    <button type="button" onclick="addMoreProductDetailWithSupplier({{$key}});" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Detail"><i class="fa fa-plus-circle"></i></button>
                </td>
            </tr>
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
        html += '  <td class="text-left"><button type="button" onclick="$(\'#detail-row' + detail_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#size tbody').append(html);
        $('.date').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy"
        });
        detail_row++;
    }

    function removeProductDetail(key) {
        if(key) {
            $('#detail-row' + key).remove();
            var pid = $('#detail-row' + key).attr('data-product-detail');
            $.ajax({
                type: "POST",
                url: '{{ route('admin.product.deleteReference', ['_token' => csrf_token()]) }}',
                data: {type: '{{\App\Models\Backend\ShopProduct::TYPE_DETAIL}}', id: pid},
                success: function (data) {
                }
            });
        }
    }

    function addMoreProductDetailWithSupplier(key) {
        if(key) {
            $('#detail-row' + key).remove();
            var pid = $('#detail-row' + key).attr('data-product-detail');
            $.ajax({
                type: "POST",
                url: '{{ route('admin.product.addProductDetail', ['_token' => csrf_token()]) }}',
                data: {id: key},
                success: function (data) {
                }
            });
        }
    }
</script>
@endpush