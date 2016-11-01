<div class="form-group">
    {{ Form::label(null, 'Bio') }}
    <div>{{ $profile->bio }}</div>
</div>

<div class="form-group">
    {{ Form::label(null, 'Mobile') }}
    <div>{{ $profile->mobile }}</div>
</div>

<div class="form-group">
    {{ Form::label(null, 'Avatar') }}
    <div><img src="{{Storage::url(\App\Models\Profile::uploadAvatarFolder . "/thumb_" . $profile->avatar)}}"/></div>
</div>
