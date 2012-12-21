<div class="wrap">
	<div id="icon-edit-pages" class="icon32">
	</div>
	<?php if($_POST['action']) : ?>
	<div id='talentlms-edit-css-message' class='updated fade'>
		<p><?php _e('File edited successfully.'); ?></p>
	</div>
	<?php endif; ?>
	
	<h2><?php echo __('Edit TalentLMS CSS'); ?></h2>
		
	<div class="fileedit-sub">
		<big><?php echo __('Editing'); ?> <strong><?php echo _BASEURL_ . 'css/talentlms-style.css'; ?></strong></big>
	</div>	
	
	<style type="text/css">
	   #talentlms_edit_css{
            background: none repeat scroll 0 0 #F9F9F9;
            font-family: Consolas,Monaco,monospace;
            font-size: 12px;
            outline: 0 none;
            width: 97%;
	   }
	</style>
	
	<form name="talentlms-edit-css-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-edit-css'); ?>">
		<input type="hidden" name="action" value="post">
		<?php $css_file_content = file_get_contents(_BASEURL_ . 'css/talentlms-style.css'); ?>
		<textarea cols="70" rows="25" name="talentlms_edit_css" id="talentlms_edit_css"><?php echo $css_file_content ; ?></textarea>
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update' ) ?>" />
        </p>	
	</form>
	
</div>