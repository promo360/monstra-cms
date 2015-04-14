if (typeof $.promo == 'undefined') $.promo = {};

$.promo.blocks = {

    init: function() { },

    showEmbedCodes: function(name) {
        $('#shortcode').html('{block get="'+name+'"}');
        $('#phpcode').html('&lt;?php echo Block::get("'+name+'"); ?&gt;');
        $('#embedCodes').modal();
    }

};


$(document).ready(function(){
    $.promo.blocks.init();
});