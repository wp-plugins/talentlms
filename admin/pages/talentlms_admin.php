<div class="wrap">
	<?php screen_icon('edit-pages'); ?>

	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>	
  	
    <h2><?php echo __('TalentLMS'); ?></h2>
    
    <h3><?php _e('TalentLMS Genaral Options:'); ?></h3>
      
    <form name="talentlms-api-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms'); ?>">
        <input type="hidden" name="action" value="tl-setup">
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field form-required <?php echo $domain_validation; ?>">
                    <label for="tl-domain"><?php _e("TalentLMS Domain"); ?> <span class="description"><?php _e("(Required)"); ?></span>:</label>
                </th>
                <td class="form-field form-required <?php echo $domain_validation; ?>">
                    <input id="tl-domain" name="tl-domain" style="width: 25em;" value="<?php echo get_option('talentlms-domain'); ?>" />
                </td>
            </tr>
            <tr>                
                <th scope="row" class="form-field form-required <?php echo $api_validation; ?>">
                    <label for="tl-api-key"><?php _e("API Key"); ?> <span class="description"><?php _e("(Required)"); ?></span>:</label>
                </th>
                <td class="form-field form-required <?php echo $api_validation; ?>">
                    <input id="tl-api-key" name="tl-api-key" style="width: 25em;" value="<?php echo get_option('talentlms-api-key'); ?>"/>
                </td>
            </tr>                 
        </table>
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit' ) ?>" />
            &nbsp;<span class="description"><?php _e("Submitting any changes will force the cache to be cleared"); ?></span>
        </p>        
    </form>
    
    
    <h3><?php _e('Cache control'); ?></h3>
    <form name="tl-cache-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms'); ?>">
        <input type="hidden" name="action" value="tl-cache">
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field" style="width: 30em;">
                    <?php _e('Clearing the cache will force contacting your Talentlms domain'); ?>
                </th>
                <td class="form-field">
                    <input class="button-secondary" type="submit" name="Clear cache" value="<?php _e('Clear cache' ) ?>" style="width: 8.5em;" />
                </td>
            </tr>
        </table>
    </form>
</div>