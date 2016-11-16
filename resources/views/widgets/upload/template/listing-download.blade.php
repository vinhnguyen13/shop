{% for (var i=0, file; file=o.files[i]; i++) { %}
	<li class="template-download fade">
		{% if (file.error) { %}
			<div class="file-upload-error"><span class="label label-danger">Error</span><span class="file-name">{%=file.name%}</span>:<span class="file-error-text">{%=file.error%}</span></div>
		{% } else { %}
			{% if (file.input) { %}
	        <input type="hidden" name="{%=file.input.name%}" value="{%=file.input.value%}" />
			{% } %}
			<span class="preview">
				<a href="{%=file.url%}" title="{%=file.name%}">
					<img src="{%=file.thumbnailUrl%}">
				</a>
            </span>
		{% } %}
		{% if (file.deleteUrl) { %}
			<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-imgid="{%=file.imgId%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
				<i class="glyphicon glyphicon-trash"></i>
				<span>Delete</span>
			</button>
		{% } else { %}
			<button class="btn btn-warning cancel">
				<i class="glyphicon glyphicon-ban-circle"></i>
				<span>Cancel</span>
			</button>
		{% } %}
		{% if (file.order) { %}
			<input type="text" name="{%=file.order.name%}" value="{%=file.order.value%}" placeholder="Order">
		{% } %}
	</li>
{% } %}