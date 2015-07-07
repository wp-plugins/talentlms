<div class="wrap">
	<h2><i class="fa fa-link"></i>&nbsp;<?php _e('Sync'); ?></h2>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>	

	
	<form name="talentlms-sync-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-sync'); ?>">
		<input type="hidden" name="action" value="tl-sync">
	
	
		<div class="tl-sync-container">
			<div class="tl-sync-info">
				<p><?php _e('TalentLMS Users'); ?></p>
				<span class="tl-user-num"><?php echo count($tl_users); ?></span>
			</div>
			<div class="tl-sync-info">
				<p><?php _e('WordPress Users'); ?></p>
				<span class="tl-user-num"><?php echo count($wp_users); ?></span>
			</div>
		</div>
		<div class="clear"></div>
							
		<p><div>
			<input type="checkbox" name="tl-sync-overwrite" value="1"><?php _e("Overwrite WordPress users info from TalentLMS"); ?><br />
		</div></p>
		
		<p>
			<span class="description"><?php _e(' Notice: New TalentLMS users synced from WP have as password their login. Please change the corresponding password once logged in to TalentLMS. '); ?></span>
		</p>	
		
		<p class="submit">
			<input class="button-primary" type="submit" name="Submit" value="<?php _e('Sync users') ?>" />
		</p>
		
	</form>
	
	<hr />
	
	<h3><?php _e('Sync content');?></h3>
	<form name="talentlms-cache-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-sync'); ?>">

		<div class="tl-sync-container">
			<div class="tl-sync-info">
				<p><?php _e('TalentLMS Courses'); ?></p>
				<span class="tl-user-num"><?php echo count($tl_content); ?></span>
			</div>
			<div class="tl-sync-info">
				<p><?php _e('TalentLMS Courses in WordPress'); ?></p>
				<span class="tl-user-num"><?php echo count($wp_content); ?></span>
			</div>
		</div>
		<div class="clear"></div>	
	
	
		<p>
			<span class="description"><?php _e(' Notice: Content from your TalentLMS site is being cached for performance reasons. Force sync to update your content with the latest data from TalentLMS'); ?></span>
		</p>			

		<p><div>
			<?php if(get_option('tl-sync-periodicaly')) : ?>
			<input type="checkbox" name="tl-sync-periodicaly" checked="checked" value="1"><?php _e("Automatically sync content with TalentLMS periodically"); ?><br />
			<?php else : ?>
			<input type="checkbox" name="tl-sync-periodicaly" value="1"><?php _e("Automatically sync content with TalentLMS periodically"); ?><br />
			<?php endif; ?>
		</div></p>		
		
		<input type="hidden" name="action" value="tl-cache">
		<p class="submit">
			<input class="button-primary" type="submit" name="Submit" value="<?php _e('Sync content') ?>" />
		</p>
	</form>
	  
</div>