$(document).ready(function () {
    $(document).on('click', '.sidebar-toggle', function (e) {
        setCookie("sidebar", 1, 1);
        if($('body').hasClass( "sidebar-collapse")){
            setCookie("sidebar", 0, 1);
        }
        console.log(getCookie("sidebar"));
    });
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


$.fn.loading = function (options) {
    var settings = $.extend({
        display: true,
        onLoadStart: function (box) {
            return box;
        }, //Right after the button has been clicked
        onLoadDone: function (box) {
            return box;
        } //When the source has been loaded
    }, options);

    var overlay = $('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');
    var box = $(this);
    if(settings.display == true){
        start(box);
    }else{
        done(box);
    }

    function start(box) {
        //Add overlay and loading img
        box.append(overlay);
        settings.onLoadStart.call(box);
    }

    function done(box) {
        //Remove overlay and loading img
        box.find('.overlay').remove();
        settings.onLoadDone.call(box);
    }
};