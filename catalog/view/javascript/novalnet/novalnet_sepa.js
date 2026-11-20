/**
 * Novalnet Direct Debit SEPA script
 * By Novalnet AG (https://www.novalnet.de)
 * Copyright (c) Novalnet AG
 */
 
$(document).ready(function(){
    $("#button-confirm").click(function(){
        var account_holder = remove_space(jQuery('#input-novalnet-sepa-holder').val());
        var iban = jQuery.trim(jQuery('#input-novalnet-sepa-account-no').val()).replace(/[^a-z0-9]+/gi, '');
        var one_click = remove_space(jQuery('#novalnet-sepa-one-click-shopping').val());
        if ((account_holder.length == 0 || iban.length == 0) && one_click == 0) {
        alert(jQuery('#novalnet-sepa-account-error').val());
        return false;
    }

    });
});

function sepa_validation(event) {
    var keycode = ('which' in event) ? event.which : event.keyCode;
    var reg = /^(?:[A-Za-z0-9]+$)/;
    if (event.target.id == 'input-novalnet-sepa-holder')
        reg = /[^0-9\[\]\/\\#,+@!^()$~%'"=:;<>{}\_\|*?`]/g;
    if (event.target.id == 'input-novalnet-sepa-account-no')
        reg = /^(?:[A-Za-z0-9]+$)/;
    return (reg.test(String.fromCharCode(keycode)) || keycode === 0 || keycode === 8) ? true : false;
}

function remove_space(input_val) {
    return input_val.trim();
}
