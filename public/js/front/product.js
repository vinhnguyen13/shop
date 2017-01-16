$(document).ready(function () {
    $('.detail__desc .dropdown').dropdown({
        closeWhenSelectVal: function (item, dropItem) {
            $('#val-size').val( item.find('.detail__size').data('value') );
            $('#val-price').val( item.find('.detail__price').data('value') );
            var itemSizeClone = item.find('.detail__size').clone(),
                itemPriceClone = item.find('.detail__price').clone();
            itemSizeClone.prepend("<span>Size</span>");
            dropItem.find('.get-val').html('');

            dropItem.find('.get-val').prepend(itemPriceClone);
            dropItem.find('.get-val').append(itemSizeClone);
        }
    });

    $('.detail__desc .dropdown .dropdown__inner').slimScroll({
        height: '300px',
        railVisible: true,
        alwaysVisible: true
    });

    $("img.lazy").lazyload({
        effect : "fadeIn"
    });

    //render pagi slide
    var wrapPagi = $("<ul></ul>");
    $('.slidedetail__item').each(function () {
        var item = $("<li><a href=''><span></span></a></li>");
        item.find('a').on('click', pagiSlide);
        wrapPagi.append(item);
    });
    $('.slidedetail__pagi').append(wrapPagi);

    function pagiSlide(event) {
        event.preventDefault();
        var _this = $(this),
            indexPagi = _this.parent().index(),
            offsetItem = $('.slidedetail__item').eq(indexPagi).offset().top,
            setScroll = offsetItem - 55;

        if ( indexPagi === 0 ) setScroll = 0;

        var body = $("html, body");
        body.stop().animate({ scrollTop: setScroll }, '500', 'swing');
    }

    $('.slidedetailpage').imagesLoaded()
        .done( function( instance ) {
            var hWrapSlide = $('.slidedetailpage').outerHeight() + $('.slidedetailpage').offset().top;
            $(window).on('scroll', function () {
                var val = $(this).scrollTop();
                console.log(val, $('.detail__related').outerHeight(), hWrapSlide);
                if ( val + $('.detail__related').outerHeight() > hWrapSlide ) {
                    $('.slidedetail__pagi').hide();
                }else {
                    $('.slidedetail__pagi').show();
                }
            });
        });



    $('.detail__img--thumb li').eq(0).addClass('active');
    $('.detail__img--thumb li a').on('click', function (e) {
        e.preventDefault();
        var i = $(this).parent().index();
        $('.detail__img--thumb li').removeClass('active');
        $(this).parent().addClass('active');
        swiper.slideTo(i);
    });

    $("img.lazy").lazyload({
        effect : "fadeIn"
    });

    /**
     * Buy button
     */
    $(document).on('click', '.btn-buy', function (e) {
        $(this).loading({inside_right: true});
        var form = $('#frmAddCart');
        if(true){
            var data = form.serializeArray();
            data.push({name: "data", value: dataRequest});
            $.ajax({
                type: "post",
                url: urlAddCart,
                data: $.param(data),
                success: function (data) {
                    if(data.total > 0){
                        if($('.header__cart .val-selected .header__cart--num').length > 0) {
                            $('.header__cart .val-selected .header__cart--num').html(data.total);
                            $('.header__cart .val-selected .header__cart--num').removeClass('hide');
                        }
                    }
                    if(data.html){
                        $('.header__cart .dropdown__inner').html(data.html);
                    }
                    $('body').loading({remove: true});
                },
                error: function (error) {
                }
            });
        }
        return false;
    });
});