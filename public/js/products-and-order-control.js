$(window).ready(function () {
    $('.input-value-container input').focus(function () {
        $(this).blur();
    });

    // Click to category href
    $('.category').click(function () {
            getCategory($(this));
    });

    // Click back to categories
    var productsContainer = $('#products');
    productsContainer.find('button').click(function () {
        productsContainer.fadeOut('fast',function () {
            $('.order-form').html('');
            $('#cheeses-sub-head').html('');
            $('#cheeses-head').fadeIn('fast');
            $('#categories').fadeIn('fast',function () {
                goToScroll('cheeses');
            });
        });
    });
    
    // Click checkout order
    $('button#checkout').click(
        function (e) {
            e.preventDefault();

            clearErrors();
            $('#checkout-modal').modal('show');
            addLoaderScreen();

            $.post('/checkout-order', {
                '_token': $('input[name=_token]').val(),
                'delivery': $('input[name=delivery]:checked').val(),
                'shop_id': $('input[name=shop_id]:checked').val(),
                'address': $('input[name=address]').val()
            }, function (data) {
                removeLoaderScreen();
                if (data.success) {
                    orderComplete(data);
                } else {
                    var errorContainer = $('#checkout-modal div.error');
                    errorContainer.css('display','table');
                    $.each(data.errors, function (k,message) {
                        errorContainer.append(
                            $('<div></div>').html(message)
                        );
                    });
                }
            });
        }
    );
    
    // Click empty basket
    $('a#empty-basket').click(function (e) {
        e.preventDefault();
        
        $.post('/empty-basket', {
            '_token': $('input[name=_token]').val()
        }, function (data) {
            if (data.success) {
                emptyBasket(usingBasketFlag);
            }
        });
    });

    // Click to delivery radio
    $('input[name=delivery]').change(function () {
        clearErrors();

        var shopsBlock = $('.shops-block'),
            addressBlock = $('.address-block');
        
        if ($(this).val() == 1) {
            shopsBlock.hide();
            addressBlock.hide();
        } else if ($(this).val() == 2) {
            shopsBlock.show();
            addressBlock.hide();
        } else {
            shopsBlock.hide();
            addressBlock.show();
        }
    });
});

function bindValueInputsControl(usingBasketFlag) {
    var inputsButton = $('.input-value-container .button');
    inputsButton.unbind('click');
    inputsButton.bind('click',function () {
        var parent = $(this).parents('.input-value-container'),
            type = $(this).hasClass('plus'),
            input = parent.find('input'),
            productId = input.attr('name').replace('product_',''),
            product = $('.product-'+productId),
            productBasket = $(this).parents('.product-basket'),
            unit = input.attr('data-unit'),
            value = parseInt(input.val().replace(' ','').replace(unit,'')),
            differentially = parseInt(input.attr('data-differentially')),
            price = parseInt(input.attr('data-price')),
            increment = input.attr('data-increment'),
            minVal = parseInt(input.attr('min')),
            maxVal = parseInt(input.attr('max'));

        increment = differentially ? jQuery.parseJSON(increment) : parseInt(increment);

        if (type && value < maxVal) {
            if (differentially) {
                if (value < increment[increment.length-1]) {
                    for (var i=0;i<increment.length;i++) {
                        if (increment[i] > value) {
                            value = increment[i];
                            break;
                        }
                    }
                }
            } else {
                value = value + increment;
            }
        } else if (!type && value > minVal) {
            if (differentially) {
                var newVal = 0;
                for (i=increment.length-1;i>=0;i--) {
                    if (increment[i] < value) {
                        newVal = increment[i];
                        break;
                    }
                }
                value = newVal;
            } else {
                value = value - increment;
            }
        } else {
            usingBasketFlag = false;
        }

        if ((product.length || productBasket.length) && price && usingBasketFlag) {
            changeProductValue(productId,value,unit);
        } else {
            input.val(value+' '+unit);
        }
    });
}

function emptyBasket() {
    $('#order-content').html('');
    $('#total-cost, .total-cost-basket > span').html('0р.');
    $('.product').each(function () {
        var input = $(this).find('input');
        input.val('0 '+input.attr('data-unit'));
        $(this).find('p.cost').html('0р.');
    });
    $('.total-cost > span').html('0р.');
}

function orderComplete(data) {
    removeLoaderScreen();
    if (data.success) {
        $('#checkout-modal').modal('hide');
        emptyBasket();
    }
    showMessage(data.message);
}

function getCategory(obj) {
    var id = obj.attr('data-id'),
        type = obj.attr('data-type');

    $.post('/get-category-products', {
        '_token': $('input[name=_token]').val(),
        'id':id,
        'type':type
    }, function (data) {
        if (data.success) {
            $('#cheeses-sub-head').html(data.head);
            $('.order-form').html(data.products);
            $('#cheeses-head').fadeOut('fast');
            $('#categories').fadeOut('fast',function () {
                $('#products').fadeIn('fast');
                maxHeight('product','action');
                bindValueInputsControl(true);
            });
        }
    });
}

function clearErrors() {
    var errorContainer = $('#checkout-modal div.error');
    errorContainer.css('display','none').html('');
}

function changeProductValue(productId,value,unit) {
    $.post('/basket', {
        '_token': $('input[name=_token]').val(),
        'id': productId,
        'value':value
    }, function (data) {
        if (data.success) {
            var totalCost = data.total,
                basketItem = $('#basket-product-'+productId);

            $('input[name=product_'+productId+']').val(value+' '+unit);
            $('product-'+productId).find('.cost > p').html(data.cost+'р.');
            $('.total-cost-basket > span').html(totalCost+'р.');
            $('#total-cost').html(totalCost+'р.');

            if (basketItem.length) {
                if (data.product) basketItem.html(data.product);
                else basketItem.remove();
            } else {
                $('#order-content').append(
                    $('<div class="product-basket"></div>').attr('id','basket-product-'+productId).html(data.product)
                );
            }
            bindValueInputsControl(true);
        }
    });
}