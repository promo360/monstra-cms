if (typeof $.promo == 'undefined') $.promo = {};

$.promo.users = {

    init: function() {
        this.usersFrontendRegistration();
    },

    usersFrontendRegistration: function() {
        $('#users_frontend_registration').on('ifChanged', function(event){
            $("form[name=users_frontend]").submit();
        });
    }

};

$(document).ready(function(){
    $.promo.users.init();
});