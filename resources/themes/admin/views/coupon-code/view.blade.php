@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Coupon Code', 'h1_href'=>route('admin.cpcode.index'), 'h1_small'=>'Coupon Code detail']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">View Coupon Code Detail</h3>
            <a href="{{ route('admin.cpcode.edit', ['id' => $cpcode->id]) }}" class="btn btn-sm btn-info pull-right">Edit</a>
        </div>
        <div class="box-body">

            <div class="form-group">
                {{ Form::label('event', 'Event') }}
                <div>{{ $cpcode->event }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('code', 'Code') }}
                <div>{{ $cpcode->code }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('amount', 'Amount') }}
                <div>{{ $cpcode->amount }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('amount_type', 'Amount Type') }}
                <div>{{ \App\Models\Backend\CpCode::getAmountTypes($cpcode->amount_type) }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('status', 'Status') }}
                <div>{{ \App\Models\Backend\CmsShow::statusLabel($cpcode->status) }}</div>
            </div>

        </div>
    </div>
@endsection

