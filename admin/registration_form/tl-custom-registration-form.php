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
		$custom_fields = TalentLMS_User::getCustomRegistrationFields();
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
						$output .= "<input class='input' id='" . $custom_field['keu'] . "' name='" . $custom_field['key'] . "' type='checkbox' checked='checked' value='" . $custom_field['checkbox_status'] . "' />";
					} else {
						$output .= "<input class='input' id='" . $custom_field['key'] . "' name='" . $custom_field['key'] . "' type='checkbox' value='" . $custom_field['checkbox_status'] . "' />";
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
	$custom_fields = TalentLMS_User::getCustomRegistrationFields();
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

	$custom_fields = TalentLMS_User::getCustomRegistrationFields();
	if (is_array($custom_fields)) {
		foreach ($custom_fields as $key => $custom_field) {
			switch($custom_field['type']) {
				case 'text' :
				case 'dropdown' :
					$signup_arguments[$custom_field['key']] = $_POST[$custom_field['key']];
					break;
				case 'checkbox' :
					if($_POST[$custom_field['key']]) {
						$signup_arguments[$custom_field['key']] = 'on';
					} else {
						$signup_arguments[$custom_field['key']] = 'off';
					}
					
					break;
			}			
		}
	}

	try {
		$newUser = TalentLMS_User::signup($signup_arguments);
		$login = TalentLMS_User::login(array('login' => $signup_arguments['login'], 'password' => $signup_arguments['password'], 'logout_redirect' => (get_option('tl-logout') == 'WP') ? get_bloginfo('wpurl') : ''));
		$_SESSION['talentlms_user_id'] = $login['user_id'];
		$_SESSION['talentlms_user_login'] = $signup_arguments['login'];
		$_SESSION['talentlms_user_pass'] = $signup_arguments['password'];
	}catch (Exception $e){
		echo "<pre>";
		print_r($e);
		print_r($signup_arguments);
		echo "</pre>";
		exit;
		require_once(ABSPATH.'wp-admin/includes/user.php' );
		wp_delete_user($user_id);
	}
}
add_action('user_register', 'tl_custom_registration_register');

