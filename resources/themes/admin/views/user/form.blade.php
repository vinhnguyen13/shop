@extends('layouts.app')
<?php
$isNewRecord = !empty($user->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'User', 'h1_href'=>route('admin.user.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> User</h3>
        </div>
        <div class="box-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    {{$errors->first()}}
                </div>
            @endif
            {{ Form::open(['route' => 'admin.user.store', 'files' => true]) }}
                {{ Form::hidden('id', $user->id) }}
                <div class="form-group">
                    {{ Form::label(null, 'Name') }}
                    {{ Form::text('name', $user->name,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Email') }}
                    {{ Form::text('email', $user->email,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Password') }}
                    <a class="changePss">Change pass</a>
{{--                    {{ Form::password('password', ['class' => 'form-control'])}}--}}

                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Avatar') }}
                    {{ Form::file('image', ['url' => route('admin.upload', ['type'=>\App\Services\UploadMedia::UPLOAD_AVATAR]), 'files' => !empty($image) ? $image : null, 'clientOptions' => ['singleFileUploads' => 1, 'limitMultiFileUploadSize' => 1, 'maxNumberOfFiles' => 1] ]) }}
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
    $(function() {
        var input = '<input class="form-control" name="password" type="password" value="">';
        $('.box-body').on('click', '.changePss', function (e) {
            $(this).parent().append(input);
            return false;
        });

    });
</script>
@endpush