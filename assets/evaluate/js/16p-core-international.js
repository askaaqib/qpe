var $j = jQuery.noConflict();

$j(document).ready(function() {

    $j(window).resize(function () {

        if ($j('#mobile-navigation').is(':visible')) {
            $j('#mobile-menu-switch').click();
        }

    });

});

// Mobile menus

$j('#mobile-menu-switch').click(function () {

    if (!$j('#mobile-navigation').is(':visible')) {

        var navOffset = $j('.navigation').height() + 26;

        $j('#mobile-navigation')
            .css('top', navOffset)
            .css('height', $j(window).height() - navOffset);
        $j('body').css('overflow', 'hidden');

    } else {

        $j('body').css('overflow', 'auto');

    }

    $j('#mobile-navigation').toggle();
    $j('#mobile-menu-switch').toggleClass('active');
    $j('.navbar').toggleClass('menu-mode');
    return false;


});

$j('.navbar').click(function (e) {

    var target = $j(e.target);
    if ($j('#mobile-navigation').is(':visible') && $j(target).closest('#mobile-menu-switch').length == 0 && $j(target).closest('#mobile-navigation').length == 0) {
        $j('#mobile-menu-switch').click();
    }

});