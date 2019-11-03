$(window).ready(function () {
    $('.input-value-container input').focus(function () {
        $(this).blur();
    });

    // Bind inputs control
    bindValueInputsControl();
});

function bindValueInputsControl() {
    var inputsButton = $('.input-value-container .button');
    
    inputsButton.unbind('click');
    inputsButton.bind('click',function () {
        var type = $(this).hasClass('plus'),
            input = $(this).parents('.input-value-container').find('input'),
            unit = input.attr('data-unit'),
            id = input.attr('name').replace('product_',''),
            value = getInputValue(input.val(),unit),
            differentially = parseInt(input.attr('data-differentially')),
            increment = input.attr('data-increment'),
            minVal = parseFloat(input.attr('min')),
            maxVal = parseInt(input.attr('max'));

        increment = differentially ? jQuery.parseJSON(increment) : parseInt(increment);

        // First increment
        if (!value) input.trigger('change.first');
        
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
        }

        // input.val(value+' '+unit);
        input.trigger('change.val',[value,unit,id]);
    });
}

function getInputValue(value,unit) {
    return parseFloat(value.replace(' ','').replace(unit,'').replace(',','.'));
}