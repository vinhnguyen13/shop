@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <ul class="breakcum">
                <li><a href="">home</a></li>
                <li><span>/</span></li>
                <li class="active"><a href="">foot wear</a></li>
            </ul>
        </div>
        <div class="row products">
            @include('product.partials.item')
        </div>
        <div class="text-center">
            <a href="" class="btn-see-more text-uper">see more</a>
        </div>
    </div>
@endsection

@push('styles')

@endpush

@push('scripts')
    <script type="text/javascript" src="/themes/v1/js/jquery.lazyload.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("img.lazy").lazyload({
                effect : "fadeIn"
            });
        });
    </script>
@endpush