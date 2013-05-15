<div class="wrap">
	<?php screen_icon('edit-pages'); ?>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>		
	
	<h2><?php echo __('Edit TalentLMS CSS'); ?></h2>

	<div class="fileedit-sub">
		<div class="alignleft"><h3><?php _e('Editing'); ?>: <span><strong><?php echo _BASEURL_ . 'css/talentlms-style.css'; ?></strong></span></h3></div>
		<br class="clear">
	</div>	
		
	<form name="talentlms-edit-css-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-edit-css'); ?>">
		<input type="hidden" name="action" value="post">
		<?php $css_file_content = file_get_contents(_BASEURL_ . 'css/talentlms-style.css'); ?>
		<textarea cols="70" rows="25" name="tl-edit-css" id="tl-edit-css"><?php echo $css_file_content; ?></textarea>
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update' ) ?>" />
        </p>	
	</form>
	
</div>