@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            @if(!empty($cart))
                @foreach($cart as $item)
                    @php
                    $product = App\Models\Frontend\ShopProduct::find($item['product_id']);
                    @endphp
                    {{dump($product->getAttributes())}}
                @endforeach
            @endif

        </div>
    </div>
@endsection

@push('styles')

@endpush

@push('scripts')

@endpush