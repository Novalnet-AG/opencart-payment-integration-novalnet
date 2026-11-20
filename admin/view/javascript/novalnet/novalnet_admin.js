/**
 * Novalnet global configuration script
 * By Novalnet AG (https://www.novalnet.de)
 * Copyright (c) Novalnet AG
 */
jQuery(document).ready(function() {
    fill_novalnet_details();
    jQuery("#input-payment-novalnet-public-key").on("blur", function() {
        fill_novalnet_details();
        if ("" === jQuery("#input-payment-novalnet-public-key").val())
            null_basic_params();
    });
});

function null_basic_params() {
    jQuery("#input-novalnet-merchant-id, #input-novalnet-authcode, #input-novalnet-project-id, #input-novalnet-access-key, #input-payment-novalnet-public-key").val("");
    jQuery("#input-payment-novalnet-tariff-id").find("option").remove();
    jQuery("#input-payment-novalnet-tariff-id").append(jQuery("<option>", {
        value: '',
        text: '',
    }));
}

function fill_novalnet_details() {
    if (jQuery("#input-payment-novalnet-public-key").val() === undefined || jQuery("#input-payment-novalnet-public-key").val() === '')
        return false;
    if ("" !== jQuery.trim(jQuery("#input-payment-novalnet-public-key").val()) && "" !== jQuery("#server_ip").val()) {
        return novalnet_ajax_call({
            system_ip: jQuery("#server_ip").val(),
            remote_ip: jQuery("#remote_ip").val(),
            api_config_hash: jQuery.trim(jQuery("#input-payment-novalnet-public-key").val()),
            lang: jQuery("#nn_language").val()
        }, "https://payport.novalnet.de/autoconfig");
    } else {
        alert(jQuery("#error_mandatory_fields").val());
        null_basic_params();
        return false;
    }
}

function novalnet_ajax_call(url_data, config_url) {
    if ("XDomainRequest" in window && null !== window.XDomainRequest) {
        var data = jQuery.param(url_data);
        var xdr = new XDomainRequest();
        xdr.open("POST", config_url);
        xdr.onload = function() {
            return get_config_hash_response(this.responseText);
        };
        xdr.send(data);
    } else jQuery.ajax({
        type: "POST",
        url: config_url,
        data: url_data,
        success: function(response) {
            return get_config_hash_response(response);
        }
    });
}

function get_config_hash_response(response) {
    var selected_value = jQuery("#input-payment-novalnet-tariff-id").val();
    jQuery("#input-payment-novalnet-tariff-id").replaceWith('<select id="input-payment-novalnet-tariff-id" name= "payment_novalnet_tariff_id" class="form-control"></select>');
    if (void 0 !== response.config_result && "" !== response.config_result) {
        alert(response.config_result);
        null_basic_params();
        return false;
    }
    var tariff_id = response.tariff_id.split(",");
    var tariff_name = response.tariff_name.split(",");
    var tariff_type = response.tariff_type.split(",");
    for (var f = 0; f < tariff_id.length; f++) {
        var hash_string_tarrif_id = tariff_id[f].split(":");
        var hash_string_tarrif_name = tariff_name[f].split(":");
        var hash_string_tarrif_type = tariff_type[f].split(":");
        var hash_result_name = void 0 !== hash_string_tarrif_name["2"] ? hash_string_tarrif_name["1"] + ":" + hash_string_tarrif_name["2"] : hash_string_tarrif_name["1"];
        var tariff_val = jQuery.trim(jQuery.trim(hash_string_tarrif_id["1"]) + "-" + jQuery.trim(hash_string_tarrif_type["1"]));
        jQuery("#input-payment-novalnet-tariff-id").append(jQuery("<option>", {
            value: tariff_val,
            text: jQuery.trim(hash_result_name)
        }));
        if (selected_value != null && selected_value != undefined && selected_value == tariff_val) {
            jQuery("#input-payment-novalnet-tariff-id").val(selected_value).attr("selected", "selected");
        }
    }
    jQuery("#ajax_complete").val('true');
    jQuery("#input-payment-novalnet-merchant-id").val(response.vendor_id);
    jQuery("#input-payment-novalnet-authcode").val(response.auth_code);
    jQuery("#input-payment-novalnet-project-id").val(response.product_id);
    jQuery("#input-payment-novalnet-access-key").val(response.access_key);
    jQuery("#input-payment-novalnet-client-key").val(response.client_key);
    return true;
}
