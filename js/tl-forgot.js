
jQuery(document).ready(function() {
	jQuery('#tl-send-login').change(function(){
		if (jQuery('#tl-send-login').is(':checked')) {
			jQuery('#tl-reset-password').prop('checked', false);
			jQuery('#tl-forgot-login-div').show();
			jQuery('#tl-forgot-email-div').hide();
		} else {
			jQuery('#tl-forgot-login-div').hide();
		}
	});
	
	
	jQuery('#tl-reset-password').change(function(){
		if (jQuery('#tl-reset-password').is(':checked')) {
			jQuery('#tl-send-login').prop('checked', false);
			jQuery('#tl-forgot-email-div').show();
			jQuery('#tl-forgot-login-div').hide();
		} else {
			jQuery('#tl-forgot-email-div').hide();
		}
	}); 
});