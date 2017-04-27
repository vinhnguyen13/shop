@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Product', 'h1_href'=>route('admin.product.index'), 'h1_small'=>'Import']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Import</h3>
        </div>
        <div class="box-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            {{ Form::open(['route' => 'admin.product.store']) }}
                {{ Form::hidden('id', $model->id) }}
                <?php
                $suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('name', 'id', '')->prepend('- Please Select -', 0);
                $total = 0;
                ?>
                <table id="productDetail" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td class="text-left">Size</td>
                        <td class="text-left">Supplier</td>
                        <td class="text-left">Price In</td>
                        <td class="text-left">Price</td>
                        <td class="text-left" style="width: 12%;">New/Used</td>
                        <td class="text-left">Condition</td>
                        <td class="text-left">Consignment Fee</td>
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
                            <tr id="detail-row{{$key}}" data-product-detail="{{$detail->id}}">
                                <td class="text-right">
                                    <span class="form-control">{{$detail->size}}</span>

                                </td>
                                <td class="text-left">
                                    <span class="form-control">{{$detail->supplier->name}}</span>
                                </td>
                                <td class="text-left">
                                    <span class="form-control">{{intval($detail->price_in)}}</span>
                                </td>
                                <td class="text-left">
                                    <span class="form-control">{{intval($detail->price)}}</span>
                                </td>
                                <td class="text-left">
                                    <span class="form-control">{{($detail->new_status==1) ? 'New' : 'Used'}}</span>
                                </td>
                                <td class="text-left">
                                    <span class="form-control">{{$detail->condition}}</span>
                                </td>
                                <td class="text-left">
                                    <span class="form-control">{{$detail->consignment_fee}}</span>
                                </td>
                                <td class="text-right">
                                </td>
                                <td class="text-left">
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="8"></td>
                        <td class="text-left"><button type="button" onclick="addMoreProductDetail();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Detail"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                    </tfoot>
                </table>
                @if (!empty($details))
                    <div class="form-group">
                        <a class="btn btn-primary btn-xs" href="{{route('admin.product-detail.index', ['product_id'=>$model->id])}}">Product Detail Management</a>
                    </div>
                @endif
                <div class="form-group">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary btn-flat')) }}
                </div>
            {{ Form::close() }}
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

@push('styles')
@endpush
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
        html += '  <td class="text-left"><input type="radio" name="product_detail[' + detail_row + '][new_status]" value="1" checked="checked"/> New';
        html += '  <input type="radio" name="product_detail[' + detail_row + '][new_status]" value="0"/> Used </td>';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + detail_row + '][condition]" value="" placeholder="Condition" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="product_detail[' + detail_row + '][consignment_fee]" value="" placeholder="Consignment Fee" class="form-control" /></td>';
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