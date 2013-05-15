<div class="wrap">
	<?php screen_icon('edit-pages'); ?>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>		

    <h2><?php echo __('TalentLMS Choose Templates'); ?></h2>
    
    <form name="talentlms-courses-template-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-options'); ?>">
        <input type="hidden" name="action" value="tl-setup-templates">
        
        <h3><?php _e('Logout options'); ?></h3>
        <table class="form-table">
    		<tr>
    			<th scope="row" class="form-field" style="width: 30em;">
    				<?php _e('When a user logs out from TalentLMS'); ?>
    			</th>
                <td class="form-field">
                    <?php if(get_option('tl-logout') == 'WP'): ?>
                        <input type="radio" name="tl-logout" value="WP" style="width: 2.5em;" checked="checked"><?php _e("Redirect user to WP"); ?><br />
                    <?php else: ?>
                        <input type="radio" name="tl-logout" value="WP" style="width: 2.5em;"><?php _e("Redirect user to WP"); ?><br />
                    <?php endif; ?>
                    <?php if(get_option('tl-logout') == 'TalentLMS'): ?>
                        <input type="radio" name="tl-logout" value="TalentLMS" style="width: 2.5em;" checked="checked"><?php _e("Stay in TalentLMS"); ?><br />
                    <?php else: ?>
                        <input type="radio" name="tl-logout" value="TalentLMS" style="width: 2.5em;"><?php _e("Stay in TalentLMS"); ?><br />
                    <?php endif; ?>     
                         
                </td>
    		</tr>         	
        </table>
        
        <h3><?php _e('Courses page: '); ?></h3>
        <table class="form-table">
        	<tr>
        		<th scope="row" class="form-field">
        			<label for="tl-courses-page-template"><?php _e('Courses page template'); ?></label>
        		</th>
        		<td class="form-field">
        			<?php if (get_option('tl-courses-page-template') == 'tl-courses-page-template-tree'): ?>
        			<input id="tl-courses-page-template-tree" name="tl-courses-page-template" type="radio" style="width: 2.5em;" value="tl-courses-page-template-tree" checked="checked" /><?php _e('Courses page with tree representation'); ?>
        			<?php else : ?>
        			<input id="tl-courses-page-template-tree" name="tl-courses-page-template" type="radio" style="width: 2.5em;" value="tl-courses-page-template-tree" /><?php _e('Courses page with tree representation'); ?>
        			<?php endif; ?>	
        		</td>
        	</tr>        	
        	
        	<tr>
        		<th scope="row" class="form-field"></th>
        		<td class="form-field">
        			<?php if (get_option('tl-courses-page-template') == 'tl-courses-page-template-pagination'): ?>
        			<input id="tl-courses-page-template-pagination" name="tl-courses-page-template" type="radio" style="width: 2.5em;" value="tl-courses-page-template-pagination" checked="checked" /><?php _e('Courses page with pagination'); ?>
        			<?php else : ?>
        			<input id="tl-courses-page-template-pagination" name="tl-courses-page-template" type="radio" style="width: 2.5em;" value="tl-courses-page-template-pagination" /><?php _e('Courses page with pagination'); ?>
        			<?php endif; ?>
        		</td>
        	</tr>
        	        	
            <tr id="tl-courses-page-template-pagination-options">
            	<th scope="row" class="form-field"></th>
            	<td>
            		<table class="form-table">            			
			            <tr>
			                <th scope="row" class="form-field">
			                    <label><?php _e('Choose courses page pagination template: '); ?></label>
			                </th>
			                <td class="form-field">
			                    <?php if(get_option('tl-courses-page-pagination-template') == 'tl-categories-right'): ?>
			                    <input type="radio" name="tl-courses-page-pagination-template" value="tl-categories-right" style="width: 2.5em;" checked="checked"><?php _e("Courses on the left - Categories on the right"); ?><br />
			                    <?php else: ?>
			                    <input type="radio" name="tl-courses-page-pagination-template" value="tl-categories-right" style="width: 2.5em;"><?php _e("Courses on the left - Categories on the right"); ?><br />    
			                    <?php endif; ?>
			
			                    <?php if(get_option('tl-courses-page-pagination-template') == 'tl-categories-left'): ?>                    
			                    <input type="radio" name="tl-courses-page-pagination-template" value="tl-categories-left" style="width: 2.5em;" checked="checked"><?php _e("Courses on the right - Categories on the left"); ?><br />
			                    <?php else: ?>
			                    <input type="radio" name="tl-courses-page-pagination-template" value="tl-categories-left" style="width: 2.5em;"><?php _e("Courses on the right - Categories on the left"); ?><br />    
			                    <?php endif; ?>
			                    
			                    <?php if(get_option('tl-courses-page-pagination-template') == 'tl-categories-top'): ?>
			                    <input type="radio" name="tl-courses-page-pagination-template" value="tl-categories-top" style="width: 2.5em;" checked="checked"><?php _e("Courses on the bottom - Categories on top"); ?><br />
			                    <?php else: ?>
			                    <input type="radio" name="tl-courses-page-pagination-template" value="tl-categories-top" style="width: 2.5em;"><?php _e("Courses on the bottom - Categories on top"); ?><br />                        
			                    <?php endif; ?>
			                </td>
			            </tr>
			            
		            	<tr>	
			                <th scope="row" class="form-field">
			                    <label for="tl-courses-page-pagination-template-courses-per-page"><?php _e('Courses per page: '); ?></label>
			                </th>
			                <td class="form-field">
			                    <input id="tl-courses-page-pagination-template-courses-per-page" name="tl-courses-page-pagination-template-courses-per-page" value="<?php echo get_option('tl-courses-page-pagination-template-courses-per-page'); ?>" style="width: 2.5em;" />
			                    <span class="description"><?php _e("Using this will enable pagination"); ?> </span>
			                </td>                
			            </tr>
			            <tr>
			                <th scope="row" class="form-field">
			                </th>
			                <td class="form-field">
			                    <?php _e("Top pagination"); ?>
			                    <?php if (get_option('tl-courses-page-pagination-template-top-pagination')): ?>
			                        <input id="tl-courses-page-pagination-template-top-pagination" name="tl-courses-page-pagination-template-top-pagination" value="1" type="checkbox" style="width: 1.5em;" checked="checked"/>
			                    <?php else : ?>
			                        <input id="tl-courses-page-pagination-template-top-pagination" name="tl-courses-page-pagination-template-top-pagination" value="1" type="checkbox" style="width: 1.5em;" />
			                    <?php endif; ?>
			                    <?php _e("Bottom pagination"); ?>
			                    <?php if (get_option('tl-courses-page-pagination-template-bottom-pagination')): ?>
			                        <input id="tl-courses-page-pagination-template-bottom-pagination" name="tl-courses-page-pagination-template-bottom-pagination" value="1" type="checkbox" style="width: 1.5em;" checked="checked"/>
			                    <?php else : ?>
			                        <input id="tl-courses-page-pagination-template-bottom-pagination" name="tl-courses-page-pagination-template-bottom-pagination" value="1" type="checkbox" style="width: 1.5em;" />
			                    <?php endif; ?>                    
			                </td>                
	            		</tr>			            
			            
			            
						<tr>
							<th scope="row" class="form-field">
								<label><?php _e('Other options: '); ?></label>
							</th>
							<td>
			                    <?php if(get_option('tl-courses-page-pagination-template-show-course-list-thumb')): ?>
			                    <input type="checkbox" name="tl-courses-page-pagination-template-show-course-list-thumb" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show courses thumbnails"); ?><br />
			                    <?php else: ?>
			                    <input type="checkbox" name="tl-courses-page-pagination-template-show-course-list-thumb" value="1" style="width: 2.5em;"><?php _e("Show courses thumbnails"); ?><br />    
			                    <?php endif; ?>
			                                        
			                    <?php if(get_option('tl-courses-page-pagination-template-show-course-list-descr')): ?>
			                    <input type="checkbox" name="tl-courses-page-pagination-template-show-course-list-descr" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show courses description"); ?> 
			                    <?php else: ?>
			                    <input type="checkbox" name="tl-courses-page-pagination-template-show-course-list-descr" value="1" style="width: 2.5em;"><?php _e("Show courses description"); ?>    
			                    <?php endif; ?>
								
								<br />
								<?php _e('Limit description by number of words'); ?>
			                    <input type="text" name="tl-courses-page-pagination-template-show-course-list-descr-limit" value="<?php echo get_option('tl-courses-page-pagination-template-show-course-list-descr-limit'); ?>" style="width: 2.5em;" />
			                    <span class="description"><?php _e("Leave empty for full description"); ?> </span>
			                    
			                    <br />
			                    <?php if(get_option('tl-courses-page-pagination-template-show-course-list-price')): ?>
			                    <input type="checkbox" name="tl-courses-page-pagination-template-show-course-list-price" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show courses price"); ?><br />
			                    <?php else: ?>
			                    <input type="checkbox" name="tl-courses-page-pagination-template-show-course-list-price" value="1" style="width: 2.5em;"><?php _e("Show courses price"); ?><br />    
			                    <?php endif; ?>                    
			                </td>                
			            </tr>	            		
            		</table>
            	</td>
            </tr>
            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('Single course page template: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('tl-single-course-page-template-show-course-descr')): ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-descr" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course description"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-descr" value="1" style="width: 2.5em;"><?php _e("Show course description"); ?><br />    
                    <?php endif; ?>

                    <?php if(get_option('tl-single-course-page-template-show-course-price')): ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-price" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course price"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-price" value="1" style="width: 2.5em;"><?php _e("Show course price"); ?><br />    
                    <?php endif; ?>

                    <?php if(get_option('tl-single-course-page-template-show-course-instructor')): ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-instructor" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course instructors"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-instructor" value="1" style="width: 2.5em;"><?php _e("Show course instructors"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('tl-single-course-page-template-show-course-units')): ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-units" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course content"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-units" value="1" style="width: 2.5em;"><?php _e("Show course content"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('tl-single-course-page-template-show-course-rules')): ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-rules" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course rules"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-rules" value="1" style="width: 2.5em;"><?php _e("Show course rules"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('tl-single-course-page-template-show-course-prerequisites')): ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-prerequisites" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course prerequisites"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-course-page-template-show-course-prerequisites" value="1" style="width: 2.5em;"><?php _e("Show course prerequisites"); ?><br />    
                    <?php endif; ?>
                </td>                
            </tr>
		</table>	
		<table class="form-table">
            <h3><?php _e('Users Page: '); ?></h3>
            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('Users page template: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('tl-users-page-template-show-user-list-avatar')): ?>
                    <input type="checkbox" name="tl-users-page-template-show-user-list-avatar" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show users avatar"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-users-page-template-show-user-list-avatar" value="1" style="width: 2.5em;"><?php _e("Show users avatar"); ?><br />    
                    <?php endif; ?>

                    <?php if(get_option('tl-users-page-template-show-user-list-bio')): ?>
                    <input type="checkbox" name="tl-users-page-template-show-user-list-bio" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show users bio"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-users-page-template-show-user-list-bio" value="1" style="width: 2.5em;"><?php _e("Show users bio"); ?><br />    
                    <?php endif; ?>
                    
					<?php _e('Limit bio by number of words'); ?>
                    <input type="text" name="tl-users-page-template-show-user-list-bio-limit" value="<?php echo get_option('tl-users-page-template-show-user-list-bio-limit'); ?>" style="width: 2.5em;" />
                    <span class="description"><?php _e("Leave empty for full bio"); ?> </span>
                </td>                
            </tr>
           	<tr>	
                <th scope="row" class="form-field"></th>
				<td class="form-field">
			    	<input id="tl-users-page-template-users-per-page" name="tl-users-page-template-users-per-page" value="<?php echo get_option('tl-users-page-template-users-per-page'); ?>" style="width: 2.5em;" />
			        <span class="description"><?php _e("Using this will enable pagination in users' list"); ?> </span>
				</td>                
			</tr>
			<tr>
				<th scope="row" class="form-field"></th>
				<td class="form-field">
			    	<?php _e("Top pagination"); ?>
			        <?php if (get_option('tl-users-page-template-users-top-pagination')): ?>
			        	<input id="tl-users-page-template-users-top-pagination" name="tl-users-page-template-users-top-pagination" value="1" type="checkbox" style="width: 1.5em;" checked="checked"/>
					<?php else : ?>
			        	<input id="tl-users-page-template-users-top-pagination" name="tl-users-page-template-users-top-pagination" value="1" type="checkbox" style="width: 1.5em;" />
					<?php endif; ?>
			        <?php _e("Bottom pagination"); ?>
			        <?php if (get_option('tl-users-page-template-users-bottom-pagination')): ?>
			        	<input id="tl-users-page-template-users-bottom-pagination" name="tl-users-page-template-users-bottom-pagination" value="1" type="checkbox" style="width: 1.5em;" checked="checked"/>
					<?php else : ?>
			        	<input id="tl-users-page-template-users-bottom-pagination" name="tl-users-page-template-users-bottom-pagination" value="1" type="checkbox" style="width: 1.5em;" />
					<?php endif; ?>                    
				</td>                
			</tr>
			
            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('Single user page template: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('tl-single-user-page-template-show-user-bio')): ?>
                    <input type="checkbox" name="tl-single-user-page-template-show-user-bio" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show user bio"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-user-page-template-show-user-bio" value="1" style="width: 2.5em;"><?php _e("Show users bio"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('tl-single-user-page-template-show-user-email')): ?>
                    <input type="checkbox" name="tl-single-user-page-template-show-user-email" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show user email"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-user-page-template-show-user-email" value="1" style="width: 2.5em;"><?php _e("Show users email"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('tl-single-user-page-template-show-user-courses')): ?>
                    <input type="checkbox" name="tl-single-user-page-template-show-user-courses" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show user courses"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="tl-single-user-page-template-show-user-courses" value="1" style="width: 2.5em;"><?php _e("Show users courses"); ?><br />    
                    <?php endif; ?>                                                           
                </td>                
            </tr>                         
        </table>
<!--
		<h3><?php _e('Groups Page:'); ?></h3>
		<table class="form-table">
           	<tr>	
                <th scope="row" class="form-field">
                    <label for="tl-groups-page-template-groups-per-page"><?php _e('Groups per page: '); ?></label>
                </th>
                <td class="form-field">
                    <input id="tl-groups-page-template-groups-per-page" name="tl-groups-page-template-groups-per-page" value="<?php echo get_option('tl-groups-page-template-groups-per-page'); ?>" style="width: 2.5em;" />
                    <span class="description"><?php _e("Using this will enable pagination"); ?> </span>
                </td>                
	            </tr>
	            <tr>
	                <th scope="row" class="form-field">
				</th>
				<td class="form-field">
			    	<?php _e("Top pagination"); ?>
			        <?php if (get_option('tl-groups-page-template-groups-top-pagination')): ?>
			        	<input id="tl-groups-page-template-groups-top-pagination" name="tl-groups-page-template-groups-top-pagination" value="1" type="checkbox" style="width: 1.5em;" checked="checked"/>
					<?php else : ?>
			        	<input id="tl-groups-page-template-groups-top-pagination" name="tl-groups-page-template-groups-top-pagination" value="1" type="checkbox" style="width: 1.5em;" />
					<?php endif; ?>
			        <?php _e("Bottom pagination"); ?>
			        <?php if (get_option('tl-groups-page-template-groups-bottom-pagination')): ?>
			        	<input id="tl-groups-page-template-groups-bottom-pagination" name="tl-groups-page-template-groups-bottom-pagination" value="1" type="checkbox" style="width: 1.5em;" checked="checked"/>
					<?php else : ?>
			        	<input id="tl-groups-page-template-groups-bottom-pagination" name="tl-groups-page-template-groups-bottom-pagination" value="1" type="checkbox" style="width: 1.5em;" />
					<?php endif; ?>                    
				</td>                
			</tr>			
		</table>
-->
        <h3><?php _e('Signup Page: '); ?></h3>
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('After a user signs up: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('tl-signup-page-post-signup') == 'redirect'): ?>
                        <input type="radio" name="tl-signup-page-post-signup" value="redirect" style="width: 2.5em;" checked="checked"><?php _e("Redirect user to TalentLMS"); ?><br />
                    <?php else: ?>
                        <input type="radio" name="tl-signup-page-post-signup" value="redirect" style="width: 2.5em;"><?php _e("Redirect user to TalentLMS"); ?><br />
                    <?php endif; ?>
                    <?php if(get_option('tl-signup-page-post-signup') == 'stay'): ?>
                        <input type="radio" name="tl-signup-page-post-signup" value="stay" style="width: 2.5em;" checked="checked"><?php _e("Stay in Wordpress"); ?><br />
                    <?php else: ?>
                        <input type="radio" name="tl-signup-page-post-signup" value="stay" style="width: 2.5em;"><?php _e("Stay in Wordpress"); ?><br />
                    <?php endif; ?>     
                         
                </td>                
            </tr>
    		<tr>
    			<th scope="row" class="form-field" style="width: 30em;">
    				<?php _e('Synchronize singup TalentLMS and WP'); ?>
    			</th>
    			<td class="form-field">
				<?php if (get_option('tl-singup-page-sync-signup')): ?>
			    <input id="tl-singup-page-sync-signup" name="tl-singup-page-sync-signup" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" checked="checked"/>
			    <?php else : ?>
			    <input id="tl-singup-page-sync-signup" name="tl-singup-page-sync-signup" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" />
			    <?php endif; ?>    				
    			&nbsp;<span class="description"><?php _e("Using this will create a WP user each time a user signs up to TalentLMS"); ?> </span>
    			</td>
    		</tr>            
        </table>

        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit' ) ?>" />
        </p>         
    </form>
</div>
