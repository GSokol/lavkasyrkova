window.activeHover = [];
window.hoverInterval = null;
window.criticalResolution = 1024;
window.menuClickFlag = false;

$(window).ready(function () {
    $('.styled').uniform();
    $('a.img-preview').fancybox({padding: 3});

    window.phoneRegExp = /^((\+)[0-9]{11})$/gi;
    $('input[name=phone]').mask("+7(999)999-99-99");
    
    var sr = ScrollReveal();
    sr.reveal('.navbar-default', {duration:1000});
    // sr.reveal('#main-image', {duration:2000});
    sr.reveal('.cover', {duration:2000});
    // sr.reveal('.product', {duration:2500});
    sr.reveal('.tasting', {duration:5000});
    
    // Drop down menu
    $('li.main-menu, .basket').bind('mouseover',function () {
        var dropDownMenu = $(this).find('ul.dropdown-menu');
        dropDownMenu.show();
        dropDownMenu.bind('mouseleave',function () {
            dropDownMenu.hide();
        })
    });

    // Click hover zone and menu
    $('a[data-scroll]').click(function (e) {
        e.preventDefault();
        window.menuClickFlag = true;
        goToScroll($(this).attr('data-scroll'));
    });
    
    // On-top button controls
    var onTopButton = $('#on-top-button');
    $(window).scroll(function() {
        if (!window.menuClickFlag) {
            var win = $(this);
            $('.cover').each(function () {
                var scrollData = $(this).attr('data-scroll-destination');
                if (!win.scrollTop()) {
                    resetColorHrefsMenu();
                } else if ($(this).offset().top <= win.scrollTop() && scrollData) {
                    resetColorHrefsMenu();
                    $('a[data-scroll=' + scrollData + ']').addClass('active');
                }
            });
        }

        if ($(window).scrollTop() > $(window).height()) onTopButton.fadeIn();
        else onTopButton.fadeOut();
    });

    onTopButton.click(function() {
        goToScroll('home');
    });

    // Click to signing tasting
    $('a#get-tasting').click(function (e) {
        e.preventDefault();
        $.post('/profile/signing-tasting', {
            '_token': $('input[name=_token]').val()
        }, function (data) {
            $('#get-tasting').remove();
            showMessage(data.message);
        });
    });
    
    // Hover text of free tastings
    $('#main-image a[href=#tasting]').bind('mouseover',function () {
        $(this).find('img').attr('src','/images/free_tastings_hover.png');
    }).bind('mouseout',function () {
        $(this).find('img').attr('src','/images/free_tastings.png');
    });

    // Bind inputs control
    bindValueInputsControl(true);

    mainImageHeight();
    maxHeight('action-product',null);
    maxHeight('product','action');
    $(window).resize(function() {
        mainImageHeight();
        maxHeight('action-product',null);
        maxHeight('product','action');
    });

    // Owlcarousel
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        margin: 10,
        loop: true,
        nav: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });
});

function goToScroll(scrollData) {
    resetColorHrefsMenu();
    $('.main-menu > a[data-scroll=' + scrollData + ']').addClass('active');
    $('html,body').animate({
        scrollTop: $('div[data-scroll-destination=' + scrollData + ']').offset().top - (scrollData == 'home' ? 0 : 62)
    }, 1000, 'easeInOutQuint', function () {
        window.menuClickFlag = false;
    });
}

function resetColorHrefsMenu() {
    $('.main-menu > a.active').removeClass('active').blur();
}

function mainImageHeight() {
    $('#main-image').css('height',$(window).height());
    $('.map').css('height',$(window).height()/1.5);

    var basket = $('.basket'),
        basketContainer = basket.parents('.container');

    basket.css('margin-left',basketContainer.width()-basket.width());

}

function tolocalstring(string, unit) {
    return string.toLocaleString().replace(/\,/g, ' ')+' '+unit;
}

function maxHeight(className,exceptClassName) {
    var maxHeight = 0,
        objects = $('.'+className);

    objects.each(function () {
        if ($(this).height() > maxHeight) maxHeight = $(this).height();
    });
    objects.not('.'+exceptClassName).css('height',maxHeight);
}