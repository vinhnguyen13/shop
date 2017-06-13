$(document).ready(function() {
    var wrapFilterResult = 'filter__result';
    var wrapFilter = 'filter__shop';

    $('.filter__item .dropdown').dropdown({
        selectedValue: true
    });

    $('.'+wrapFilter).find('.searchProduct input').autocomplete({
        source: function( request, response ) {
            var urlAjax = $('.'+wrapFilter).find('.searchProduct').attr('data-url-products');
            var input = $('.'+wrapFilter).find('.searchProduct input').val();
            $.ajax({
                dataType: "json",
                type : 'post',
                url: urlAjax,
                data:{input: input},
                success: function(data) {
                    $('.'+wrapFilter).find('.searchProduct input').removeClass('ui-autocomplete-loading');
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
                    $('.'+wrapFilter).find('.searchProduct input').removeClass('ui-autocomplete-loading');
                }
            });
        },
        minLength: 3,
        open: function() {},
        close: function() {},
        focus: function(event,ui) {},
        select: function (event, ui)
        {
            var urlAjax = $('.'+wrapFilter).find('.searchProduct').attr('data-url-product');
            var pid = ui.item ? ui.item.id : 0;
            if (pid > 0)
            {
                $.ajax({
                    dataType: "json",
                    type : 'post',
                    url: urlAjax,
                    data:{pid: pid},
                    success: function(data) {

                    },
                    error: function(data) {
                        $('.'+wrapFilter).find('.searchProduct input').removeClass('ui-autocomplete-loading');
                    }
                });
            }
        }
    });

    $('.'+wrapFilterResult).bind('checkout/func/updateCart', function (event, product, size, quantity) {
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
                    $('.header__cart .val-selected').trigger('click');
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
    $('.up__down--qty .qty__up').on('click', function() {
        var _this = $(this),
            valTxt = _this.parent().find('.qty__val'),
            valHidden = _this.parent().find('input[type=hidden]').val(),
            countUp = parseInt(valHidden) + 1;
        valTxt.html(countUp);
        _this.parent().find('input[type=hidden]').val(countUp);
        var product = $(this).closest('.checkout__inforpro-detail').attr('data-product');
        var size = $(this).closest('.checkout__inforpro-detail').attr('data-size');
        if(size && product){
            console.log(countUp);
            $('.'+wrapFilterResult).trigger('checkout/func/updateCart', [product, size, countUp]);
        }
    });
    $('.up__down--qty .qty__down').on('click', function() {
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
            console.log(countUp);
            $('.'+wrapFilterResult).trigger('checkout/func/updateCart', [product, size, countUp]);
        }
    });

    $('.filter__item--btn').on('click', '.btn-apply', function(){
        var form = $('.frm-filter').serialize();
        console.log(form);
        return false;
    });
});