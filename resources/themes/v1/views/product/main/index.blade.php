@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            @include('layouts.partials.breadcrumb')
        </div>
        @include('product.partials.list-items')
    </div>
@endsection

@push('styles')

@endpush

@push('scripts')

@endpush