@if (!empty($details))
    <table>
        <thead>
        <tr>
            <td class="id__result"><p>ID</p></td>
            <td class="name__result"><p>Name</p></td>
            <td class="size__result"><p><a href="">Size<span class="icon-uniF140"></span></a></p></td>
            <td class="qty__result"><p>Qty</p></td>
            <td class="condition__result"><p><a href="">Condition<span class="icon-uniF140"></span></a></p></td>
            <td class="price__result"><p><a href="">Price<span class="icon-uniF140"></span></a></p></td>
            <td class="addcart__result"><p>Add cart</p></td>
        </tr>
        </thead>
        @foreach($details as $indx=>$detail)
            @php
            $product = $detail->product;
            $price = $product->getPriceDefault();
            $url = $product->url();
            $size = $detail->getSize();
            $qty = $product->countDetailsBySize($size);
            $lblStatus = !empty($detail) ? $detail->getTextNewStatus() : '';

            $key = $product->id.'-'.$size;
            $qtyChose = 0;
            if(!empty($cart[$key])){
                $qtyChose = $cart[$key]['quantity'];
            }
            @endphp
            <tr class="checkout__inforpro-detail" data-product="{{encrypt($product->id)}}" data-size="{{$size}}" data-qty="{{$qty}}">
                <td><p>{{$indx+1}}</p></td>
                <td>
                    <p class="text-uper">
                        <a href="{{$url}}" target="_blank">{{$product->name}}</a>
                    </p>
                    <p class="help-block small">{{$detail->sku}}</p>
                </td>
                <td><p>{{$size}}</p></td>
                <td><p>{{$qty - $qtyChose}}</p></td>
                <td><p class="text-uper">{{$lblStatus}}</p></td>
                <td><p>đ {{number_format($price, 0)}}</p></td>
                <td>
                    <div class="up__down--qty">
                        <span class="qty__down"><span class="icon-circle-minus{{ $qty == 0 ? ' hide' : '' }}"></span></span>
                        <span class="qty__val">{{$qtyChose}}</span>
                        <span class="qty__up"><span class="icon-circle-plus {{ $qty == 0 ? ' hide' : '' }}"></span></span>
                        <input type="hidden" value="{{$qtyChose}}">
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    @if($details->total() > $details->perPage())
        <div class="clearfix">
            <div class="pagi__filter">
                <a href="{{$details->previousPageUrl()}}" class="btn-more"><span class="icon-navigate_before"></span></a>
                <input type="text" value="{{$details->currentPage()}}" />
                <a href="{{$details->nextPageUrl()}}" class="btn-more"><span class="icon-navigate_next"></span></a>
            </div>
        </div>
    @endif
@else
    <div class="alert alert-info fade in alert-dismissable">
        <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
        Không có sản phẩm bạn muốn tìm kiếm
    </div>
@endif

