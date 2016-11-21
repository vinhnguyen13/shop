@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            @include('layouts.partials.breadcrumb')
        </div>
        @include('product.partials.item')
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