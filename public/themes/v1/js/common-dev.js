// JavaScript Document
$(document).ready(function () {

$.fn.loading = function (options) {

    return this.each(function() {
        var defaults = {
                inside_left: false,
                left: 10,
                inside_right: false,
                right: 10,
                full: true,
                elLoading: '<div class="loading"><span></span></div>',
                remove: false,
                done: function () {}
            },
            sc = {},
            settings,
            el = $(this);

        if ( el.length == 0 ) return el;

        settings = $.extend({}, defaults, options);

        if ( settings.remove ) {
            el.find('.loading').addClass('remove-loading');
            setTimeout(function () {
                el.find('.loading').remove();
            }, 220);
            return;
        }

        el.css({
            position: 'relative'
        });

        el.append( $(settings.elLoading) );

        if ( settings.inside_left ) {
            el.find('.loading').css({
                left: settings.left+'px',
            });
        }else if ( settings.inside_right ) {
            el.find('.loading').css({
                right: settings.right+'px',
            });
        }else { //default settings.full === true
            if ( el.is('body') ) {
                el.find('.loading').css({
                    position: 'fixed'
                });
            }
            el.find('.loading').css({
                height: '100%',
                width: '100%',
                top: 0,
                left: 0,
                'margin-top': 0,
                'background-color': 'rgba(0, 0, 0, 0.26)'
            });
            el.find('.loading span').css({
                position: 'absolute',
                left: '50%',
                top: '50%',
                'margin-top': '-10px',
                'margin-left': '-10px'
            });
        }
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

});