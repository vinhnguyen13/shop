@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Coupon Code', 'h1_href'=>route('admin.cpcode.index'), 'h1_small'=> 'Create random coupon code']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Create Random Coupon Code</h3>
        </div>
        <div class="box-body">
            {{ Form::open(['route' => 'admin.cpcode.store-random', 'files' => true]) }}

            <table class="table table-striped">
                <tr>
                    <th>Parameter</th>
                    <th>Type</th>
                    <th>Default</th>
                    <th>Custom value</th>
                </tr>
                <tr>
                    <th>Coupon Event</th>
                    <td>number</td>
                    <td></td>
                    <td>
                        {{ Form::select('cp_event_id',$events, $cpcode->cp_event_id, ['class' => 'form-control'])}}
                    </td>
                </tr>
                <tr>
                    <th>Coupon Limit</th>
                    <td>number</td>
                    <td></td>
                    <td>
                        {{ Form::text('limit', $cpcode->limit, ['class' => 'form-control'])}}
                    </td>
                </tr>
                <tr>
                    <th>Discount by </th>
                    <td>
                        <div id="amount_type">
                            <label><input type="radio" name="CouponCode[amount_type]" value="{{ \App\Models\Backend\CpCode::AMOUNT_TYPE_PERCENT }}" checked="checked"> Percent</label>
                            &nbsp;
                            <label><input type="radio" name="CouponCode[amount_type]" value="{{ \App\Models\Backend\CpCode::AMOUNT_TYPE_PRICE }}"> Amount</label>
                        </div>
                    </td>
                    <td></td>
                    <td>{{ Form::text('amount', $cpcode->amount, ['class' => 'form-control'])}}</td>
                </tr>
                <tr>
                    <th>Number of coupons</th>
                    <td>number</td>
                    <td>1</td>
                    <td><input class="form-control" type="number" name="no_of_coupons" value="1" min="1"/></td>
                </tr>
                <tr>
                    <th>Prefix</th>
                    <td>string</td>
                    <td></td>
                    <td><input class="form-control" type="text" name="prefix" value="" /></td>
                </tr>
                <tr>
                    <th>Suffix</th>
                    <td>string</td>
                    <td></td>
                    <td><input class="form-control" type="text" name="suffix" value="" /></td>
                </tr>
                <tr>
                    <th>Numbers</th>
                    <td>boolean</td>
                    <td>true</td>
                    <td>
                        <select class="form-control" name="numbers">
                            <option value="false">False</option>
                            <option selected value="true">True</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Letters</th>
                    <td>boolean</td>
                    <td>true</td>
                    <td>
                        <select class="form-control" name="letters">
                            <option value="false">False</option>
                            <option selected value="true">True</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Symbols</th>
                    <td>boolean</td>
                    <td>false</td>
                    <td>
                        <select class="form-control" name="symbols">
                            <option selected value="false">False</option>
                            <option value="true">True</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Random register (includes lower and uppercase)</th>
                    <td>boolean</td>
                    <td>false</td>
                    <td>
                        <select class="form-control" name="random_register">
                            <option selected value="false">False</option>
                            <option value="true">True</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Length</th>
                    <td>number</td>
                    <td>6</td>
                    <td><input class="form-control" type="number" name="length" value="6" min="1" /></td>
                </tr>
                <tr>
                    <th>Mask</th>
                    <td>string or boolean</td>
                    <td>false</td>
                    <td><input class="form-control" type="text" name="mask" value="XXXXXX" /></td>
                </tr>
            </table>
            <div class="form-group">
                {{ Form::submit('Create', array('class' => 'btn btn-primary btn-flat')) }}
            </div>
            {{ Form::close() }}
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/themes/admin/plugins/iCheck/all.css">
@endpush
@push('scripts')
    <script src="/themes/admin/plugins/iCheck/icheck.min.js"></script>
@endpush