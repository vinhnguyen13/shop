<?php
namespace App\Helpers;

class FormBuilder extends \Collective\Html\FormBuilder {
	protected $fileCount = 0;
	protected $fileTemplate = ['uploadTemplates' => [], 'downloadTemplates' => []];
	
	public function file($name, $options = [], $default = false) {
		if($default) {
			return $this->input('file', $name, null, $options);
		} else {
			$this->fileCount++;
			
			$defaultOptions = [
				'clientOptions' => [
					'filesContainer' => 'ul.files',
					'uploadTemplateId' => 'listing-upload',
					'downloadTemplateId' => 'listing-download',
					'autoUpload' => true,
					'formData' => [],
					'previewMinWidth' => 130,
					'previewMinHeight' => 98,
					'previewMaxWidth' => 130,
					'previewMaxHeight' => 98,
					'previewCrop' => true,
					/* callback functions
					'add' => 'js(function(){ console.log("add"); })',
					'submit' => 'js(function(){ console.log("submit"); })',
					'send' => 'js(function(){ console.log("send"); })',
					'done' => 'js(function(){ console.log("done"); })',
					'fail' => 'js(function(){ console.log("fail"); })',
					...
					*/
				]
			];
			
			$options = array_replace_recursive($defaultOptions, $options);
			
			$fileWrap = 'file-wrap';
			$fileWrapId = "$fileWrap-{$this->fileCount}";
			$fileButton = 'file-upload-button';
			$fileButtonId = "$fileButton-{$this->fileCount}";
			
			$options['clientOptions']['filesContainer'] = "#$fileWrapId {$options['clientOptions']['filesContainer']}";
			
			$uploadTemplateIsAppended = $this->fileTemplateIsAppended($options['clientOptions']['uploadTemplateId'], 'uploadTemplates');
			$downloadTemplateIsAppended = $this->fileTemplateIsAppended($options['clientOptions']['downloadTemplateId'], 'downloadTemplates');
			
			$multiple = isset($options['clientOptions']['maxNumberOfFiles']) && $options['clientOptions']['maxNumberOfFiles'] == 1 ? false : true;
			
			return $this->toHtmlString(view('widgets.upload.upload', [
				'name' => $name,
				'multiple' => $multiple,
				'fileCount' => $this->fileCount,
				'fileWrap' => $fileWrap,
				'fileWrapId' => $fileWrapId,
				'fileButton' => $fileButton,
				'fileButtonId' => $fileButtonId,
				'options' => $options,
				'uploadTemplateIsAppended' => $uploadTemplateIsAppended,
				'downloadTemplateIsAppended' => $downloadTemplateIsAppended
			]));
		}
	}
	
	private function fileTemplateIsAppended($templateId, $templateType) {
		if(in_array($templateId, $this->fileTemplate[$templateType])) {
			return true;
		} else {
			$this->fileTemplate[$templateType][] = $templateId;
		}
		
		return false;
	}

    public function customCheckbox($name, $value = 1, $checked = null, $options = []) {
    	$checkbox = $this->hidden($name, 0);
    	$checkbox .= parent::checkbox($name, $value, $checked, $options);
    	
        return $this->toHtmlString($checkbox);
    }
    
    public function checkboxGroups($name, $list, $defaults = [], $options = []) {
    	if($this->model) {
    		$defaults = is_array($this->model->$name) ? $this->model->$name : [];
    	}
    	
    	$template = isset($options['template']) ? $options['template'] : '<label>{checkbox}{label}</label>';
    	$checkboxs = '';
    	
    	foreach ($list as $k => $v) {
    		$checkboxs .= str_replace(['{checkbox}', '{label}'], [$this->checkbox("{$name}[]", $k, in_array($k, $defaults)), $v], $template);
    	}
    	
    	return $this->toHtmlString($checkboxs);
    }
}