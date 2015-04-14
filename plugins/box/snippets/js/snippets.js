if (typeof $.promo == 'undefined') $.promo = {};

$.promo.snippets = {

    init: function() { },

    showEmbedCodes: function(name) {
        $('#shortcode').val('{snippet get="'+name+'"}');
        $('#phpcode').val('<?php echo Snippet::get("'+name+'"); ?>');
        $('#embedCodes').modal();
    }

};

$(document).ready(function(){
    $.promo.snippets.init();
});