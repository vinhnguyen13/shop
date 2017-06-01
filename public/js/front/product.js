$(document).ready(function () {
    var swiper = new Swiper('.detail__related .swiper-container', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
    });


    swiperDetail();
    $(window).on('resize', function () {
        swiperDetail();
    });
    //slide img detail mobile
    function swiperDetail() {
        var wWin = $(window).outerWidth(), swiperDetail;

        swiperDetail = new Swiper('.slidedetailpage', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            spaceBetween: 10
        });

        if ( wWin > 768 ) {
            var swiperWrapper = $('.slidedetailpage .swiper-wrapper'),
                newSlides = $('.slidedetailpage').find('.swiper-slide').clone(true);

            swiperDetail.destroy();
            swiperWrapper.empty().append(newSlides);
        }
    }

    $('.detail__desc .dropdown').dropdown({
        beforeOpen: function () {
            var hSlim = $('.detail__desc .dropdown ul').outerHeight();
            if ( hSlim > 300 ) {
                $('.detail__desc .dropdown .dropdown__inner').slimScroll({
                    height: '300',
                    railVisible: true,
                    alwaysVisible: true
                });
            }
        },
        closeWhenSelectVal: function (item, dropItem) {
            $('#val-size').val( item.find('.detail__size').data('size') );
            $('#val-product').val( item.find('.detail__size').data('product') );

            var itemSizeClone = item.find('.detail__size').clone(),
                itemPriceClone = item.find('.detail__price').clone();
            itemSizeClone.prepend("<span>Size</span>");
            dropItem.find('.get-val').html('');

            dropItem.find('.get-val').prepend(itemPriceClone);
            dropItem.find('.get-val').append(itemSizeClone);
        }
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
            var hWrapSlide = $('.slidedetailpage').outerHeight() + $('.slidedetailpage').offset().top,
                hPagi = $('.slidedetail__pagi').outerHeight(),
                offsetPagi = $('.slidedetail__pagi').position().top,
                wW = $(window).outerWidth();

            $(window).on('scroll', function () {
                var val = $(this).scrollTop();

                if ( offsetPagi + hPagi + val > hWrapSlide ) {
                    $('.slidedetail__pagi').hide();
                }else {
                    $('.slidedetail__pagi').show();
                }
                //fixColumn(val);
            }).trigger('scroll');

            if ( wW > 768 ) {
                $(".detail__desc").stick_in_parent({
                    offset_top: 100,
                    parent: "[data-sticky_parent]"
                });

                $(".detail__desc")
                .on('sticky_kit:bottom', function(e) {
                    $(this).parent().css('position', 'static');
                })
                .on('sticky_kit:unbottom', function(e) {
                    $(this).parent().css('position', 'relative');
                });
            }

            // function fixColumn(val) {
            //     //console.log(val);
            //     var wrapFix = $('.detail__desc--fix'),
            //         parentFix = $('.detail__desc--inner'),
            //         offsetWrapTop = parentFix.offset().top,
            //         hWrapFix = wrapFix.outerHeight(),
            //         hColLeft = $('.detail__img').outerHeight();

            //     if ( (val + hWrapFix) >= hColLeft ) {
            //         console.log("bottom");
            //         wrapFix.css({
            //             top: hColLeft - hWrapFix
            //         });
            //     }else if ( val + 55 > offsetWrapTop ) {
            //         wrapFix.addClass('fixed');
            //         wrapFix.css({
            //             top: val
            //         });
            //     }else {
            //         wrapFix.removeClass('fixed');
            //         wrapFix.css({
            //             top: 0
            //         });
            //     }
            // }
        });
    /**
     * Buy button
     */
    $(document).on('click', '.btn-buy', function (e) {
        $(this).loading({inside_right: true});
        var form = $('#frmAddCart');
        var product = $('input[name="product"]').val();
        if(product){
            var data = form.serializeArray();
            data.push({name: "data", product: product});
            $.ajax({
                type: "post",
                url: urlAddCart,
                data: $.param(data),
                success: function (data) {
                    if(data.total > 0){
                        if($('.header__cart .val-selected .header__cart--num').length > 0) {
                            $('.header__cart .val-selected .header__cart--num').html('('+data.total+')');
                            $('.header__cart .val-selected .header__cart--num').removeClass('hide');
                        }
                    }
                    if(data.html){
                        $('.header__cart .dropdown__inner').html(data.html);
                    }
                    $('.header__cart .val-selected').trigger('click');
                    $('body').loading({remove: true});
                },
                error: function (error) {
                }
            });
        }
        return false;
    });

    if(sizeSelected){
        $('.dropdown__inner li[data-size="'+sizeSelected+'"] a').trigger('click');
        $('#frmAddCart .val-selected').trigger('click');
    }
});