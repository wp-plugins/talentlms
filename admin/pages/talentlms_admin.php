<div class="wrap">
    <div id="icon-edit-pages" class="icon32">
    </div>
    <?php if($setting_library_error): ?>
        <div id='talentlms-edit-css-message' class='error fade'>
            <p><?php echo $setting_library_error; ?></p>
        </div>
    <?php endif; ?>    
	<?php if($_POST['action'] == "post" && !$setting_library_error) : ?>
        <div id='talentlms-edit-css-message' class='updated fade'>
			<p><?php _e('Details edited successfully.'); ?></p>
		</div>
	<?php endif; ?>    
	
    <h2><?php echo __('TalentLMS'); ?></h2>
    
    <h3><?php _e('TalentLMS Genaral Options:'); ?></h3>
    
    
    <form name="talentlms-api-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms'); ?>">
        <input type="hidden" name="action" value="post">
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field form-required <?php echo $domain_validation; ?>">
                    <label for="talentlms_domain"><?php _e("Talent Domain"); ?> <span class="description"><?php _e("(Required)"); ?></span>:</label>
                </th>
                <td class="form-field form-required <?php echo $domain_validation; ?>">
                    <input id="talentlms_domain" name="talentlms_domain" style="width: 25em;" value="<?php echo get_option('talentlms-domain'); ?>" />
                </td>
            </tr>
            <tr>                
                <th scope="row" class="form-field form-required <?php echo $api_validation; ?>">
                    <label for="api_key"><?php _e("API Key"); ?> <span class="description"><?php _e("(Required)"); ?></span>:</label>
                </th>
                <td class="form-field form-required <?php echo $api_validation; ?>">
                    <input id="api_key" name="api_key" style="width: 25em;" value="<?php echo get_option('talentlms-api-key'); ?>"/>
                </td>
            </tr>                 
        </table>
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit' ) ?>" />
            &nbsp;<span class="description"><?php _e("Submitting any changes will force the cache to be cleared"); ?></span>
        </p>        
    </form>
    
    
    <h3><?php _e('Cache control'); ?></h3>
    <form name="talentlms-cache-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms'); ?>">
        <input type="hidden" name="action" value="cache">
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