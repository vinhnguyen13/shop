<tr id="detail-row{{$key}}" data-product-detail="{{$detail->id}}">
    <td class="text-left">
        <input type="hidden" name="product_detail[{{$key}}][id]" value="{{$detail->id}}">
        {!! Form::select('product_detail['.$key.'][size]', $sizes, $detail->getSize(), ['class' => 'form-control']) !!}
    </td>
    <td class="text-left">
        {!! Form::select('product_detail['.$key.'][supplier_id]', $suppliers, $detail->supplier_id, ['class' => 'form-control dd_supplier']) !!}
    </td>
    <td class="text-left">
        <input type="text" name="product_detail[{{$key}}][consignment_fee]" value="{{intval($detail->consignment_fee)}}" placeholder="Consignment Fee" class="form-control consignment_fee"/>
    </td>
    <td class="text-left">
        <input type="radio" name="product_detail[{{$key}}][consignment_fee_type]" class="consignment_fee_type" value="1" {{($detail->consignment_fee_type==1) ? 'checked="checked"' : ''}}/> %
        <input type="radio" name="product_detail[{{$key}}][consignment_fee_type]" class="consignment_fee_type" value="2" {{($detail->consignment_fee_type==2) ? 'checked="checked"' : ''}}/> VND
    </td>
    <td class="text-left">
        <input type="text" name="product_detail[{{$key}}][price_in]" value="{{intval($detail->price_in)}}" placeholder="Price In" class="form-control"/>
    </td>
    <td class="text-left">
        <input type="text" name="product_detail[{{$key}}][price]" value="{{intval($detail->price)}}" placeholder="Price" class="form-control"/>
    </td>
    <td class="text-left">
        <input type="radio" name="product_detail[{{$key}}][new_status]" value="1" {{($detail->new_status==1) ? 'checked="checked"' : ''}}/> New
        <input type="radio" name="product_detail[{{$key}}][new_status]" value="0" {{($detail->new_status==0) ? 'checked="checked"' : ''}}/> Used
    </td>
    <td class="text-left">
        <input type="text" name="product_detail[{{$key}}][condition]" value="{{$detail->condition}}" placeholder="Condition" class="form-control"/>
    </td>
    <td class="text-left">
    </td>
    <td class="text-left">
        <button type="button" onclick="removeProductDetail({{$key}});" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>

    </td>
</tr>
