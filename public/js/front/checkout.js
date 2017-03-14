$(document).ready(function(){
    var textButtonStep = ['Xác nhận', 'Thanh toán'];
    var wrapCheckoutUser = 'checkout__infor__user';
    var wrapCheckoutPayment = 'checkout__infor__payment';
    var wrapCheckoutUserShipping = 'checkout__infor__user__shipping';
    var wrapCheckoutUserBilling = 'checkout__infor__user__billing';
    var wrapCheckoutInfoProduct = 'checkout__inforpro';
    var stepCheckout = 'step-checkout';
    var btnBack = 'btn-back';
    var btnOrder = 'btn-order';
    var _indexStep = 1;

    $('.'+wrapCheckoutInfoProduct).on('click', '.btn-checkout', function(){
        var button = $(this);
        var stepActive = $('.'+stepCheckout+':not(.hide)');
        var stepTotal = $('.'+stepCheckout).length;

        if(button.hasClass(btnBack)){
            var stepFuture = stepActive.prev();
            _indexStep--;
        }else{
            var stepFuture = stepActive.next();
            _indexStep++;
        }
        if(_indexStep == 1){
            $('.'+btnBack).addClass('hide');
        }else{
            $('.'+btnBack).removeClass('hide');
        }
        $('.'+btnOrder).html(textButtonStep[_indexStep-1]);
        console.log(_indexStep);
        if(_indexStep > stepTotal){
            _indexStep--;
            console.log('Pay');
            var form = $('#orderForm').serialize();
            $('.'+wrapCheckoutUser).trigger('checkout/func/order', [form]);
        }else{
            stepFuture.removeClass('hide');
            stepActive.addClass('hide');

        }
        return false;
    });


    $('.'+wrapCheckoutUser).on('change', '.select-city, .select-district', function(){
        $(this).loading({inside_right: true});
        var timer = 0;
        var child = $(this).attr('data-child');
        var parent = $(this).parent().parent();
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
                    parent.find('.select-'+child).html(html);
                    $('body').loading({remove: true});
                }
            });
        }, 500);
        return false;
    });


    $('.'+wrapCheckoutUserShipping).bind('checkout/ui/autoFillBillingForm', function (event, data) {
        $('.'+wrapCheckoutUserShipping).on('keyup', 'input[name="shipping_name"]', function(){
            var checkSame = $('input[name="chk-same-info"]:checked').val();
            if(checkSame == 1) {
                var val = $('input[name="shipping_name"]').val();
                $('input[name="billing_name"]').val(val);
            }
        });
        $('.'+wrapCheckoutUserShipping).on('keyup', 'input[name="shipping_address"]', function(){
            var checkSame = $('input[name="chk-same-info"]:checked').val();
            if(checkSame == 1) {
                var val = $('input[name="shipping_address"]').val();
                $('input[name="billing_address"]').val(val);
            }
        });
        $('.'+wrapCheckoutUserShipping).on('keyup', 'input[name="shipping_phone"]', function(){
            var checkSame = $('input[name="chk-same-info"]:checked').val();
            if(checkSame == 1) {
                var val = $('input[name="shipping_phone"]').val();
                $('input[name="billing_phone"]').val(val);
            }
        });
        $('.'+wrapCheckoutUserShipping).on('change', 'select', function(){
            var checkSame = $('input[name="chk-same-info"]:checked').val();
            if(checkSame == 1) {
                var value = $(this).val();
                var clss = $(this).parent().attr('class').split(" ")[1];
                $('.' + wrapCheckoutUserBilling).find('.' + clss + ' select')
                    .val(value)
                    .trigger('change');
            }
        });
    });
    $('.'+wrapCheckoutUserShipping).trigger('checkout/ui/autoFillBillingForm');

    $('.'+wrapCheckoutUser).bind('checkout/func/order', function (event, form) {
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

    $('.'+wrapCheckoutInfoProduct).on('click', '.removeCart', function(){
        $(this).loading({inside_right: true});
        $(this).closest('tr').remove();
        var detail = $(this).closest('.checkout__inforpro-detail').attr('data-product-detail');
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

    $('.'+wrapCheckoutInfoProduct).on('change', '.quantity_select', function(){
        var detail = $(this).closest('.checkout__inforpro-detail').attr('data-product-detail');
        var quantity = $(this).val();
        console.log(detail);
        $('.'+wrapCheckoutUser).trigger('checkout/func/updateCart', [detail, quantity]);
    });

    $('.'+wrapCheckoutUser).bind('checkout/func/updateCart', function (event, detail, quantity) {
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
                                $('.' + wrapCheckoutInfoProduct).html(data.html);
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

