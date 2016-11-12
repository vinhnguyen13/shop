<table id="special" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <td class="text-left">Customer Group</td>
        <td class="text-right">Priority</td>
        <td class="text-right">Price</td>
        <td class="text-left">Date Start</td>
        <td class="text-left">Date End</td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    @if ($specials)
        @foreach($specials as $special)
            @php
            $key = $special->id;
            @endphp
            <tr id="special-row{{$key}}">
                <td class="text-left">
                    <select name="product_special[{{$key}}][customer_group_id]" class="form-control">
                        <option value="1" selected="selected">Default</option>
                    </select>
                </td>
                <td class="text-right">
                    <input type="text" name="product_special[{{$key}}][priority]" value="{{$special->priority}}" placeholder="Priority" class="form-control">
                </td>
                <td class="text-right">
                    <input type="text" name="product_special[{{$key}}][price]" value="{{$special->price}}" placeholder="Price" class="form-control">
                </td>
                <td class="text-left" style="width: 20%;">
                    <div class="input-group date">
                        <input type="text" name="product_special[{{$key}}][date_start]" value="{{Carbon\Carbon::parse($special->date_start)->format('d/m/Y')}}" placeholder="Date Start" data-date-format="YYYY-MM-DD" class="form-control">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </td>
                <td class="text-left" style="width: 20%;">
                    <div class="input-group date">
                        <input type="text" name="product_special[{{$key}}][date_end]" value="{{Carbon\Carbon::parse($special->date_end)->format('d/m/Y')}}" placeholder="Date End" data-date-format="YYYY-MM-DD" class="form-control">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </td>
                <td class="text-left"><button type="button" onclick="removeSpecial({{$key}});" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5"></td>
        <td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Special"><i class="fa fa-plus-circle"></i></button></td>
    </tr>
    </tfoot>
</table>

@push('scripts')
<script type="text/javascript">
    var special_row = 1;
    function addSpecial() {
        html  = '<tr id="special-row' + special_row + '">';
        html += '  <td class="text-left"><select name="product_special[' + special_row + '][customer_group_id]" class="form-control">';
        html += '      <option value="1">Default</option>';
        html += '  </select></td>';
        html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][priority]" value="" placeholder="Priority" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][price]" value="" placeholder="Price" class="form-control" /></td>';
        html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_start]" value="" placeholder="Date Start" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
        html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_end]" value="" placeholder="Date End" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#special tbody').append(html);
        $('.date').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        special_row++;
    }

    function removeSpecial(key) {
        if(key) {
            $('#special-row' + key).remove();
            $.ajax({
                type: "POST",
                url: '{{ route('admin.product.deleteReference', ['_token' => csrf_token()]) }}',
                data: {type: 'special', id: key},
                success: function (data) {
                    alert(data);
                }
            });
        }
    }
</script>
@endpush