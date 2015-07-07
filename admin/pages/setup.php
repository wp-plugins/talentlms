<div class="wrap">
	<h2><i class="fa fa-cog"></i>&nbsp;<?php _e('Setup'); ?></h2>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>	
	
    <form name="talentlms-api-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-setup'); ?>">
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
     	
     	<hr />   
        
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit') ?>" />
            &nbsp;<span class="description"><?php _e("Submitting any changes will force the cached/synced content to be cleared"); ?></span>
        </p>        
    </form>
	
	
</div>

<?php
