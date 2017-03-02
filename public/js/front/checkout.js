$(document).ready(function(){
    var textButtonStep = ['Đặt hàng', 'Thanh toán'];
    var wrapMainCheckout = 'wrap-checkout';
    var wrapCheckoutInfo = 'checkout__inforpro';
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
        var detail = $(this).closest('.checkout-product-detail').attr('data-product-detail');
        if(detail) {
            var timer = 0;
            timer = setTimeout(function () {
                $.ajax({
                    type: "post",
                    url: urlRemoveCart,
                    data: {detail: detail},
                    success: function (data) {
                        $('body').loading({remove: true});
                        location.reload(true);
                    }
                });
            }, 500);
        }
        return false;
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
        $('#orderForm .alert-dismissable').addClass('hide');
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
                        window.location.href = redirect;
                    }else{
                        console.log(data.message);
                        var html = '';
                        $.each(data.message, function (index, value) {
                            html += value[0]+'<br/>';
                        });
                        $('#orderForm .alert-dismissable p').html(html);
                        $('#orderForm .alert-dismissable').removeClass('hide');
                    }
                }
            });
        }, 500);
    });

    $('.'+wrapCheckoutInfo).on('change', '.quantity_select', function(){
        var detail = $(this).closest('.checkout-product-detail').attr('data-product-detail');
        var quantity = $(this).val();
        console.log(detail);
        $('.'+wrapMainCheckout).trigger('checkout/func/updateCart', [detail, quantity]);
    });

    $('.'+wrapMainCheckout).bind('checkout/func/updateCart', function (event, detail, quantity) {
        $(this).loading({inside_right: true});
        var timer = 0;
        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlAddCart,
                data: {detail: detail, quantity: quantity},
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

                    $.ajax({
                        type: "get",
                        url: urlUpdateCart,
                        success: function (data) {
                            console.log(data);
                            if(data.html) {
                                $('.' + wrapCheckoutInfo).html(data.html);
                            }
                        }
                    });
                    $('body').loading({remove: true});
                },
                error: function (error) {
                }
            });

        }, 500);
    });

});

