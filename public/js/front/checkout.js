$(document).ready(function(){
    var textButtonStep = ['Đặt hàng', 'Tiếp tục', 'Tiếp tục', 'Thanh toán'];

    var wrapMainCheckout = 'wrap-checkout';
    var stepCheckout = 'step-checkout';
    var btnBack = 'btn-back';
    var btnOrder = 'btn-order';

    $('.'+wrapMainCheckout).on('click', '.btn-checkout', function(){
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

        if(_index > stepTotal){
            console.log('Pay');
            var form = $('#orderForm').serialize();
            $('.'+wrapMainCheckout).trigger('checkout/func/order', [form]);
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

    $('.'+wrapMainCheckout).bind('checkout/func/order', function (event, form) {
        console.log(form);
        $(this).loading({inside_right: true});
        var timer = 0;
        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlOrder,
                data: form,
                success: function (data) {
                    $('body').loading({remove: true});
                }
            });
        }, 500);
    });
});