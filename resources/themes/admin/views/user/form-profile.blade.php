<div class="form-group">
    {{ Form::label(null, 'Name') }}
    {{ Form::text('name', $profile->name,['class' => 'form-control'])}}
</div>

<div class="form-group">
    {{ Form::label(null, 'Bio') }}
    {{ Form::text('bio', $profile->bio,['class' => 'form-control'])}}
</div>

<div class="form-group">
    {{ Form::label(null, 'Mobile') }}
    {{ Form::text('mobile', $profile->mobile,['class' => 'form-control'])}}
</div>

<div class="form-group">
    {{ Form::label(null, 'Avatar') }}
    {{ Form::file('avatar', ['url' => route('admin.user.upload'), 'files' => !empty($avatar) ? $avatar : null, 'clientOptions' => ['singleFileUploads' => 1, 'limitMultiFileUploadSize' => 1, 'maxNumberOfFiles' => 1] ]) }}
</div>
