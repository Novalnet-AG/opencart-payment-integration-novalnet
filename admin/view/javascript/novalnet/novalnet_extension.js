/**
 * Novalnet global configuration script
 * By Novalnet AG (https://www.novalnet.de)
 * Copyright (c) Novalnet AG
 */
jQuery(document).ready(function() {

	$('#radio-refund-payment-type-none').prop('checked', true);
	$('#input-update-amount').on('keypress', function(e){
		var regex = new RegExp("^[0-9\b]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (!regex.test(str)) {
			return false;
		}
	});

	/** Handle manage transaction **/
	$('#button-novalnet-manage-transaction').on('click', function() {
		$('.text-danger').remove();
		if($('#select-transaction-status').val() == ''){
			$('#select-transaction-status').after('<div class="text-danger">'+$('#novalnet-error-text-status').val()+'</div>');
			return false;
		}
		var message = ($('#select-transaction-status').val() == 100) ? $('#warning-capture').val() : $('#warning-cancel').val();
		if (!confirm(message)) {
			return false;
		}
		sendRequest('captureVoid', 'novalnet-manage-transaction');
	});

	/** Handle amount refund **/
	$('#button-novalnet-amount-refund').on('click', function() { 

		$('.text-danger').remove();
		if(Number($('#input-refund-amount').val()) == '') {
			$('#input-refund-amount').after('<div class="text-danger">'+$('#novalnet-error-amount-invalid').val()+'</div>');
			return false;
		}

		if (!confirm($('#warning-refund').val())) {
			return false;
		}			
		sendRequest('amountRefund', 'novalnet-amount-refund');
	});

	/** Handle amount book **/
	$('#button-novalnet-amount-book').on('click', function() {
		$('.text-danger').remove();
		if(Number($('#input-book-amount').val()) == '') {
			$('#input-book-amount').after('<div class="text-danger">'+$('#novalnet-error-amount-invalid').val()+'</div>');
			return false;
		}

		if (!confirm($('#warning-amount-book').val())) {
			return false;
		}

		sendRequest('amountBooking', 'novalnet-amount-book');
	});

	/** Handle amount update **/
	$('#button-novalnet-amount-update').click(function(){
		$('.text-danger').remove();

		if(Number($('#input-update-amount').val()) == '') {
			$('#input-update-amount').after('<div class="text-danger">'+$('#novalnet-error-amount-invalid').val()+'</div>');
			return false;
		}

		$('.text-danger').remove();
		if($('#input-due-date').length && !isValidDate($('#input-due-date').val())) { 
			$('#input-due-date').after('<div class="text-danger">'+$('#novalnet-error-due-date').val()+'</div>');
			return false;
		}		
		
		if($('#input-expiry-date').length && !isValidDate($('#input-expiry-date').val())) {
			$('#input-expiry-date').after('<div class="text-danger">'+$('#novalnet-error-due-date').val()+'</div>');
			return false;
		}
		
		if($('#input-expiry-date').length) {
			var selectedDate = new Date($('#input-expiry-date').val());
		}
		else {
			var selectedDate = new Date($('#input-due-date').val());
		}
		var currentDate = new Date();

		$('.text-danger').remove();
		if (selectedDate < currentDate) {
			if($('#input-expiry-date').length) {
				$('#input-expiry-date').after('<div class="text-danger">'+$('#novalnet-error-due-date-future').val()+'</div>');
			}
			else {
				$('#input-due-date').after('<div class="text-danger">'+$('#novalnet-error-due-date-future').val()+'</div>');
			}
			return false;
		}
		if (!confirm($('#warning-amount-update').val())) {
			return false;
		}
		sendRequest('amountUpdate', 'novalnet-amount-update');
	});

	if($('#input-due-date').length){
		$('#input-due-date').datetimepicker({
			pickDate: true,
			pickTime: false,
			format: 'yy-mm-dd'
		});
		$('.date').datetimepicker({
			pickTime: false
		});
	}
	
	if($('#input-expiry-date').length){
		$('#input-expiry-date').datetimepicker({
			pickDate: true,
			pickTime: false,
			format: 'yy-mm-dd'
		});
		$('.date').datetimepicker({
			pickTime: false
		});
	}
});

/** Validate account holder.**/
function sepa_validation(event){
	var keycode = ('which' in event) ? event.which : event.keyCode;
	var reg = /^(?:[A-Za-z0-9]+$)/;
	if(event.target.id == 'input-account-holder')
		reg = /[^0-9\[\]\/\\#,+@!^()$~%'"=:;<>{}\_\|*?`]/g;
	return (reg.test(String.fromCharCode(keycode)) || keycode === 0 || keycode === 8) ? true : false;
}

/** Validate due date.**/
function isValidDate(dueDate) {
	if(dueDate == '')
		return false;
	var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex
	var dtArray = dueDate.match(rxDatePattern); // is format OK?
	if (dtArray == null)
		return false;

	//Checks for yyyy/mm/dd format.
	dtYear = dtArray[1];
	dtMonth = dtArray[3];
	dtDay = dtArray[5];
	if (dtMonth < 1 || dtMonth > 12)
		return false;
	else if (dtDay < 1 || dtDay> 31)
		return false;
	else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
		return false;
	else if (dtMonth == 2)
	{
		var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
		if (dtDay> 29 || (dtDay ==29 && !isleap))
				return false;
	}
	return true;
}

/**
 * Handle api response
 */
function api_response(json, form){
	if(json['error']) {
		$('#'+form).before('<div class="alert alert-danger">'+json['error']+'<button class="close" type="button" data-dismiss="alert">×</button></div>');
		return false;
	} else if (json['success']) {
		$('.row').before('<div class="alert alert-success">'+json['success']+'<button class="close" type="button" data-dismiss="alert">×</button></div>');
		$('html, body').animate({scrollTop: '0px'}, 0);
		setTimeout(function () {
			location.reload(true);
		}, 500);
	}
}

/**
 * Allow only an integer value
 */
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode
	return (!(charCode > 31 && (charCode < 48 || charCode > 57)));
}
