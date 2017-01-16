$(document).ready(function () {
    var swiper = new Swiper('.slidedetailpage', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        onSlideChangeStart: function (swiper) {
            $('.detail__img--thumb li').removeClass('active');
            $('.detail__img--thumb li').eq(swiper.activeIndex).addClass('active');
        }
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