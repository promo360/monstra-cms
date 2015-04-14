if (typeof $.promo == 'undefined') $.promo = {};

$.promo.plugins = {

    init: function(){
        if (window.location.hash && $('a[href="'+ window.location.hash +'"]')) {
            $('a[href="'+ window.location.hash +'"]').click();
        }
    }

};

$(document).ready(function(){
    $.promo.plugins.init();
});