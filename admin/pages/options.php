<div class="wrap">
	<h2><i class="fa fa-check-square-o"></i>&nbsp;<?php _e('Options'); ?></h2>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>		

	
	<form id="talentlms-options-form" name="talentlms-options-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-options'); ?>">
		<input type="hidden" name="action" value="tl-options">
	<h3><?php _e('Catalog'); ?></h3>

	<hr />

	<table class="form-table">
		<tr>
        	<th scope="row" class="form-field">
				<label for="tl-catalog-categories"><?php _e("Show categories on"); ?>...</label>
			</th>
			<td class="form-field">
	        	<select id="tl-catalog-categories" name="tl-catalog-categories">
		        	<?php if (get_option('tl-catalog-categories') == 'left') : ?>
		            	<option selected="selected" value="left"><?php _e('Left'); ?></option>
					<?php else: ?>
		            	<option value="left"><?php _e('Left'); ?></option>
					<?php endif; ?>
		                			
					<?php if (get_option('tl-catalog-categories') == 'right') : ?>
		            	<option selected="selected" value="right"><?php _e('Right'); ?></option>
					<?php else: ?>
		            	<option value="right"><?php _e('Right'); ?></option>
					<?php endif; ?>
				</select>
			</td>
		</tr>
		<!-- 
		<tr>                
        	<th scope="row" class="form-field">
            	<label for="tl-catalog-view-mode"><?php _e("Course default view mode"); ?></label>
			</th>
            <td class="form-field">
           		<select id="tl-catalog-view-mode" name="tl-catalog-view-mode">
               		<?php if (get_option('tl-catalog-view-mode') == 'list') : ?>
               			<option selected="selected" value="list"><?php _e('List'); ?></option>
					<?php else: ?>
               			<option value="list"><?php _e('List'); ?></option>
					<?php endif; ?>

					<?php if (get_option('tl-catalog-view-mode') == 'grid') : ?>
               			<option selected="selected" value="grid"><?php _e('Grid'); ?></option>
					<?php else: ?>
               			<option value="grid"><?php _e('Grid'); ?></option>
					<?php endif; ?>
				</select>                    
			</td>
		</tr>
         -->    
		<tr>                
        	<th scope="row" class="form-field form-required <?php echo $form_validation; ?>">
            	<label for="tl-catalog-per-page"><?php _e("Courses per page"); ?></label>
			</th>
			<td class="form-field form-required <?php echo $form_validation; ?>">
				<input type="text" id="tl-catalog-per-page" name="tl-catalog-per-page" value="<?php echo get_option('tl-catalog-per-page'); ?>" style="width: 2.5em;" />                   
			</td>
		</tr>


	</table>	
	
	
	<h3><?php _e('Signup'); ?></h3>

	<hr />	
	
	<table class="form-table">

		<tr>                
        	<th scope="row" class="form-field">
            	<label for="tl-signup-sync"><?php _e('Signup integration'); ?></label>
			</th>
            <td class="form-field">
					<?php if(get_option('tl-signup-sync')) : ?>
						<input type="checkbox" name="tl-signup-sync" checked="checked" value="1">
						<br /><br />
						<span class="description"><?php _e("Signing up with TalentLMS (using the signup shortcode), creates a user in WP and vice versa"); ?></span>
					<?php else : ?>
						<input type="checkbox" name="tl-signup-sync" value="1">
						<br /><br />
						<span class="description"><?php _e("Signing up with TalentLMS (using the signup shortcode), creates a user in WP and vice versa"); ?></span>
					<?php endif; ?>				
			</td>
		</tr>	
	
		<tr>                
        	<th scope="row" class="form-field">
            	<label for="tl-signup-redirect"><?php _e('On signup redirect user to'); ?>...</label>
			</th>
            <td class="form-field">
				<select id="tl-signup-redirect" name="tl-signup-redirect">
		        	<?php if (get_option('tl-signup-redirect') == 'wordpress') : ?>
		            	<option selected="selected" value="wordpress"><?php _e('WordPress members area'); ?></option>
					<?php else: ?>
		            	<option value="wordpress"><?php _e('WordPress members area'); ?></option>
					<?php endif; ?>
		                			
		            <?php if (get_option('tl-signup-redirect') == 'talentlms') : ?>
						<option selected="selected" value="talentlms"><?php _e('TalentLMS'); ?></option>
		            <?php else: ?>
		                <option value="talentlms"><?php _e('TalentLMS'); ?></option>
		            <?php endif; ?>
				</select>                  
			</td>
		</tr>
	</table>
	
	<h3><?php _e('Login/Logout'); ?></h3>

	<hr />	
	
	<table class="form-table">
		<tr>                
        	<th scope="row" class="form-field">
            	<label for="tl-login-action"><?php _e('On login redirect user to...'); ?></label>
			</th>
            <td class="form-field">
				<select id="tl-login-action" name="tl-login-action">
	            	<?php if (get_option('tl-login-action') == 'wordpress') : ?>
	            		<option selected="selected" value="wordpress"><?php _e('WordPress members area'); ?></option>
	                <?php else: ?>
	                	<option value="wordpress"><?php _e('WordPress'); ?></option>
	                <?php endif; ?>
	            	<?php if (get_option('tl-login-action') == 'talentlms') : ?>
	            		<option selected="selected" value="talentlms"><?php _e('TalentLMS'); ?></option>
	                <?php else: ?>
	                	<option value="talentlms"><?php _e('TalentLMS'); ?></option>
	                <?php endif; ?>
				</select>
			</td>
		</tr>	
	
		<tr>                
        	<th scope="row" class="form-field">
            	<label for="tl-logout"><?php _e('On logout redirect user to...'); ?></label>
			</th>
            <td class="form-field">
				<select id="tl-logout" name="tl-logout">
	            	<?php if (get_option('tl-logout') == 'wordpress') : ?>
	            		<option selected="selected" value="wordpress"><?php _e('WordPress'); ?></option>
	                <?php else: ?>
	                	<option value="wordpress"><?php _e('WordPress'); ?></option>
	                <?php endif; ?>
	            	<?php if (get_option('tl-logout') == 'talentlms') : ?>
	            		<option selected="selected" value="talentlms"><?php _e('TalentLMS'); ?></option>
	                <?php else: ?>
	                	<option value="talentlms"><?php _e('TalentLMS'); ?></option>
	                <?php endif; ?>
				</select>
			</td>
		</tr>		
	</table>

	<hr />
	
	<p class="submit">
    	<input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit') ?>" />
	</p> 	
	
	</form>
	
</div>
