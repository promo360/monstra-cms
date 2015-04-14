if (typeof $.promo == 'undefined') $.promo = {};

$.promo.blocks = {

    init: function() { },

    showEmbedCodes: function(name) {
        $('#shortcode').val('{block get="'+name+'"}');
        $('#phpcode').val('<?php echo Block::get("'+name+'"); ?>');
        $('#embedCodes').modal();
    }

};


$(document).ready(function(){
    $.promo.blocks.init();
});