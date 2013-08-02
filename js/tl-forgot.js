jQuery(document).ready(function() {
	jQuery('#tl-send-login').change(function(){
		if (jQuery('#tl-send-login').is(':checked')) {
			jQuery('#tl-reset-password').prop('checked', false);
		}
	});
	jQuery('#tl-reset-password').change(function(){
		if (jQuery('#tl-reset-password').is(':checked')) {
			jQuery('#tl-send-login').prop('checked', false);
		}
	});
});