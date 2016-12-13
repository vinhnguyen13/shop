@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            @if(!empty($cart))
                <ul>
                @foreach($cart as $item)
                    @php
                    $product = App\Models\Frontend\ShopProduct::find($item['product_id']);
                    @endphp
                    <li>
                    {{$product->name}} - {{$item['size']}} - {{$item['quantity']}}
                    </li>
                @endforeach
                </ul>
            @endif

        </div>
    </div>
@endsection

@push('styles')

@endpush

@push('scripts')

@endpush