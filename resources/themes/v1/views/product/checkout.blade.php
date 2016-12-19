@extends('layouts.app')

@section('content')
    <div class="container detail">
        <div class="row">
            <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <strong>Glab.VN</strong>
                            <br>
                            135/58 Trần Hưng Đạo, Quận 1,
                            <br>
                            Ho Chi Minh City, Vietnam
                            <br>
                            <abbr title="Phone">M:</abbr> 094 537 88 09
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <em>Date: {{date('D F, Y')}}</em>
                        </p>
                    </div>
                </div>

                <div class="row">
                    @if(!empty($cart))
                        <form method="post" action="" class="form-horizontal">
                            {{ csrf_field() }}
                            @include('product.partials.cart-products')
                            @include('product.partials.cart-shipping')
                            @include('product.partials.cart-billing')
                            @include('product.partials.cart-payment')
                            <div class="form-group">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">Pay Now</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>


            </div>
        </div>
    </div>

@endsection

@push('styles')

@endpush

@push('scripts')

@endpush