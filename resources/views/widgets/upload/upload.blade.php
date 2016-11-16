<div class="{{ $fileWrap }}" id="{{ $fileWrapId }}">
	<ul class="files"></ul>
	<span class="btn btn-success fileinput-button">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Add files...</span>
		<input class="{{ $fileButton }}" id="{{ $fileButtonId }}" type="file" name="{{ $name }}" data-url="{{ $options['url'] }}"@if ($multiple) multiple @endif/>
	</span>
</div>

@push('scripts')
	@if ($fileCount === 1)
	<script src="{!! asset('js/jquery-file-upload/vendor/jquery.ui.widget.js') !!}"></script>
	<script src="{!! asset('js/jquery-file-upload/vendor/tmpl.min.js') !!}"></script>
	<script src="{!! asset('js/jquery-file-upload/vendor/load-image.all.min.js') !!}"></script>
	<script src="{!! asset('js/jquery-file-upload/vendor/canvas-to-blob.min.js') !!}"></script>
	<script src="{!! asset('js/jquery-file-upload/jquery.iframe-transport.js') !!}"></script>
	<script src="{!! asset('js/jquery-file-upload/jquery.fileupload.js') !!}"></script>
	<script src="{!! asset('js/jquery-file-upload/jquery.fileupload-process.js') !!}"></script>
	<script src="{!! asset('js/jquery-file-upload/jquery.fileupload-image.js') !!}"></script>
	<script src="{!! asset('js/jquery-file-upload/jquery.fileupload-ui.js') !!}"></script>
	@endif
	
	@if (!$uploadTemplateIsAppended)
	<script id="{{ $options['clientOptions']['uploadTemplateId'] }}" type="text/x-tmpl">@include('widgets.upload.template.' . $options['clientOptions']['uploadTemplateId'])</script>
	@endif
	@if (!$downloadTemplateIsAppended)
	<script id="{{ $options['clientOptions']['downloadTemplateId'] }}" type="text/x-tmpl">@include('widgets.upload.template.' . $options['clientOptions']['downloadTemplateId'])</script>
	@endif
	
	<script type="text/javascript">
		$('#{{ $fileButtonId }}').fileupload({!! Html::toJson($options['clientOptions']) !!});
		@if (!empty($options['files']))
		$('#{{ $fileButtonId }}').fileupload('option', 'done').call($('#{{ $fileButtonId }}'), $.Event('done'), {result: {files: {!! json_encode($options['files']) !!}}});
		@endif
	</script>
@endpush

@push('styles')
	<link rel="stylesheet" href="{!! asset('css/jquery.fileupload-ui.css') !!}">
	<link rel="stylesheet" href="{!! asset('css/upload.css') !!}">
@endpush