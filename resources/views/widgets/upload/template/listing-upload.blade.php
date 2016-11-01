{% for (var i=0, file; file=o.files[i]; i++) { %}
	<li class="template-upload fade">
		<span class="preview"></span>
		<p class="name">{%=file.name%}</p>
		<strong class="error text-danger"></strong>
		<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
		{% if (!i && !o.options.autoUpload) { %}
			<button class="btn btn-primary start" disabled>
				<i class="glyphicon glyphicon-upload"></i>
				<span>Start</span>
			</button>
		{% } %}
		{% if (!i) { %}
			<button class="btn btn-warning cancel">
				<i class="glyphicon glyphicon-ban-circle"></i>
				<span>Cancel</span>
			</button>
		{% } %}
    </li>
{% } %}