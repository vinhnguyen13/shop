@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Coupon Code', 'h1_href'=>route('admin.cpcode.index'), 'h1_small'=> 'Donate']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ "Donate" }}</h3>
        </div>
        <div class="box-body">
            {{ Form::open(['route' => 'admin.cpcode.donate', 'id' => 'frmDonate']) }}
            <div class="form-group">
                {{ Form::label(null, 'User') }}
                {{ Form::textarea('users', null,['class' => 'form-control'])}}
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Coupon Code') }}
                {{ Form::select('code_id', $codes,['class' => 'form-control'])}}
            </div>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info"></i> Alert!</h4>
                <p></p>
            </div>
            <div class="form-group">
                {{ Form::submit('Save', array('class' => 'btn btn-primary btn-flat')) }}
            </div>
            {{ Form::close() }}
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
		$('.alert-info').hide();
		$(document).on('click', '.btn-primary', function (e) {
		    var _id = $(this).attr('nid');
		    $.ajax({
		        type: 'POST',
		        url: '{{ route('admin.cpcode.donate') }}',
		        data: $('#frmDonate').serialize(),
		        success: function (data) {
		            if(data) {
		                var html = '';
		                $.each(data, function(username, msg) {
		                    html+= '<b>' + username + '</b>: ' + msg + '<br/>';
		                });
		                $('.alert-info p').html(html);
		                $('.alert-info').show();
		            }
		        }
		    });
		    return false;
		});
	</script>
@endpush