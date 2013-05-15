jQuery(document).ready(function() {
	jQuery('.tl-toggle-category').click(function() {
		var id = jQuery(this).attr('id').split("-")[2];
		jQuery('#tl-category-contents-' + id).toggle('slow');
	});
});

