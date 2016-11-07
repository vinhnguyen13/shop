// JavaScript Document
$(document).ready(function () {
	var hWindow,
		hHeader,
		hSlideHome;

	$(window).on('resize', function () {
		hWindow = $(window).outerHeight();
		hHeader = $('header').outerHeight();
		hSlideHome = hWindow - hHeader;

		$('.slidehomepage, .userauth').height(hSlideHome);

	}).trigger('resize');
	
	$('#menu-open').click(function (e) {
		$('#menu-open, #menu, html, body').addClass('active');
	});

	$('#menu-close').click(function () {
		$('#menu-open, #menu, html, body').removeClass('active');
	});

	hideElOutSite('#menu, #menu-open', function() {
		$('#menu-open, #menu, html, body').removeClass('active');
	});

	var flagCheck = false, timeoutRemove;
	$(window).on('scroll', function () {
		var valScroll = $(this).scrollTop();
		
		if (valScroll > hHeader+50) {
			if (flagCheck) return;
			$('header').addClass('active-before');
			timeoutRemove = setTimeout(function () {
				$('header').addClass('active');
			}, 500);
			flagCheck = true;
		}else {
			flagCheck = false;
			clearTimeout(timeoutRemove);
			$('header').removeClass('active');
			$('header').removeClass('active-before');
		}
	});

	$('#menu .inner-menu').slimScroll({
	    height: '100%',
	    alwaysVisible: true
	});

	$('.header__cart').dropdown();

	$('.header__right--mbsearch').on('click', function (e) {
		e.preventDefault();
		$('.header__right .frm-icon').addClass('expand-search');
	});
	hideElOutSite('.header__right .frm-icon, .header__right--mbsearch', function () {
		$('.header__right .frm-icon').removeClass('expand-search');
	});

	$('#menu li.has-sub > a').on('click', function (e) {
		e.preventDefault();
		$('#menu li.has-sub').removeClass('sub-open');
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		}else {
			$(this).addClass('active');
			$(this).parent().addClass('sub-open');
		}
	});
});

function checkMobile () {
	var wW = $(window).outerWidth();
	if (wW <= 768) {
		return true;
	}
	return false;
}

function hideElOutSite (el, callBackItem) {
    $(document).on('click', function (e) {
        var container = $(el);
        if ( !container.is(e.target) && container.has(e.target).length === 0 ) {
            callBackItem();
        }
    });
}

$.fn.dropdown = function (options) {

    return this.each(function() {
        var defaults = {
            selectedValue: false,
            hideWhenSelected: true,
            load: function() {},
            beforeOpen: function() {},
            closeCallBack: function() {}
        },
        sc = {},
        el = $(this),
        itemClick = el.find('.val-selected'),
        txtItemClick = itemClick.find('.txt-selected'),
        itemDropClick = el.find('.dropdown__inner a');

        if ( el.length == 0 ) return el;

        sc.settings = $.extend({}, defaults, options);

        itemClick.on('click', toggleView);

        showSortLoad();

        //sc.settings.load(el);

        if ( sc.settings.selectedValue ) {
            selectItem();
        }

        itemDropClick.on('click', function (e) {
            //e.preventDefault();
            itemClick.trigger('click');
        });
        
        // set value input when reload page
        function showSortLoad () {
            if ( el.hasClass('price-area') ) {
                renderPriceArea.updateHidden(el);
                return;
            }
            if ( el.find('input[type=hidden]').val() != '' ) {
                var valInputHidden = el.find('input[type=hidden]').val();
                itemDropClick.each(function () {
                    var _this = $(this),
                        dataValue = _this.data('value'),
                        txtItem = _this.text();

                    if ( valInputHidden == dataValue ) {
                        if ( txtItemClick.find('.get-val').length ) {
                            txtItemClick.find('.get-val').text(txtItem);
                        }else {
                            txtItemClick.text(txtItem);
                        }
                    }
                });
            }
        }

        // toggle show and hide
        function toggleView (e) {
            e.preventDefault();
            var _this = $(this);

            if ( _this.hasClass('active') ) {
                _this.removeClass('active');
                el.find('.dropdown-up-style').removeClass('active');
                setTimeout(function() {
                    el.find('.dropdown-up-style').addClass('hide');
                },250);
                sc.settings.closeCallBack(el);
            }else {
                _this.addClass('active');
                el.find('.dropdown-up-style').removeClass('hide');
                setTimeout(function() {
                    el.find('.dropdown-up-style').addClass('active');
                },50);
                sc.settings.beforeOpen(el);
            }
        }

        // show item when click in dropdown
        function selectItem () {
            itemDropClick.unbind('click');
            itemDropClick.on('click', function (e) {
                e.preventDefault();
                var _this = $(this),
                    txtClick = _this.text(),
                    valSelected = _this.data('value');

                itemDropClick.removeClass('active');
                _this.addClass('active');
                if ( itemClick.find('.get-val').length ) {
                    itemClick.find('.get-val').text(txtClick);
                }else {
                    txtItemClick.text(txtClick);
                }
                el.find('input[type=hidden]').val(valSelected);
                itemClick.trigger('click');
            });
        }

        hideElOutSite(el, function () {
            el.find('.val-selected').removeClass('active');
            el.find('.dropdown-up-style').removeClass('active');
            setTimeout(function() {
                el.find('.dropdown-up-style').addClass('hide');
            },250);
        });

    });
}