$(document).ready(function(){
    var textButtonStep = ['Đặt hàng', 'Tiếp tục', 'Tiếp tục', 'Thanh toán'];
    var wrapClassStep = ['wrap-products', 'wrap-shipping', 'wrap-billing', 'wrap-payment'];

    var wrapMainCheckout = 'wrap-checkout';
    var stepCheckout = 'step-checkout';
    var btnBack = 'btn-back';
    var btnOrder = 'btn-order';

    $('.'+wrapMainCheckout).on('click', '.btn', function(){
        var button = $(this);
        var stepActive = $('.'+wrapMainCheckout).find('.'+stepCheckout + ':not(.hide)');
        var stepTotal = $('.'+wrapMainCheckout).find('.'+stepCheckout).length;
        if(button.hasClass(btnBack)){
            var stepFuture = stepActive.prev();
            var _index = stepFuture.index();
        }else{
            var stepFuture = stepActive.next();
            var _index = stepFuture.index();
        }
        console.log(_index);


        if(_index > stepTotal){
            console.log('Pay');
        }else{
            $('.'+wrapMainCheckout).trigger('checkout/ui/step');
            stepFuture.removeClass('hide');
            stepActive.addClass('hide');
            $('.'+btnOrder).html(textButtonStep[_index-1]);
            if(_index == 1){
                $('.'+btnBack).addClass('hide');
            }else{
                $('.'+btnBack).removeClass('hide');
            }

            console.log('total step: '+stepTotal);
        }
        return false;
    });


    $('.'+wrapMainCheckout).on('click', '.removeCart', function(){
        $(this).loading({inside_right: true});
        $(this).closest('tr').remove();
        var pid = $(this).closest('tr').attr('data-product-id');
        var timer = 0;
        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlRemoveCart,
                data: {data: pid},
                success: function (data) {
                    $('body').loading({remove: true});
                }
            });
        }, 500);
        return false;
    });

    $('.'+wrapMainCheckout).bind('checkout/ui/step', function (event, data) {

    });
});