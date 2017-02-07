$(document).ready(function(){
    var textButtonStep = ['Đặt hàng', 'Thanh toán'];
    var wrapMainCheckout = 'wrap-checkout';
    var wrapCheckoutInfo = 'checkout__infor';
    var stepCheckout = 'step-checkout';
    var paymentWrapBank = 'checkout__slect--payment-bank';
    var paymentDropdownBank = 'checkout__bank';
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
        var size = $(this).closest('tr').attr('data-product-size');
        var timer = 0;
        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlRemoveCart,
                data: {data: pid, size: size},
                success: function (data) {
                    $('body').loading({remove: true});
                    location.reload(true);
                }
            });
        }, 500);
        return false;
    });

    $('.'+wrapMainCheckout).on('click', '.checkout__slect--payment ul li input', function(){
        if($(this).is(':checked')) {
            var _index = $(this).closest('li').index();
            if(_index !== 0){
                $('.'+paymentWrapBank).removeClass('hide');
                $('.'+paymentDropdownBank).addClass('hide');
                $('.'+paymentDropdownBank+':eq('+(_index-1)+')').removeClass('hide');
            }else{
                $('.'+paymentWrapBank).addClass('hide');
                $('.'+paymentDropdownBank).addClass('hide');
            }
        } else {
            console.log(9);
        }
    });

    $('.'+wrapMainCheckout).on('change', '.select-location', function(){
        $(this).loading({inside_right: true});
        var timer = 0;
        var child = $(this).attr('data-child');
        var id = $(this).val();

        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlLocation,
                data: {id: id, child: child},
                success: function (data) {
                    var html = '';
                    $.each(data, function(key, value) {
                        html +=
                            '<option value="'+key+'">'
                            + value +
                            '</option>';
                    });
                    $('.select-'+child).html(html);
                    $('body').loading({remove: true});
                }
            });
        }, 500);
        return false;
    });

    $('.'+wrapMainCheckout).on('click', 'input[id=chkShippingDiffBilling]', function(){
        if($(this).is(':checked')) {
            $('#wrap-billing').removeClass('hide');
        } else {
            $('#wrap-billing').addClass('hide');
        }
    });


    $('.'+wrapMainCheckout).bind('checkout/ui/autoFillBillingForm', function (event, data) {
        $('.'+wrapMainCheckout).on('keyup', 'input[name="shipping_name"]', function(){
            var val = $(this).val();
            $('input[name="billing_name"]').val(val);
        });
        $('.'+wrapMainCheckout).on('keyup', 'input[name="shipping_address"]', function(){
            var val = $(this).val();
            $('input[name="billing_address"]').val(val);
        });
        $('.'+wrapMainCheckout).on('keyup', 'input[name="shipping_phone"]', function(){
            var val = $(this).val();
            $('input[name="billing_phone"]').val(val);
        });
        $('.'+wrapMainCheckout).on('change', 'select.form-control', function(){
            var id = $(this).val();
            var clss = $(this).attr('class').split(" ");
            var index = clss.length - 1;
            $('#wrap-billing select.'+clss[index]+' option[value="'+id+'"]').prop("selected", true);
            console.log(clss[index]);
        });
    });
    $('.'+wrapMainCheckout).trigger('checkout/ui/autoFillBillingForm');

    $('.'+wrapMainCheckout).bind('checkout/ui/step', function (event, data) {

    });

    $('.'+wrapMainCheckout).bind('checkout/func/order', function (event, form) {
        $(this).loading({inside_right: true});
        var timer = 0;
        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlOrder,
                data: form,
                success: function (data) {
                    if(data.code == 0) {
                        $('body').loading({remove: true});
                        var redirect = urlPaymentSuccess+'?order=';
                    }else{
                        var redirect = urlPaymentFail;
                    }
                    window.location.href = redirect;
                }
            });
        }, 500);
    });

    $('.'+wrapCheckoutInfo).on('change', '.quantity_select', function(){

    });

    $('.'+wrapMainCheckout).bind('checkout/func/order', function (event, form) {
        $(this).loading({inside_right: true});
        var timer = 0;
        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlOrder,
                data: form,
                success: function (data) {
                    if(data.code == 0) {
                        $('body').loading({remove: true});
                        var redirect = urlPaymentSuccess+'?order=';
                    }else{
                        var redirect = urlPaymentFail;
                    }
                    window.location.href = redirect;
                }
            });
        }, 500);
    });

});

