/**
 * Novalnet Credit Card script
 * By Novalnet AG (https://www.novalnet.de)
 * Copyright (c) Novalnet AG
 */
 
$( document ).ready(function () {
    $('#button-confirm').on('click',function(event) {
        $('.alert-warning').remove();
        $('#error-msg').hide();
        $('#button-confirm').attr("disabled", true);

        if($('#cc-panhash').val() == '' && (($('#cc-shopping-type').val() == 'ONE_CLICK'  && $('#novalnet-cc-one-click-shopping').val() == 0) || $('#cc-shopping-type').val() == 'none' || $('#cc-shopping-type').val() == 'ZERO_AMOUNT')){
            event.preventDefault();
            event.stopImmediatePropagation();
            getCcPanhash();
        } else {
            confirm();
        }
    });

    $('#nn-new-card-link').bind('click', function(){
        $('#cc-masking-form').hide();
        $('#nn-cc-iframe').show();
        $('#novalnet-cc-one-click-shopping').val('0');
        loadCcIframe();
    });

    $('#nn-given-card-link').bind('click',function(){
        $('#cc-masking-form').show();
        $('#nn-cc-iframe').hide();
        $('#novalnet-cc-one-click-shopping').val(1);
        $('#given_card_details').hide();
    });
    eventListener();
});

function eventListener(){
    var iframe = document.getElementById('novalnet-iframe').contentWindow;
    var target_orgin = 'https://secure.novalnet.de';
    if(window.addEventListener) {
        window.addEventListener('message', function(e) {
            getEventDetails(e);
        }, false);
    } else {
        window.attachEvent('message', function(e) {
            getEventDetails(e);
        }, false);
    }
}

function getEventDetails(e){
    var target_orgin = 'https://secure.novalnet.de';
    var data = eval('(' + e.data + ')');
    if (e.origin === target_orgin) {
        if (data['error_message'] != undefined) {
            e.stopImmediatePropagation();
            alert(data['error_message']);
            $('#button-confirm').attr("disabled", false);
            return false;
        } else if (data['callBack'] == 'getHeight') {
            document.getElementById('novalnet-iframe').height = data['contentHeight'];
        } else if (data['callBack'] == 'getHash') {
            if($('#cc-panhash').val() == ''){
				$('#cc-panhash').val(data['hash']);
				$('#cc-unique-id').val(data['unique_id']);
				confirm();
				return true;
			}
        }
    }
}

function getCcPanhash(){
    var iframe = document.getElementById('novalnet-iframe').contentWindow;
    var target_orgin = 'https://secure.novalnet.de';
    iframe.postMessage({ callBack : 'getHash' }, target_orgin);
}

function loadCcIframe() {	
    if(($('#cc-shopping-type').val() == 'ONE_CLICK' && $('#novalnet-cc-one-click-shopping').val() == 0 ) || $('#cc-shopping-type').val() == 'none' || $('#cc-shopping-type').val() == 'ZERO_AMOUNT'){ 		
        var iframe = document.getElementById('novalnet-iframe').contentWindow;
        var target_orgin = 'https://secure.novalnet.de';
        var create_element_obj = {
            callBack : 'createElements',
            customText: {
                card_holder: {
                    labelText: jQuery('#text-cc-holder').val(),
                    inputText: jQuery('#text-cc-holder-placeholder').val(),
                },
                card_number: {
                    labelText: jQuery('#text-cc-number').val(),
                    inputText: jQuery('#text-cc-number-placeholder').val(),
                },
                expiry_date: {
                    labelText: jQuery('#text-cc-expiry-date').val(),
                    inputText: jQuery('#text-cc-date-placeholder').val(),
                },
                cvc: {
                    labelText: jQuery('#text-cc-cvc').val(),
                    inputText: jQuery('#text-cc-cvc-placeholder').val(),
                },
                cvcHintText: jQuery('#text-cc-cvc-hint').val(),
                errorText : jQuery('#text-cc-card-details-error').val()
            },
            customStyle : {
                labelStyle : jQuery('#cc-iframe-standard-label').val(),
                inputStyle : jQuery('#cc-iframe-standard-input').val(),
                styleText : jQuery('#cc-iframe-standard-css-text').val()
            },
        }
        iframe.postMessage(create_element_obj, target_orgin);
        var get_height_obj = { callBack : 'getHeight' }
        iframe.postMessage(get_height_obj, target_orgin);
    }
}
