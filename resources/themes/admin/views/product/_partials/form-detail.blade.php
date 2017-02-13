<?php
$suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
?>
<table id="size" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <td class="text-left">Size</td>
        <td class="text-left">Supplier</td>
        <td class="text-right">Price In</td>
        <td class="text-right">Price</td>
        <td class="text-left">New Status</td>
        <td style="width: 10%;"></td>
    </tr>
    </thead>
    <tbody>
    @if (!empty($details))
        @foreach($details as $key=>$detail)
            @php
            @endphp
            <tr id="size-row{{$key}}">
                <td class="text-right">
                    <input type="hidden" name="product_detail[{{$key}}][id]" value="{{$detail->id}}">
                    <input type="text" name="product_detail[{{$key}}][size]" value="{{$detail->size}}" placeholder="Size" class="form-control">
                </td>
                <td class="text-right">
                    {!! Form::select('product_detail['.$key.'][supplier_id]', $suppliers, $detail->supplier_id, ['class' => 'form-control']) !!}
                </td>
                <td class="text-right">
                    <input type="text" name="product_detail[{{$key}}][price_in]" value="{{$detail->price_in}}" placeholder="Price In" class="form-control">
                </td>
                <td class="text-right">
                    <input type="text" name="product_detail[{{$key}}][price]" value="{{$detail->price}}" placeholder="Price" class="form-control">
                </td>
                <td class="text-left" style="width: 20%;">
                    <input type="text" name="product_detail[{{$key}}][new_status]" value="{{$detail->new_status*100}}" placeholder="New Status" class="form-control">
                </td>
                <td class="text-left"><button type="button" onclick="removeSize({{$key}});" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5"></td>
        <td class="text-left"><button type="button" onclick="addSize();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Size"><i class="fa fa-plus-circle"></i></button></td>
    </tr>
    </tfoot>
</table>

@push('scripts')
<script type="text/javascript">
    var size_row = 1;
    function addSize() {
        var dropdownSipplier = '{!! Form::select('', $suppliers, null, ['class' => 'form-control']) !!}';
        html  = '<tr id="size-row' + size_row + '">';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + size_row + '][size]" value="" placeholder="Size" class="form-control" /></td>';
        html += '  <td class="text-right"><select class="form-control" name="product_detail[' + size_row + '][supplier_id]">'+$(dropdownSipplier).html()+'</select></td>';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + size_row + '][price_in]" value="" placeholder="Price In" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + size_row + '][price]" value="" placeholder="Price" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + size_row + '][new_status]" value="" placeholder="New Status" class="form-control" /></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#size-row' + size_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#size tbody').append(html);
        $('.date').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy"
        });
        size_row++;
    }

    function removeSize(key) {
        if(key) {
            $('#size-row' + key).remove();
            $.ajax({
                type: "POST",
                url: '{{ route('admin.product.deleteReference', ['_token' => csrf_token()]) }}',
                data: {type: '{{\App\Models\Backend\ShopProduct::TYPE_SIZE}}', id: key},
                success: function (data) {
                }
            });
        }
    }
</script>
@endpush