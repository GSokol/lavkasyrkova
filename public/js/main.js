window.activeHover = [];
window.hoverInterval = null;
window.criticalResolution = 1024;
window.menuClickFlag = false;

$(window).ready(function () {
    $('.styled').uniform();
    $('a.img-preview').fancybox({padding: 3});

    window.phoneRegExp = /^((\+)[0-9]{11})$/gi;
    $('input[name=phone]').mask("+7(9nn)nnn-nn-nn");

    // Drop down menu
    // $('li.main-menu ul.dropdown-menu, .basket ul.dropdown-menu').bind('mouseleave', function () {
    //     $(this).hide();
    // });

    // Click hover zone and menu
    $('a[data-scroll]').click(function (e) {
        // e.preventDefault();
        // if ($(this).attr('data-type')) getCategory($(this));
        window.menuClickFlag = true;
        goToScroll($(this).attr('data-scroll'));
    });

    // Scroll controls
    // var onTopButton = $('#on-top-button');
    $(window).scroll(function() {
        if (!window.menuClickFlag) {
            var win = $(this);
            $('.cover').each(function () {
                var scrollData = $(this).attr('data-scroll-destination');
                if (!win.scrollTop()) {
                    resetColorHrefsMenu();
                } else if ($(this).offset().top <= win.scrollTop()+65 && scrollData) {
                    resetColorHrefsMenu();
                    $('a[data-scroll=' + scrollData + ']').addClass('active');
                }
            });
        }
    });

    $('.dropdown').click(function() {
        $(this).toggleClass('open');
    });

    // onTopButton.click(function() {
    //     goToScroll('home');
    // });

    // Hover text of free tastings
    $('#main-image a[href=#tasting]').bind('mouseover',function () {
        $(this).find('img').attr('src','/images/free_tastings_hover.png');
    }).bind('mouseout',function () {
        $(this).find('img').attr('src','/images/free_tastings.png');
    });

    mainImageHeight();
    // maxHeight('action-product',null);
    // maxHeight('product','action');
    // bindDropdownMenu();
    $(window).resize(function() {
        // mainImageHeight();
        // maxHeight('action-product',null);
        // maxHeight('product','action');
        // bindDropdownMenu();
    });

    // Owlcarousel
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        margin: 0,
        loop: true,
        nav: true,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: {
            100: {
                items: 1
            }
        }
    });

    if (window.showMessage) $('#message').modal('show');
});

function goToScroll(scrollData) {
    // resetColorHrefsMenu();
    // $('.main-menu > a[data-scroll=' + scrollData + ']').addClass('active');
    $('html,body').animate({
        scrollTop: $('[data-scroll-destination=' + scrollData + ']').offset().top - (scrollData == 'menu' ? 10000 : 65)
    }, 1000, 'easeInOutQuint', function () {
        window.menuClickFlag = false;
    });
}

function resetColorHrefsMenu() {
    $('.main-menu > a.active').removeClass('active').blur();
}

function mainImageHeight() {
    $('#main-image').css('height',$(window).height());
    $('.actions,.action').css('height',$(window).height());
}

function bindDropdownMenu() {
    var parentMenu = $('li.main-menu, .basket'),
        bindType = $(window).width() > 768 ? 'mouseover' : 'click';

    parentMenu.unbind();
    parentMenu.bind(bindType,function () {
        var dropDownMenu = $(this).find('ul.dropdown-menu');
        if (dropDownMenu.is(':visible') && bindType != 'mouseover') dropDownMenu.hide();
        else dropDownMenu.show();
    });
}
