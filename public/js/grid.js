var form;
var gridFormSelector = '.grid-form';
var toogleColumnsSelector = '.apply-toogle-columns';
var popupShowClass = 'grid-popup-show';

var selectors = {
	grid: '.grid',
	gridTitle: '.grid-title',
	gridBody: '.grid-body',
	gridCounter: '.grid-counter',
	pagination: '.pagination',
	toogleColumnsSelector: toogleColumnsSelector
};

$(document).ready(function(){
	var gridActions = $('#grid-actions');
	var activePopup = $();
	var gridTable = $(selectors.grid);
	var loading = $('#grid-loading');
	
	form = $(gridFormSelector);
	
	form.on('keyup', 'input[type=text]', function(e){
		if(e.keyCode == 13) {
			grid.submit();
		}
	});
	
	form.on('change', 'select', function(){
		grid.submit();
	});
	
	var gridExtend = {
		_replaceSelectors: [],
		_preventSubmit: false,
		registerReplaceSelector: function(selector) {
			this._replaceSelectors.push(selector);
		},
		submit: function(fn) {
			if(this._preventSubmit) {
				this._preventSubmit = false;
			} else {
				form.trigger('submit', [fn]);
			}
		},
		preventSubmit: function() {
			this._preventSubmit = true;
		},
		ajax: function(url, selectors, fn) {
			grid.loading();
			
			$.get(url, function(html){
				grid.loaded();
				
				grid.replaceEl(html, selectors.concat(grid._replaceSelectors));
				
				if(fn) {
					fn(html);
				}
			});
		},
		loading: function() {
			loading.show();
		},
		loaded: function() {
			loading.hide();
		},
		replaceEl: function(html, selectors) {
			var rf = $(html).find(gridFormSelector);
			
			for(var i in selectors) {
				var selector = selectors[i];
				var replace = rf.find(selector);
				var find = form.find(selector);
				
				if(replace.length) {
					find.show().replaceWith(replace);
				} else {
					find.hide();
				}
			}
		}
	};
	
	jQuery.extend(grid, gridExtend);
	
	for(var i in grid.callbacks) {
		grid.callbacks[i]();
	}
	
	form.on('click', toogleColumnsSelector, function() {
		var path = window.location.pathname;
		var unchecked = [];
		
		form.find('.cb input').each(function(){
			if(!this.checked) {
				unchecked.push($(this).data('name'));
			}
		});

		setCookie('columns', encodeURIComponent(JSON.stringify(unchecked)), 360, path);
	});
	
	if(gridTable.data('ajax')) {
		
		form.on('click', selectors.gridTitle + ' a', function(e) {
			e.preventDefault();
			
			form.find('input[name=sort]').val($(this).data('sort'));
			
			grid.submit();
		});
		
		form.on('click', '.reset-filter', function(e) {
			e.preventDefault();
			
			grid.ajax($(this).attr('href'), [toogleColumnsSelector, selectors.gridCounter, selectors.grid, selectors.pagination]);
		});
		
		form.on('click', toogleColumnsSelector, function(e) {
			e.preventDefault();
			
			grid.ajax($(this).attr('href'), ['.grid'], function() {
				activePopup.removeClass(popupShowClass);
			});
		});
		
		form.on('click', '.pagination a', function(e) {
			e.preventDefault();
			
			grid.ajax($(this).attr('href'), [selectors.gridBody, selectors.pagination, selectors.gridCounter]);
		});
		
		form.on('submit', function(e, fn) {
			e.preventDefault();

			var action = form.attr('action');
			var serialize = form.serialize();
			var sign = (action.indexOf('?') !== -1) ? '&' : '?';
			var url = action + sign + serialize;
			
			grid.ajax(url, [toogleColumnsSelector, selectors.gridTitle, selectors.gridBody, selectors.gridCounter, selectors.pagination], function(r) {
				if(fn) {
					fn(r);
				}
			});
		});
	}
	
	form.on('click', '.grid-popup-button', function(e) {
		e.preventDefault();
		e.stopPropagation();
		
		var button = $(this);
		var popup = button.closest('.has-popup').find('.grid-popup-wrap');
		
		if(activePopup.get(0) != popup.get(0)) {
			activePopup.removeClass(popupShowClass);
		}
		
		popup.toggleClass(popupShowClass);
		
		activePopup = popup;
		
		var offset = button.offset();
		var buttonWidth = button.outerWidth();
		var popupWidth = popup.outerWidth();

		var left = (buttonWidth/2) - (popupWidth/2);
		
		if(left + offset.left < 0) {
			left = -offset.left;
		}
		
		popup.css({
			left: left
		});
		
		popup.find('.arrow').css({
			left: -left + (buttonWidth/2) - 8
		});
	});
	
	$(document).on('click', function(e){
		var target = $(e.target);

		if(activePopup.has(target).length == 0 && activePopup.get(0) != target.get(0)) {
			activePopup.removeClass(popupShowClass);
		}
	});
});

function setCookie(cname, cvalue, exdays, path) {
	if(!path) {
		path = "/";
	}
	
	if(typeof exdays === 'undefined') {
		document.cookie = cname + "=" + cvalue + "; path=" + path;
	} else {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toGMTString();
		document.cookie = cname + "=" + cvalue + "; " + expires + "; path=" + path;
	}
};

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ')
			c = c.substring(1);
		
		if (c.indexOf(name) != -1)
			return c.substring(name.length,c.length);
	}
	
	return "";
};