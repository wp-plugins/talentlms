<div class="wrap">
	<?php screen_icon('edit'); ?>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>
	
	<h2><?php _e('TalentLMS and WP Synchronization'); ?></h2>

    <h3><?php _e('Synchronize Users'); ?></h3>
   	<table class="widefat">
   		<tbody>
    		<tr>
    			<th><?php _e('TalentLMS Users'); ?></th>
    			<td><?php echo count($tl_users); ?></td>	    			
    			<th><?php _e('Users to sync from TalentLMS'); ?></th>
    			<td><?php echo count($tl_users_to_wp); ?></td>	    			
    		</tr>
    		<tr>
    			<th><?php _e('WP Users'); ?></th>
    			<td><?php echo count($wp_users); ?></td>
    			<th><?php _e('Users to sync from WP'); ?></th>
    			<td><?php echo count($wp_users_to_tl); ?></td>			
    		</tr>   			    		
   		</tbody>
   	</table>
   	
    <?php if(!empty($sync_errors)) : ?>
	
	<p><strong><?php _e('Sync errors'); ?></strong></p>  	
	<pre id="tl-sync-errors"><?php foreach($sync_errors as $error) { echo $error . "<br />"; }?></pre>
    <?php endif; ?>   	
   	
    <form name="tl-sync-users-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-sync'); ?>">
        <input type="hidden" name="action" value="tl-sync-users">
        <table class="form-table">
        	<tr>
        		<th scope="row" class="form-field">
        			<label for="hard-sync"><?php _e('Hard sync'); ?></label>
        		</th>
        		<td class="form-field">
        			<input id="tl-hard-sync" name="tl-hard-sync" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" />
        			&nbsp;<span class="description"><?php _e("Using this option will overwrite WP users' details with details stored in TalentLMS"); ?></span>
        		</td>
        	</tr>
        </table>
        <p class="submit">
			<input class="button-primary" type="submit" name="Sync Users" value="<?php _e('Sync') ?>" style="width: 8.5em;" />
			&nbsp;<span class="description"><?php _e('Synchronize your TalentLMS and WP users'); ?></span>
        </p>
        <span class="description"><?php _e('Notice: New TalentLMS users synced from WP have as password their login. Please change the corresponding password once logged in to TalentLMS.'); ?></span> 
    </form>
    
    <h3><?php _e('Synchronize Content'); ?></h3>
    <form name="tl-sync-categories-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-sync'); ?>">
        <input type="hidden" name="action" value="tl-sync-content">
        <p class="submit">
			<input class="button-primary" type="submit" name="Sync Content" value="<?php _e('Sync') ?>" style="width: 8.5em;" />
			&nbsp;<span class="description"><?php _e('Synchronize your TalentLMS and WP categories and your TalentLMS courses and WP posts'); ?></span>
        </p>
        <span class="description"><?php _e('Notice: Synchronizing your Content (TalentLMS categories to WP categories and TalentLMS courses to WP posts, will force all your current WP categories and WP posts to be deleted permanently'); ?></span> 
    </form>

</div>