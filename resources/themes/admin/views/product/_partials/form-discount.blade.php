<table id="discount" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <td class="text-left">Customer Group</td>
        <td class="text-right">Quantity</td>
        <td class="text-right">Priority</td>
        <td class="text-right">Price</td>
        <td class="text-left">Date Start</td>
        <td class="text-left">Date End</td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    @if (!empty($discounts)))
        @foreach($discounts as $discount)
            @php
            $key = $discount->id;
            @endphp
            <tr id="discount-row{{$key}}">
                <td class="text-left">
                    <select name="product_discount[{{$key}}][customer_group_id]" class="form-control">
                        <option value="1" selected="selected">Default</option>
                    </select>
                </td>
                <td class="text-right"><input type="text" name="product_discount[{{$key}}][quantity]" value="{{$discount->quantity}}" placeholder="Quantity" class="form-control"></td>
                <td class="text-right"><input type="text" name="product_discount[{{$key}}][priority]" value="{{$discount->priority}}" placeholder="Priority" class="form-control"></td>
                <td class="text-right"><input type="text" name="product_discount[{{$key}}][price]" value="{{$discount->price}}" placeholder="Price" class="form-control"></td>
                <td class="text-left" style="width: 20%;">
                    <div class="input-group date">
                        <input type="text" name="product_discount[{{$key}}][date_start]" value="{{Carbon\Carbon::parse($discount->date_start)->format('d/m/Y')}}" placeholder="Date Start" data-date-format="YYYY-MM-DD" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </td>
                <td class="text-left" style="width: 20%;">
                    <div class="input-group date">
                        <input type="text" name="product_discount[{{$key}}][date_end]" value="{{Carbon\Carbon::parse($discount->date_end)->format('d/m/Y')}}" placeholder="Date End" data-date-format="YYYY-MM-DD" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </td>
                <td class="text-left">
                    <button type="button" onclick="removeDiscount({{$key}});" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6"></td>
        <td class="text-left">
            <button type="button" onclick="addDiscount();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Discount"><i class="fa fa-plus-circle"></i></button>
        </td>
    </tr>
    </tfoot>
</table>

@push('scripts')
<script type="text/javascript">
    var discount_row = 3;
    function addDiscount() {
        html  = '<tr id="discount-row' + discount_row + '">';
        html += '  <td class="text-left"><select name="product_discount[' + discount_row + '][customer_group_id]" class="form-control">';
        html += '    <option value="1">Default</option>';
        html += '  </select></td>';
        html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" placeholder="Quantity" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" placeholder="Priority" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][price]" value="" placeholder="Price" class="form-control" /></td>';
        html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" placeholder="Date Start" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
        html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" placeholder="Date End" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#discount-row' + discount_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#discount tbody').append(html);
        $('.date').datepicker({
            pickTime: false
         });
        discount_row++;
    }

    function removeDiscount(key) {
        if(key) {
            $('#discount-row' + key).remove();
            $.ajax({
                type: "POST",
                url: '{{ route('admin.product.deleteReference', ['_token' => csrf_token()]) }}',
                data: {type: '{{\App\Models\Backend\ShopProduct::TYPE_DISCOUNT}}', id: key},
                success: function (data) {
                }
            });
        }
    }
</script>
@endpush