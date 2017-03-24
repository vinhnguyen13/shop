// JavaScript Document
$(document).ready(function () {

    $('.toggle__auth').on('click', function (e) {
        e.preventDefault();
        var _this = $(this),
            wWin = $(window).outerWidth();

        if ( wWin > 768 ) {
            _this.hide();
            _this.parent().find('ul').show();
            setTimeout(function () {
                _this.parent().addClass('show__auth--user');
            }, 100);
        }else {
            if ( _this.hasClass('active') ) {
                _this.removeClass('active');
                _this.parent().removeClass('show__auth--user');
                $('#wrapper').removeClass('header__mobi');
            }else {

                _this.addClass('active');
                _this.parent().addClass('show__auth--user');
                $('#wrapper').addClass('header__mobi');
                $('form.search').removeClass('show__sub--search');
                $('.header__right--mbsearch').removeClass('active');
            }
            
        }
        
    });

    $('.header__left .dropdown').dropdown();

	var hWindow,
		hHeader,
		hSlideHome;

	$(window).on('resize', function () {
		hWindow = $(window).outerHeight();
		hHeader = $('header').outerHeight();
		hSlideHome = hWindow - hHeader;

		$('.slidehomepage-1,.slidehomepage-2, .userauth').height(hSlideHome);

	}).trigger('resize');
	
	$('#menu-open').click(function (e) {
        $('#menu').addClass('active');
        setTimeout(function () {
            $('body').addClass('menu-left');
        }, 100);
    });

	$('#menu-close').click(function () {
		$('body').removeClass('menu-left');
        setTimeout(function () {
            $('#menu').removeClass('active');
        }, 100);
	});

	hideElOutSite('#menu, #menu-open', function() {
		$('body').removeClass('menu-left');
        setTimeout(function () {
            $('#menu').removeClass('active');
        }, 100);
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

    /*$('#menu .inner-menu').slimScroll({
	    height: '100%',
	    alwaysVisible: true
	});*/

	$('.header__cart').dropdown();

	$('.header__right--mbsearch').on('click', function (e) {
		e.preventDefault();
        var _this = $(this);

        if ( _this.hasClass('active') ) {
            _this.removeClass('active');
            _this.parent().removeClass('show__sub--search');
            $('#wrapper').removeClass('header__mobi');
        }else {
            $('.toggle__auth').removeClass('active');
            $('.auth__user').removeClass('show__auth--user');
            _this.addClass('active');
            $('#wrapper').addClass('header__mobi');
            _this.parent().addClass('show__sub--search');
        }
        
	});
	hideElOutSite('.header__right .frm-icon, .header__right--mbsearch, .auth__user', function () {
        var wWin = $(window).outerWidth();

		$('#wrapper').removeClass('header__mobi');
        if (wWin <= 768) {
            $('.auth__user').removeClass('show__auth--user');
        }
        $('.header__right--mbsearch').removeClass('active');
        $('form.search').removeClass('show__sub--search');
        $('.toggle__auth').removeClass('active');
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
            closeCallBack: function() {},
            closeWhenSelectVal: function () {}
        },
        sc = {},
        el = $(this),
        itemClick = el.find('.val-selected'),
        txtItemClick = itemClick.find('.txt-selected'),
        itemDropClick = el.find('.dropdown__inner a');

        if ( el.length == 0 ) return el;

        sc.settings = $.extend({}, defaults, options);

        itemClick.unbind('click');
        itemClick.on('click', toggleView);

        showSortLoad();

        if ( sc.settings.selectedValue ) {
            selectItem();
        }

        //itemDropClick.unbind('click');
        itemDropClick.on('click', function (e) {
            if ( validateURL($(this).attr('href')) ) {
                window.location = $(this).attr('href');
            }
            e.preventDefault();
            sc.settings.closeWhenSelectVal($(this), el);
            itemClick.trigger('click');
        });

        function validateURL(textval) {
            var urlregex = /^(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+&%$#=~_-]+))*$/;
            return urlregex.test(textval);
        }
        
        // set value input when reload page
        function showSortLoad () {
            if ( el.hasClass('price-area') ) {
                renderPriceArea.updateHidden(el);
                return;
            }
            if ( el.find('input[type=hidden]').val() !== undefined ) {
                var valInputHidden = el.find('input[type=hidden]').val();
                itemDropClick.each(function () {
                    var _this = $(this),
                        dataValue = _this.data('value'),
                        txtItem = _this.text();

                    dataValue = typeof dataValue === "number" ? ""+dataValue+"" : dataValue ;

                    if ( valInputHidden === dataValue ) {
                        if ( itemClick.find('.get-val').length ) {
                            itemClick.find('.get-val').text(txtItem);
                        }else {
                            itemClick.text(txtItem);
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
                if ( $(window).outerWidth() <= 768 ) {
                    $('#wrapper').addClass('header__mobi');
                }
            }
        }

        // show item when click in dropdown
        function selectItem () {
            //itemDropClick.unbind('click');
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
                //itemClick.trigger('click');
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