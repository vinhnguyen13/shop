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
        var childClass = $(this).attr('data-child');
        var parentObj = $(this).parent().parent();
        var idCurrent = $(this).val();
        $('.'+wrapCheckoutShipping).trigger('checkout/ui/selectLocation', [childClass, parentObj, idCurrent]);
        return false;
    });

    $('.'+wrapCheckoutShipping).bind('checkout/ui/selectLocation', function (event, childClass, parentObj, idCurrent, idActive) {
        var timer = 0;
        timer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: urlLocation,
                data: {id: idCurrent, child: childClass},
                success: function (data) {
                    var html = '';
                    $.each(data, function(key, value) {
                        var selected = '';
                        if(idActive && idActive == key){
                            selected = ' selected';
                        }
                        html +=
                            '<option value="'+key+'"'+selected+'>'
                            + value +
                            '</option>';
                    });
                    parentObj.find('.select-'+childClass).html(html);
                    $('body').loading({remove: true});
                    /*if(idChild){
                        parentObj.find('.select-'+childClass).val(idChild)
                            .trigger('change');
                    }*/
                }
            });
        }, 500);
    })

    $('.'+wrapCheckoutShipping).find('.find-customer input').autocomplete({
        source: function( request, response ) {
            var urlAjax = $('.'+wrapCheckoutShipping).find('.find-customer').attr('data-url-customers');
            var input = $('.'+wrapCheckoutShipping).find('.find-customer input').val();
            $.ajax({
                dataType: "json",
                type : 'post',
                url: urlAjax,
                data:{input: input},
                success: function(data) {
                    $('.'+wrapCheckoutShipping).find('.find-customer input').removeClass('ui-autocomplete-loading');
                    // hide loading image
                    response( $.map( data, function(text, key) {
                        return {
                            label: text,
                            value: text,
                            id: key
                        };
                        // your operation on data
                    }));
                },
                error: function(data) {
                    $('.'+wrapCheckoutShipping).find('.find-customer input').removeClass('ui-autocomplete-loading');
                }
            });
        },
        minLength: 3,
        open: function() {},
        close: function() {},
        focus: function(event,ui) {},
        select: function (event, ui)
        {
            var urlAjax = $('.'+wrapCheckoutShipping).find('.find-customer').attr('data-url-customer');
            var cid = ui.item ? ui.item.id : 0;
            if (cid > 0)
            {
                $.ajax({
                    dataType: "json",
                    type : 'post',
                    url: urlAjax,
                    data:{cid: cid},
                    success: function(data) {
                        console.log(data);
                        $('input[name="shipping_name"]').val(data.name);
                        $('input[name="billing_name"]').val(data.name);
                        $('input[name="shipping_address"]').val(data.address);
                        $('input[name="billing_address"]').val(data.address);
                        $('input[name="shipping_phone"]').val(data.phone);
                        $('input[name="billing_phone"]').val(data.phone);

                        $('.' + wrapCheckoutShipping).find('.same-city select')
                            .val(data.city_id)
                            .attr('selected');
                        $('.'+wrapCheckoutShipping).trigger('checkout/ui/selectLocation', ['district', $('.' + wrapCheckoutShipping), data.city_id, data.district_id]);
                        $('.'+wrapCheckoutShipping).trigger('checkout/ui/selectLocation', ['ward', $('.' + wrapCheckoutShipping), data.district_id, data.ward_id]);

                    },
                    error: function(data) {
                        $('.'+wrapCheckoutShipping).find('.find-customer input').removeClass('ui-autocomplete-loading');
                    }
                });
            }
        }
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

    // qty up down number
    $('.up__down--qty input[type=hidden]').each(function() {
        var _this = $(this),
            val = _this.val();
        _this.parent().find('.qty__val').html(val);
    });
    $('.'+wrapCheckoutInfoProduct).on('click', '.up__down--qty .qty__up', function(){
        var _this = $(this),
            valTxt = _this.parent().find('.qty__val'),
            valHidden = _this.parent().find('input[type=hidden]').val(),
            countUp = parseInt(valHidden) + 1;
        valTxt.html(countUp);
        _this.parent().find('input[type=hidden]').val(countUp);
        var product = $(this).closest('.checkout__inforpro-detail').attr('data-product');
        var size = $(this).closest('.checkout__inforpro-detail').attr('data-size');
        if(size && product){
            $('.'+wrapCheckoutInfoProduct).trigger('checkout/func/updateCart', [product, size, countUp]);
        }
    });
    $('.'+wrapCheckoutInfoProduct).on('click', '.up__down--qty .qty__down', function(){
        var _this = $(this),
            valTxt = _this.parent().find('.qty__val'),
            valHidden = _this.parent().find('input[type=hidden]').val(),
            countUp = parseInt(valHidden) - 1;
        if ( countUp < 0 ) return;
        valTxt.html(countUp);
        _this.parent().find('input[type=hidden]').val(countUp);
        var product = $(this).closest('.checkout__inforpro-detail').attr('data-product');
        var size = $(this).closest('.checkout__inforpro-detail').attr('data-size');
        if(size && product){
            $('.'+wrapCheckoutInfoProduct).trigger('checkout/func/updateCart', [product, size, countUp]);
        }
    });
});

