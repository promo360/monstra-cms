if (typeof $.promo == 'undefined') $.promo = {};

$.promo.snippets = {

    init: function() { },

    showEmbedCodes: function(name) {
        $('#shortcode').html('{snippet get="'+name+'"}');
        $('#phpcode').html('&lt;?php echo Snippet::get("'+name+'"); ?&gt;');
        $('#embedCodes').modal();
    }

};


$(document).ready(function(){
    $.promo.snippets.init();
});