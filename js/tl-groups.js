
jQuery(document).ready(function() {
	jQuery('.tl-group').click(function() {
		jQuery('#tl-join-group-form-dialog').dialog('open');
	});
	
	jQuery('#tl-join-group-form-dialog').dialog({
		width : 350,
		modal : true,
		autoOpen : false,
		buttons : {
			'Join Group' : function() {
				jQuery('#tl-join-group-form').submit();
			},
			Cancel : function() {
				jQuery(this).dialog('close');
			}
		},
	});
	
});
