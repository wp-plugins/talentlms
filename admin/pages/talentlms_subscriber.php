<div class="wrap">
	<?php screen_icon('edit-pages'); ?>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>
	
    <h2><?php echo __('TalentLMS'); ?></h2>
    
    <?php if (isset($_SESSION['talentlms_user_id'])) : ?>
    	<?php 
    	try{
    		$userDetails = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
    	}catch(Exception $e){
			echo '<div id="action-message" class="error">';
			echo '<p>'.$e->getMessage().'</p>';
			echo '</div>';
			return;
		} 
    	?>
    	
    	<div><h3><?php _e('User Details:'); ?></h3></div>
    	
		<div>
    		<img title='<?php echo $userDetails['first_name'] . " " . $userDetails['last_name'] ?>' alt='<?php echo $userDetails['first_name'] . " " . $userDetails['last_name']; ?>' src='<?php echo $userDetails['avatar']; ?>' />
    	</div>

		<p class="submit">
   			<a style="color: #fff; text-decoration: none;" href="<?php echo $userDetails['login_key']?>" target="_blank" title="<?php _e('Go to TalentLMS'); ?>">
   				<button class="button-primary"><?php _e('Go to TalentLMS'); ?></button>
   			</a>
    	</p>
    	
    	<table class="form-table">
    		<tr>
    			<th scope="row" style="padding: 5px;"><?php _e('Name:'); ?></th>
    			<td style="padding: 5px;"><?php echo $userDetails['first_name'] . ' ' . $userDetails['last_name']; ?></td>
    		</tr>
    		<tr>
    			<th scope="row" style="padding: 5px;"><?php _e('Login:'); ?></th>
    			<td style="padding: 5px;"><?php echo $userDetails['login']; ?></td>
    		</tr>    		
    		<tr>
    			<th scope="row" style="padding: 5px;"><?php _e('Email:'); ?></th>
    			<td style="padding: 5px;"><?php echo $userDetails['email']; ?></td>
    		</tr>
    		<tr>
    			<th scope="row" style="padding: 5px;"><?php _e('User Type:'); ?></th>
    			<td style="padding: 5px;"><?php echo $userDetails['user_type']; ?></td>
    		</tr>
    		<tr>
    			<th scope="row" style="padding: 5px;"><?php _e('TimeZone:'); ?></th>
    			<td style="padding: 5px;"><?php echo $userDetails['timezone']; ?></td>
    		</tr>
    		<tr>
    			<th scope="row" style="padding: 5px;"><?php _e('Bio:'); ?></th>
    			<td style="padding: 5px;"><?php echo $userDetails['bio']; ?></td>
    		</tr>    		
    	</table>
    	
    	
    	<div><h3><?php _e('User Courses:'); ?></h3></div>
    	
    	<table class="wp-list-table widefat">
    		<thead>
    			<tr>
    				<th scope="col" class="column-title"><?php _e('Course');?></th>
    				<th scope="col" class="column-title"><?php _e('Role');?></th>
    				<th scope="col" class="column-title"><?php _e('Enroled On');?></th>
    				<th scope="col" class="column-title"><?php _e('Completed On');?></th>
    				<th scope="col" class="column-title"><?php _e('Completion Status');?></th>
    				<th scope="col" class="column-title"><?php _e('Completion Percentage');?></th>
    				<th scope="col" class="column-title"><?php _e('Expired On');?></th>
    				<th scope="col" class="column-title"><?php _e('Operations');?></th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php foreach($userDetails['courses'] as $course): ?>
    			<tr class="format-standard hentry">
    				<?php $urltoCourse = TalentLMS_Course::gotoCourse(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $course['id']));?>
    				<td class="column-title">
    					<strong>
    						<a class="row-title" target="_blank" title="<?php _e('Go to') . $course['name']; ?>" href="<?php echo $urltoCourse['goto_url']?>">
    							<?php echo $course['name']; ?>
    						</a>
    					</strong>
    				</td>
    				<td class="column-title"><?php echo $course['role']; ?></td>
    				<td class="date column-date"><abbr title="<?php echo $course['enrolled_on']; ?>"><?php echo $course['enrolled_on']; ?></abbr></td>
    				<td class="date column-date"><abbr title="<?php echo $course['completed_on']; ?>"><?php echo $course['completed_on']; ?></abbr></td>
    				<td class="class="column-title""><?php echo $course['completion_status']; ?></td>
    				<td class="class="column-title""><?php echo $course['completion_percentage']; ?></td>
    				<td class="date column-date"><abbr title="<?php echo $course['expired_on']; ?>"><?php echo $course['expired_on']; ?></abbr></td>
    				<td class="column-title">
						<a class="row-title" target="_blank" title="<?php _e('Go to') . $course['name']; ?>" href="<?php echo $urltoCourse['goto_url']?>">
    						<?php _e('Go to course');?>
    					</a>    				
    				</td>
    			</tr>
    		<?php endforeach; ?>
    		</tbody>
    	</table>

<!--     	
    	
		<div><h3><?php _e('User Groups:'); ?></h3></div>
    	
    	<table class="wp-list-table widefat">
    		<thead>
    			<tr>
    				<th scope="col" class="column-title"><?php _e('Group');?></th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php foreach($userDetails['groups'] as $group): ?>
    			<tr class="format-standard hentry">
    				<td class="column-title">
    					<strong><?php echo $group['name']; ?></strong>
    				</td>
    			</tr>
    		<?php endforeach; ?>
    		</tbody>
    	</table>
    	
		<div><h3><?php _e('User Branches:'); ?></h3></div>
    	
    	<table class="wp-list-table widefat">
    		<thead>
    			<tr>
    				<th scope="col" class="column-title"><?php _e('Branch');?></th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php foreach($userDetails['branches'] as $branch): ?>
    			<tr class="format-standard hentry">
    				<td class="column-title">
    					<strong><?php echo $branch['name']; ?></strong>
    				</td>
    			</tr>
    		<?php endforeach; ?>
    		</tbody>
    	</table>    	

-->   	
    	
    <?php else:?>
					
		<form class='tl-form-horizontal' method='post' action='<?php tl_current_page_url(); ?>'>
			<div><h3><?php _e('Login to TalentLMS'); ?></h3></div>
			<input type="hidden" name="action" value="tl-subscriber-login">
	        <table class="form-table">
	            <tr>
	                <th scope="row" class="form-field form-required <?php echo $login_validation; ?>">
	                    <label for="tl-login"><?php _e("TalentLMS Username"); ?> <span class="description"><?php _e("(Required)"); ?></span>:</label>
	                </th>
	                <td class="form-field form-required <?php echo $login_validation; ?>">
	                    <input class='span' id='tl-login' name='tl-login' type='text' style="width: 25em;">
	                </td>
	            </tr>
	            <tr>                
	                <th scope="row" class="form-field form-required <?php echo $password_validation; ?>">
	                    <label for="tl-api-key"><?php _e("TalentLMS Password"); ?> <span class="description"><?php _e("(Required)"); ?></span>:</label>
	                </th>
	                <td class="form-field form-required <?php echo $password_validation; ?>">
	                	<input class='span' id='tl-password' name='tl-password' type='password' style="width: 25em;">
	                </td>
	            </tr>                 
	        </table>
	        <p class="submit">
	            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Login') ?>" />
	        </p> 		
		</form>
					
    <?php endif;?>
    
    
</div>
