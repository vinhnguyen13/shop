$(document).ready(function(){
    var wrapCheckoutUser = 'checkout__infor__user';
    var wrapCheckoutShipping = 'checkout__infor__shipping';
    var wrapCheckout = 'wrap-checkout';
    var wrapCheckoutUserShipping = 'checkout__infor__user__shipping';
    var wrapCheckoutUserBilling = 'checkout__infor__user__billing';
    var wrapCheckoutInfoProduct = 'checkout__inforpro';
    var stepCheckout = 'step-checkout';

    $('.'+stepCheckout+':first').removeClass('hide');

    $('.'+wrapCheckout).on('click', 'input[name="user-exist"]', function(){
        var userExist = $(this).val();
        if(userExist == 1){
            $('input[name="password"]').removeAttr('disabled');
        }else{
            $('input[name="password"]').attr('disabled', 'disabled');
        }
    });

    $('.'+wrapCheckoutShipping).on('change', '.select-city, .select-district', function(){
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


    $('.'+wrapCheckoutInfoProduct).on('click', '.removeCart', function(){
        $(this).loading({inside_right: true});
        $(this).closest('tr').remove();
        var product = $(this).closest('.checkout__inforpro-detail').attr('data-product');
        var size = $(this).closest('.checkout__inforpro-detail').attr('data-size');
        if(size && product){
            var timer = 0;
            timer = setTimeout(function () {
                $.ajax({
                    type: "post",
                    url: urlRemoveCart,
                    data: {product: product, size: size},
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
        var product = $(this).closest('.checkout__inforpro-detail').attr('data-product');
        var size = $(this).closest('.checkout__inforpro-detail').attr('data-size');
        var quantity = $(this).val();
        console.log(product, size);
        if(size && product){
            $('.'+wrapCheckoutInfoProduct).trigger('checkout/func/updateCart', [product, size, quantity]);
        }
    });

    $('.'+wrapCheckoutInfoProduct).bind('checkout/func/updateCart', function (event, product, size, quantity) {
        $(this).loading({inside_right: true});
        var timer = 0;
        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlAddCart,
                data: {product: product, size: size, quantity: quantity},
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

