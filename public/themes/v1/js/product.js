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
                    $('body').loading({remove: true});
                },
                error: function (error) {
                }
            });
        }
        return false;
    });
});