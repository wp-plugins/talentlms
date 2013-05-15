/**
 * @author V. Prountzos
 */
jQuery(document).ready(function() {	
	if (jQuery("#tl-courses-page-template-pagination").is(':checked')) {
		jQuery("#tl-courses-page-template-pagination-options").show();
	} else {
		jQuery("#tl-courses-page-template-pagination-options").hide();
	}
	
	jQuery("input[name='tl-courses-page-template']").change(function() {
		if (jQuery("#tl-courses-page-template-pagination").is(':checked')) {
			jQuery("#tl-courses-page-template-pagination-options").show();
		} else {
			jQuery("#tl-courses-page-template-pagination-options").hide();
		}
	});
	
	jQuery("#tl-courses-page-pagination-template-courses-per-page").blur(function() {
		if (jQuery(this).val() && jQuery(this).val() > 0) {
			jQuery('#tl-courses-page-pagination-template-bottom-pagination').prop('checked', true);
		} else {
			jQuery('#tl-courses-page-pagination-template-top-pagination').prop('checked', false);
			jQuery('#tl-courses-page-pagination-template-bottom-pagination').prop('checked', false);
		}
	});
		
	jQuery("#tl-users-page-template-users-per-page").blur(function() {
		if (jQuery(this).val() && jQuery(this).val() > 0) {
			jQuery('#tl-users-page-template-users-bottom-pagination').prop('checked', true);
		} else {
			jQuery('#tl-users-page-template-users-top-pagination').prop('checked', false);
			jQuery('#tl-users-page-template-users-bottom-pagination').prop('checked', false);
		}
	});	

	jQuery("#tl-groups-page-template-groups-per-page").blur(function() {
		if (jQuery(this).val() && jQuery(this).val() > 0) {
			jQuery('#tl-groups-page-template-groups-bottom-pagination').prop('checked', true);
		} else {
			jQuery('#tl-groups-page-template-groups-top-pagination').prop('checked', false);
			jQuery('#tl-groups-page-template-groups-bottom-pagination').prop('checked', false);
		}
	});		
	
});