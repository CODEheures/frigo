$(document).ready(function () {
    //parametres de l'application
    var $minWebWidth = 300;
    var $ratioFontSizeBody = 0.187;
    var $ratioHeightWidth = 1.66;
    var $ratioZoom = 1.1;
    var $container = $('.container');


    function adaptWidth($newWidth) {
        //execution limité par le CSS maxwidth = 100%
        $container.css({
            width: $newWidth + 'px'
        });
        localStorage.setItem('frigoWidth', $newWidth);
        adaptBodyFontSize();
    }

    function adaptBodyFontSize() {
        var $ratioBodyFontSize = $container.width() * $ratioFontSizeBody;
        $('html').css('font-size', $ratioBodyFontSize + '%');
    }

    function initAppWidth() {
        //Test du media query
        if (!window.matchMedia("only screen and (max-device-width: 480px) and (orientation: portrait)").matches) {
            //ICI: si pas smartphone
            //Si le localstorage 'frigoWidth' est null on le SET avec la valeur du CSS
            if (localStorage.getItem('frigoWidth') == null) {
                localStorage.setItem('frigoWidth', $container.width());
            }

            //Get du localstorage
            var $initWebWidth = localStorage.getItem('frigoWidth');

            //Si le initWebWidth*1.66 est plus haut que la page on ne l'utilise pas, on
            // recalcul le iniWebWidth pour que l'appli prenne toute la hauteur
            if ($initWebWidth * $ratioHeightWidth > $(window).height()) {
                $initWebWidth = $(window).height() / $ratioHeightWidth;
                localStorage.setItem('frigoWidth', $initWebWidth);
            }

            //Si le width est en dessous du mini et que la hauteur de la fenetre permet de revenir au minimum
            // alors on impose ce mini
            if ($initWebWidth < $minWebWidth && $initWebWidth * $ratioHeightWidth < $(window).height()) {
                $initWebWidth = $(window).height() / $ratioHeightWidth;
                localStorage.setItem('frigoWidth', $initWebWidth);
            }

            //assignation
            $container.css({
                width: $initWebWidth + 'px'
            });
        } else {
            //ICI: si c'est un smartphone
            $container.css({
                width: '100%'
            })
        }
        adaptBodyFontSize();
    }


    //Document Ready executions
    $('#date').combodate();
    initAppWidth();


    //On-Click Functions
    $('.icon-zoom-in').on('click', function () {
        //execution limitée si le height depasse la taille de fenetre
        var $newWidth = $container.width() * $ratioZoom;
        if ($newWidth > $(window).height()/$ratioHeightWidth) {
            $newWidth = $(window).height()/$ratioHeightWidth;
        }
        adaptWidth($newWidth);
    });

    $('.icon-zoom-out').on('click', function () {
        //execution limitée au param $minWebWidth
        if ($container.width() > $minWebWidth) {
            var $newWidth = $container.width() / $ratioZoom;
            if($newWidth<$minWebWidth){
                $newWidth=$minWebWidth;
            }
            adaptWidth($newWidth);
        }
    });

    $('.hamburger').on('click', function () {
        $main = $('section.main');
        $menu = $('nav.menu-list');

        if ($menu.hasClass('hide')) {
            $menu.toggleClass('hide');
            $main.animate({
                width: '65%'
            });
        } else {
            $menu.toggleClass('hide');
            $main.animate({
                width: '100%'
            });
        }

    });

    $(window).on('resize', function(){
        initAppWidth();
    });

});