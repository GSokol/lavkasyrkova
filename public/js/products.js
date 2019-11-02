$(window).ready(function () {
    // Click to category href
    $('.category').click(function () {
        getCategory($(this));
    });

    // Click back to categories
    var productsContainer = $('#products');
    productsContainer.find('.back-to-categories > div').click(function () {
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
                emptyBasket();
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

    // Click to buy action product
    $('.action-product button').click(function () {
        var id = $(this).attr('data-id');
        $.post('/get-product', {
            '_token':$('input[name=_token]').val(),
            'id':id
        }, function (data) {
            if (data.success) {
                var modal = $('#product-modal');
                modal.find('.modal-body').html(data.product);
                modal.modal('show');

                bindValueInputsControl();
                bindProductsValueInputControl();
            }
        });
    });

    bindProductsValueInputControl();
});

function bindProductsValueInputControl() {
    var input = $('.input-value-container input'),
        deleteFromBasket = $('.basket-product .product-delete');

    input.unbind('change.val');
    input.unbind('change.first');
    deleteFromBasket.unbind('click');

    input.bind('change.first', function () {
        var basketNotice = $('<div></div>').attr('id','basket-notice').css('margin-top',($(window).height()/2)+$(window).scrollTop());
        $('body').prepend(basketNotice);
        basketNotice.animate({
            'width':200,
            'height':200,
            'font-size':100,
            'opacity':0
        },1500,function () {
            $(this).remove();
        });
    });

    input.bind('change.val', function (event,value,unit,id) {
        changeProductValue(id,value,unit);
    });

    deleteFromBasket.bind('click',function () {
        var parent = $(this).parents('.basket-product'),
            unit = parent.find('input').attr('data-unit'),
            id = input.attr('name').replace('product_','');

        changeProductValue(id,0,unit);
    });
}

function emptyBasket() {
    $('#order-content').html('');
    $('.total-cost-basket > span').html('0р.');
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
                // maxHeight('product','action');

                bindValueInputsControl();
                bindProductsValueInputControl();
            });
        }
    });
}

function clearErrors() {
    var errorContainer = $('#checkout-modal div.error');
    errorContainer.css('display','none').html('');
}

function changeProductValue(id,value,unit) {
    $.post('/basket', {
        '_token':$('input[name=_token]').val(),
        'id':id,
        'value':value
    }, function (data) {
        if (data.success) {
            var basketItem = $('#basket-product-'+id);

            $('input[name=product_'+id+']').val(value+' '+unit);
            $('.product-'+id+' .cost > p, .product-'+id+' .product-cost').html(data.cost+'р.');
            $('.total-cost-basket > span').html(data.total+'р.');

            // Add or remove value-input in basket modal
            if (basketItem.length) {
                if (data.product) basketItem.html(data.product);
                else basketItem.remove();
            } else {
                $('#order-content').append(
                    $('<div class="product-basket"></div>').attr('id','basket-product-'+id).html(data.product)
                );
            }
            bindValueInputsControl();
            bindProductsValueInputControl();
        }
    });
}