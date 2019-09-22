function addLoaderScreen() {
    $('body').css('overflow','visible').append(
        $('<div></div>').attr('id','loader-screen').append(
            $('<img>').attr('src','/images/loader.gif')
        )
    );
}

function removeLoaderScreen() {
    $('body').css('overflow','auto');
    $('#loader-screen').remove();
}