<?php
function tl_custom_registration_form() {
	
	$password = (!empty($_POST['password'])) ? trim($_POST['password']) : '';
	$output  = "<p>";
	$output .= "<label for='password'>";
	$output .= __('Password');
	$output .= "<br />";
	$output .= "<input type='password' name='password' id='password' class='input' value='".esc_attr(wp_unslash($password))."' size='25' />";
	$output .= "</label>";
	$output .= "</p>";	
	
	$first_name = (!empty($_POST['first_name'])) ? trim($_POST['first_name']) : '';
	$output .= "<p>";
	$output .= "<label for='first_name'>";
	$output .= __('First name');
	$output .= "<br />";
	$output .= "<input type='text' name='first_name' id='first_name' class='input' value='".esc_attr(wp_unslash($first_name))."' size='25' />";
	$output .= "</label>";
	$output .= "</p>";
	
	$last_name = (!empty($_POST['last_name'])) ? trim($_POST['last_name']) : '';
	$output .= "<p>";
	$output .= "<label for='last_name'>";
	$output .= __('Last name');
	$output .= "<br />";
	$output .= "<input type='text' name='last_name' id='last_name' class='input' value='".esc_attr(wp_unslash($last_name))."' size='25' />";
	$output .= "</label>";
	$output .= "</p>";	
	
	try{
		$custom_fields = tl_get_custom_fields();
	} catch (Exception $e) {}
	if(is_array($custom_fields)) {
		foreach ($custom_fields as $custom_field) {
			switch($custom_field['type']) {
				case 'text' :
					$value = (!empty($_POST[$custom_field['key']])) ? trim($_POST[$custom_field['key']]) : '';
					$output .= "<p>";
					$output .= "<label for='".$custom_field['key']."'>";
					$output .= $custom_field['name'];
					$output .= "<br />";
					$output .= "<input type='text' name='".$custom_field['key']."' id='".$custom_field['key']."' class='input' value='".esc_attr(wp_unslash($value))."' size='25' />";
					$output .= "</label>";
					$output .= "</p>";
					break;
				case 'dropdown' :
					$dropdown_values = explode(';', $custom_field['dropdown_values']);
					foreach ($dropdown_values as $value) {
						if (preg_match('/\[(.*?)\]/', $value, $match)) {
							$default_value = $match[1];
							$value = $default_value;
						}
						$options[$value] = $value;
					}
		
					$output .= "<p>";
					$output .= "<label for='".$custom_field['key']."'>";
					$output .= $custom_field['name'];
					$output .= "<br />";
					$output .= "<select class='input' id='" . $custom_field['key'] . "' name='" . $custom_field['key'] . "'>";
					foreach ($options as $key => $option) {
						$output .= "<option value='" . trim($key) . "'>" . trim($option) . "</option>";
					}
					unset($options);
					$output .= "</select>";
					$output .= "</label>";
					$output .= "</p>";
					break;
				case 'checkbox' :
					$output .= "<p>";
					$output .= "<label for='".$custom_field['key']."'>";
					$output .= $custom_field['name'];
					$output .= "<br />";
					if (trim($custom_field['checkbox_status']) == 'on') {
						$output .= "<input style='width: 15px;' class='input' id='" . $custom_field['keu'] . "' name='" . $custom_field['key'] . "' type='checkbox' checked='checked' value='" . $custom_field['checkbox_status'] . "' />";
					} else {
						$output .= "<input style='width: 15px;' class='input' id='" . $custom_field['key'] . "' name='" . $custom_field['key'] . "' type='checkbox' value='" . $custom_field['checkbox_status'] . "' />";
					}
					$output .= "</select>";
					$output .= "</label>";
					$output .= "</p>";
					break;
			}
		}
	}

	echo $output;
	
}
add_action('register_form', 'tl_custom_registration_form');

function tl_custom_registration_errors($errors, $sanitized_user_login, $user_email) {
	if (empty($_POST['password']) || !empty($_POST['password']) && trim($_POST['password']) == '') {
		$errors->add('password_error', __('<strong>ERROR</strong> Please enter a password'));
	}
	if (empty($_POST['first_name']) || !empty($_POST['first_name']) && trim($_POST['first_name']) == '') {
		$errors->add('first_name_error', __('<strong>ERROR</strong> Please type a first name'));
	}
	if (empty($_POST['last_name']) || !empty($_POST['last_name']) && trim($_POST['last_name']) == '') {
		$errors->add('last_name_error', __('<strong>ERROR</strong> Please type a last name'));
	}
	$custom_fields = tl_get_custom_fields();;
	foreach ($custom_fields as $custom_field) {
		if (empty($_POST[$custom_field['key']]) && $custom_field['mandatory'] == 'yes') {
			$errors->add($custom_field['key'].'_error', '<strong>ERROR</strong> Please enter a '.$custom_field['name']);
		}	
	}
	return $errors;
}
add_filter('registration_errors', 'tl_custom_registration_errors', 10, 3 );


function tl_custom_registration_register($user_id) {
	global $wpdb;

	if (!empty($_POST['first_name'])) {
		update_user_meta( $user_id, 'first_name', trim($_POST['first_name']));
	}
	if (!empty($_POST['last_name'])) {
		update_user_meta( $user_id, 'last_name', trim($_POST['last_name']));
	}	
	if (!empty($_POST['password'])) {
		wp_set_password($_POST['password'], $user_id);
	}

	$first_name = get_user_meta($user_id, 'first_name', true);
	$last_name = get_user_meta($user_id, 'last_name', true);
	if($_POST['pass1']) {
		$password = $_POST['pass1'];
	} else if ($_POST['password']) {
		$password = $_POST['password'];
	} else {
		$password = $user_info->user_email;
	}
	$user_info = get_userdata($user_id);
	
	$signup_arguments['first_name'] = ($first_name) ? $first_name : 'First name';
	$signup_arguments['last_name'] = ($last_name) ? $last_name : 'Last name';
	$signup_arguments['email'] = $user_info->user_email;
	$signup_arguments['login'] = $user_info->user_login;
	$signup_arguments['password'] = $password;

	$custom_fields = tl_get_custom_fields();
	if (is_array($custom_fields)) {
		foreach ($custom_fields as $key => $custom_field) {
			switch($custom_field['type']) {
				case 'text' :
				case 'dropdown' :
					update_user_meta($user_id, $custom_field['key'], $_POST[$custom_field['key']]);
					$signup_arguments[$custom_field['key']] = $_POST[$custom_field['key']];
					break;
				case 'checkbox' :
					if($_POST[$custom_field['key']]) {
						$signup_arguments[$custom_field['key']] = 'on';
					} else {
						$signup_arguments[$custom_field['key']] = 'off';
					}
					update_user_meta($user_id, $custom_field['key'], $_POST[$custom_field['key']]);
					break;
			}			
		}
	}

	try {
		$newUser = TalentLMS_User::signup($signup_arguments);
		$login = TalentLMS_User::login(array('login' => $signup_arguments['login'], 'password' => $signup_arguments['password'], 'logout_redirect' => (get_option('tl-logoutfromTL') == 'wordpress') ? get_bloginfo('wpurl') : 'http://'.get_option('talentlms-domain')));
		session_start();
		$_SESSION['talentlms_user_id'] = $login['user_id'];
		$_SESSION['talentlms_user_login'] = $signup_arguments['login'];
		$_SESSION['talentlms_user_pass'] = $signup_arguments['password'];
		
		if(!is_admin()) {
			if (get_option('tl-signup-redirect') == 'talentlms') {
				$output .= "<script type='text/javascript'>window.location = '" . tl_talentlms_url($login['login_key']) . "'</script>";
			} else {
				$creds['user_login'] = $_SESSION['talentlms_user_login'];
				$creds['user_password'] = $_SESSION['talentlms_user_pass'];
				$wpuser = wp_signon($creds, false);
				wp_redirect(admin_url('admin.php?page=talentlms-subscriber'));
			}		
		}
	}catch (Exception $e){
		require_once(ABSPATH.'wp-admin/includes/user.php' );
		//wp_delete_user($user_id);
	}
}
add_action('user_register', 'tl_custom_registration_register');


function tl_custom_user_profile_fields( $user ) {
	
	$custom_fields = tl_get_custom_fields();
	if (is_array($custom_fields)) {
?>

	<hr />
	<table class="form-table">
	<?php foreach ($custom_fields as $custom_field) : ?>
	
		<?php switch($custom_field['type']):
			 case 'text': ?>
				<tr>
					<th>
						<label for="<?php echo $custom_field['key']; ?>"><?php _e($custom_field['name']); ?></label>
					</th>
					<td>
						<input type="text" name="<?php echo $custom_field['key']; ?>" id="<?php echo $custom_field['key']; ?>" value="<?php echo esc_attr(get_the_author_meta( $custom_field['key'], $user->ID)); ?>" class="regular-text" />
					</td>
				</tr>			 
				<?php break;?>
			<?php case 'dropdown': ?>
				<tr>
					<th>
						<label for="<?php echo $custom_field['key']; ?>"><?php _e($custom_field['name']); ?></label>
					</th>
					<td>
						<?php 
							$dropdown_values = explode(';', $custom_field['dropdown_values']);
							foreach ($dropdown_values as $value) {
								if (preg_match('/\[(.*?)\]/', $value, $match)) {
									$default_value = $match[1];
									$value = $default_value;
								}
								$options[$value] = $value;
							}						
						?>
						<select name="<?php echo $custom_field['key']; ?>" id="<?php echo $custom_field['key']; ?>">
							<?php foreach($options as $key => $option) :?>
								<?php if (esc_attr(get_the_author_meta( $custom_field['key'], $user->ID) == trim($key))) : ?>
								<option value="<?php echo trim($key); ?>" selected="selected"><?php echo trim($option); ?></option>
								<?php else : ?>
								<option value="<?php echo trim($key); ?>"><?php echo trim($option); ?></option>
								<?php endif; ?>
							<?php endforeach; unset($options); ?>
						</select>
					</td>
				</tr>			
				<?php break;?>
			<?php case 'checkbox': ?>
				<tr>
					<th>
						<label for="<?php echo $custom_field['key']; ?>"><?php _e($custom_field['name']); ?></label>
					</th>
					<td>
						<?php if (esc_attr(get_the_author_meta($custom_field['key'], $user->ID)) == 'on') :?>
							<input id="<?php echo $custom_field['key']; ?>" name="<?php echo $custom_field['key']; ?>" type="checkbox" checked="checked" value="<?php echo $custom_field['checkbox_status']; ?>" />
						<?php else: ?>
							<input id="<?php echo $custom_field['key']; ?>" name="<?php echo $custom_field['key']; ?>" type="checkbox" value="<?php echo $custom_field['checkbox_status']; ?>" />
						<?php endif; ?>
					</td>
				</tr>			
				<?php break;?>				
		<?php endswitch;?>
	<?php endforeach;?>
	</table>
<?php 	
	}
}
add_action('show_user_profile', 'tl_custom_user_profile_fields');
add_action('edit_user_profile', 'tl_custom_user_profile_fields');
add_action('user_new_form', 'tl_custom_user_profile_fields');

function tl_save_custom_user_profile_fields($user_id) {
echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;
	if (!current_user_can('edit_user', $user_id)) { 
		return false;
	}
	$custom_fields = tl_get_custom_fields();
	if (is_array($custom_fields)) {
		foreach($custom_fields as $custom_field) {
			update_user_meta($user_id, $custom_field['key'], $_POST[$custom_field['key']]);
		}
	}
}

add_action('personal_options_update', 'tl_save_custom_user_profile_fields' );
add_action('edit_user_profile_update', 'tl_save_custom_user_profile_fields' );


function tl_check_custom_user_profile_fields($errors, $update, $user) {
	$custom_fields = tl_get_custom_fields();
	if (is_array($custom_fields)) {
		foreach($custom_fields as $custom_field) {
			if ($custom_field['mandatory'] == 'yes' && !$_POST[$custom_field['key']]) {
				$errors->add($custom_field['key'], $custom_field['name'] . " is required");
			}
		}
	}

}
add_filter('user_profile_update_errors', 'tl_check_custom_user_profile_fields', 10, 3);

?>