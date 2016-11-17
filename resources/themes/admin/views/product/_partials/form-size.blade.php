<table id="size" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <td class="text-left">Size</td>
        <td class="text-right">Price</td>
        <td class="text-left">New Status</td>
        <td style="width: 10%;"></td>
    </tr>
    </thead>
    <tbody>
    @if (!empty($sizes))
        @foreach($sizes as $size)
            @php
            $key = $size->id;
            @endphp
            <tr id="size-row{{$key}}">
                <td class="text-right">
                    <input type="text" name="product_size[{{$key}}][size]" value="{{$size->size}}" placeholder="Size" class="form-control">
                </td>
                <td class="text-right">
                    <input type="text" name="product_size[{{$key}}][price]" value="{{$size->price}}" placeholder="Price" class="form-control">
                </td>
                <td class="text-left" style="width: 20%;">
                    <input type="text" name="product_size[{{$key}}][new_status]" value="{{$size->new_status*100}}" placeholder="New Status" class="form-control">
                </td>
                <td class="text-left"><button type="button" onclick="removeSize({{$key}});" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td class="text-left"><button type="button" onclick="addSize();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Size"><i class="fa fa-plus-circle"></i></button></td>
    </tr>
    </tfoot>
</table>

@push('scripts')
<script type="text/javascript">
    var size_row = 1;
    function addSize() {
        html  = '<tr id="size-row' + size_row + '">';
        html += '  <td class="text-right"><input type="text" name="product_size[' + size_row + '][size]" value="" placeholder="Size" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_size[' + size_row + '][price]" value="" placeholder="Price" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_size[' + size_row + '][new_status]" value="" placeholder="New Status" class="form-control" /></td>';
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