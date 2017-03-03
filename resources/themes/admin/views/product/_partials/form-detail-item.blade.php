<tr id="detail-row{{$key}}" data-product-detail="{{$detail->id}}">
    <td class="text-right">
        <input type="hidden" name="product_detail[{{$key}}][id]" value="{{$detail->id}}">
        <input type="text" name="product_detail[{{$key}}][size]" value="{{$detail->size}}" placeholder="Size" class="form-control"/>
    </td>
    <td class="text-right">
        {!! Form::select('product_detail['.$key.'][supplier_id]', $suppliers, $detail->supplier_id, ['class' => 'form-control']) !!}
    </td>
    <td class="text-right">
        <input type="text" name="product_detail[{{$key}}][price_in]" value="{{intval($detail->price_in)}}" placeholder="Price In" class="form-control"/>
    </td>
    <td class="text-right">
        <input type="text" name="product_detail[{{$key}}][price]" value="{{intval($detail->price)}}" placeholder="Price" class="form-control"/>
    </td>
    <td class="text-left" style="width: 20%;">
        <input type="radio" name="product_detail[{{$key}}][new_status]" value="1" {{($detail->new_status==1) ? 'checked="checked"' : ''}}/> New
        <input type="radio" name="product_detail[{{$key}}][new_status]" value="0" {{($detail->new_status==0) ? 'checked="checked"' : ''}}/> Used
    </td>
    <td class="text-right">
        1
    </td>
    <td class="text-left">
        <button type="button" onclick="removeProductDetail({{$key}});" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>

    </td>
</tr>
