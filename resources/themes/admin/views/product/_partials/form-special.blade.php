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
    <tr id="special-row0">
        <td class="text-left">
            <select name="product_special[0][customer_group_id]" class="form-control">
                <option value="1" selected="selected">Default</option>
            </select>
        </td>
        <td class="text-right">
            <input type="text" name="product_special[0][priority]" value="1" placeholder="Priority" class="form-control">
        </td>
        <td class="text-right">
            <input type="text" name="product_special[0][price]" value="90.0000" placeholder="Price" class="form-control">
        </td>
        <td class="text-left" style="width: 20%;">
            <div class="input-group date">
                <input type="text" name="product_special[0][date_start]" value="" placeholder="Date Start" data-date-format="YYYY-MM-DD" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span>
            </div>
        </td>
        <td class="text-left" style="width: 20%;">
            <div class="input-group date">
                <input type="text" name="product_special[0][date_end]" value="" placeholder="Date End" data-date-format="YYYY-MM-DD" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span>
            </div>
        </td>
        <td class="text-left"><button type="button" onclick="$('#special-row0').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5"></td>
        <td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Special"><i class="fa fa-plus-circle"></i></button></td>
    </tr>
    </tfoot>
</table>