/**
 * Novalnet Credit Card script
 * By Novalnet AG (https://www.novalnet.de)
 * Copyright (c) Novalnet AG
 */
 
jQuery( document ).ready(function () {
	var script = "";
	var nn_Util = 'novalnet_util';
	if(!document.getElementById(nn_Util)) {
		script = document.createElement("script");
		script.type = "text/javascript";
		script.id = nn_Util;
		script.src = "https://cdn.novalnet.de/js/v2/NovalnetUtility.js";
		document.getElementsByTagName("head")[0].appendChild(script);
	}
	script.onload = function () {
		loadCcIframe();
	}
    jQuery('#button-confirm').on('click',function(event) {
        jQuery('.alert-warning').remove();
        jQuery('#error-msg').hide();
        jQuery('#button-confirm').attr("disabled", true);
        if (jQuery('#cc-panhash').val()) {
			jQuery('#cc-panhash').val('');
		}

        if(jQuery('#cc-panhash').val() == '' && ((jQuery('#cc-shopping-type').val() == 'ONE_CLICK'  && jQuery('#novalnet-cc-one-click-shopping').val() == 0) || jQuery('#cc-shopping-type').val() == 'none' || jQuery('#cc-shopping-type').val() == 'ZERO_AMOUNT')){
            event.preventDefault();
            event.stopImmediatePropagation();
            NovalnetUtility.getPanHash();
        } else {
            confirm();
        }
    });

    jQuery('#nn-new-card-link').bind('click', function(){
        jQuery('#cc-masking-form').hide();
        jQuery('#nn-cc-iframe').show();
        jQuery('#novalnet-cc-one-click-shopping').val('0');
        loadCcIframe();
    });

    jQuery('#nn-given-card-link').bind('click',function(){
        jQuery('#cc-masking-form').show();
        jQuery('#nn-cc-iframe').hide();
        jQuery('#novalnet-cc-one-click-shopping').val(1);
        jQuery('#given_card_details').hide();
    });
});

function loadCcIframe() {	
    if((jQuery('#cc-shopping-type').val() == 'ONE_CLICK' && jQuery('#novalnet-cc-one-click-shopping').val() == 0 ) || jQuery('#cc-shopping-type').val() == 'none' || jQuery('#cc-shopping-type').val() == 'ZERO_AMOUNT'){

        NovalnetUtility.setClientKey(jQuery('#nn-client-key').val());

        var configurationObject = {
            callback : {

                // Called once the pan_hash (temp. token) created successfully.
                on_success: function (data) {
                    jQuery('#cc-panhash').val(data ['hash'] );
                    jQuery('#cc-unique-id').val(data['unique_id']);
                    jQuery('#cc-do-redirect').val(data['do_redirect']);
                    confirm();
                    return true;
                },
                on_error:  function (data) {					
                    if ( undefined !== data['error_message'] ) {
						jQuery('#button-confirm').attr("disabled", false);
                        confirm();
						return false;
                    }
                },
                on_show_overlay:  function (data) {
                    document.getElementById('novalnet-iframe').classList.add("novalnet-challenge-window-overlay");
                },
                on_hide_overlay:  function (data) {
                    document.getElementById('novalnet-iframe').classList.remove("novalnet-challenge-window-overlay");
                }

            },
            iframe: {
                id: "novalnet-iframe",
                inline: 0,
                style: {
                    container: jQuery('#cc-iframe-standard-css-text').val(),
                    input: jQuery('#cc-iframe-standard-input').val(),
                    label: jQuery('#cc-iframe-standard-label').val(),
                },
                text: {
                    error: jQuery('#text-cc-card-details-error').val(),
                    card_holder : {
                        label: jQuery('#text-cc-holder').val(),
                        place_holder: jQuery('#text-cc-holder-placeholder').val(),
                        error: "Please enter the valid card holder name"
                    },
                    card_number : {
                        label: jQuery('#text-cc-number').val(),
                        place_holder: jQuery('#text-cc-number-placeholder').val(),
                        error: "Please enter the valid card number"
                    },
                    expiry_date : {
                        label: jQuery('#text-cc-expiry-date').val(),
                        place_holder: jQuery('#text-cc-date-placeholder').val(),
                        error: "Please enter the valid expiry month / year in the given format"
                    },
                    cvc : {
                        label: jQuery('#text-cc-cvc').val(),
                        place_holder: jQuery('#text-cc-cvc-placeholder').val(),
                        error: "Please enter the valid CVC/CVV/CID"
                    }
                }
            },
            customer: {
                first_name: jQuery("#nn-first-name").val(),
                last_name: jQuery("#nn-last-name").val(),
                email: jQuery("#nn-email").val(),
                billing: {
                    street: jQuery("#nn-billing-street").val(),
                    city: jQuery("#nn-billing-city").val(),
                    zip: jQuery("#nn-billing-zip").val(),
                    country_code: jQuery("#nn-billing-country-code").val()
                },
            },
            transaction: {
                amount: jQuery("#transaction-amount").val(),
                currency: jQuery("#shop-currency").val(),
                test_mode: jQuery("#nn-test-mode").val(),
                enforce_3d: jQuery("#nn-enforce-3d").val() 
            },
            custom: {
                lang : jQuery('#shop-lang').val(),
            }
        };
        // Create the Credit Card form
        NovalnetUtility.createCreditCardForm(configurationObject);
    }
}
