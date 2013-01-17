<?php
$custom_fields = TalentLMS_User::getCustomRegistrationFields();

if ($_POST['submit']) {

	$post = true;

	if (!$_POST['first-name']) {
		$first_name_error = __('First Name is mandatory');
		$first_name_error_class = 'talentlms-signup-error-class';
		$post = false;
	}
	if (!$_POST['last-name']) {
		$last_name_error = __('Last Name is mandatory');
		$last_name_error_class = 'talentlms-signup-error-class';
		$post = false;
	}
	if (!$_POST['email']) {
		$email_error = __('Email is mandatory');
		$email_error_class = 'talentlms-signup-error-class';
		$post = false;
	}
	if (!$_POST['login']) {
		$login_error = __('Login is mandatory');
		$login_error_class = 'talentlms-signup-error-class';
		$post = false;
	}
	if (!$_POST['password']) {
		$password_error = __('Password is mandatory');
		$password_error_class = 'talentlms-signup-error-class';
		$post = false;
	}
	if (is_array($custom_fields)) {
		foreach ($custom_fields as $key => $custom_field) {
			if ($custom_field['mandatory'] == 'yes' && !$_POST[$custom_field['name']]) {
				echo 'nai';
				$custom_fields[$key]['error'] = $custom_field['name'] . " " . __('is mandatory');
				$custom_fields[$key]['error_class'] = 'talentlms-signup-error-class';
				$post = false;
			}
		}
	}

	if ($post) {
		try {

			$signup_arguments = array('first_name' => $_POST['first-name'], 'last_name' => $_POST['last-name'], 'email' => $_POST['email'], 'login' => $_POST['login'], 'password' => $_POST['password']);
			if (is_array($custom_fields)) {
				foreach ($custom_fields as $custom_field) {
					$signup_arguments[$custom_field['key']] = $_POST[$custom_field['name']];
				}
			}
			$newUser = TalentLMS_User::signup($signup_arguments);

			if ($newUser) {
				$login = TalentLMS_User::login(array('login' => $_POST['login'], 'password' => $_POST['password']));

				if (get_option('talentlms-after-signup') == 'redirect') {
					$output .= "<script type='text/javascript'>window.location = '" . talentlms_url($login['login_key']) . "'</script>";
				} else {
					$output .= "<div class=\"alert alert-success\">";
					$output .= "User " . $_POST['login'] . " signed up successfuly. Goto to your learning portal <a target='_blank' href='" . talentlms_url($newUser['login_key']) . "'>" . _('here') . "</a>";
					$output .= "</div>";

					$output .= $output;
				}
			}
		} catch (Exception $e) {
			if ($e instanceof TalentLMS_ApiError) {
				$output .= "<div class=\"alert alert-error\">";
				$output .= "<strong>Something is wrong!</strong> " . $e -> getMessage();
				$output .= "</div>";
			}
		}
	}
}

$output .= "<form id=\"talentlms-signup-form\" action=\"\" method=\"post\">";

$output .= "<div class=\"talentlms-form-group\">";
$output .= "<label class=\"talentlms-form-label\" for=\"first-name\">" . __('First Name') . "</label>";
$output .= "<div class=\"talentlms-form-control " . $first_name_error_class . "\">";
$output .= "<input type=\"text\" id=\"first-name\" name=\"first-name\" value=\"" . $_POST['first-name'] . "\">";
$output .= "<span class=\"talentlms-help-inline\">" . " " . $first_name_error . "</span>";
$output .= "</div>";
$output .= "</div>";

$output .= "<div class=\"talentlms-form-group\">";
$output .= "<label class=\"talentlms-form-label\" for=\"last-name\">" . __('Last Name') . "</label>";
$output .= "<div class=\"talentlms-form-control " . $last_name_error_class . " \">";
$output .= "<input type=\"text\" id=\"last-name\" name=\"last-name\" value=\"" . $_POST['last-name'] . "\">";
$output .= "<span class=\"talentlms-help-inline\">" . " " . $last_name_error . "</span>";
$output .= "</div>";
$output .= "</div>";

$output .= "<div class=\"talentlms-form-group\">";
$output .= "<label class=\"talentlms-form-label\" for=\"email\">" . __('Email') . "</label>";
$output .= "<div class=\"talentlms-form-control " . $email_error_class . "\">";
$output .= "<input type=\"text\" id=\"email\" name=\"email\" value=\"" . $_POST['email'] . "\">";
$output .= "<span class=\"talentlms-help-inline\">" . " " . $email_error . "</span>";
$output .= "</div>";
$output .= "</div>";

$output .= "<hr />";

$output .= "<div class=\"talentlms-form-group\">";
$output .= "<label class=\"talentlms-form-label\" for=\"login\">" . __('Login') . "</label>";
$output .= "<div class=\"talentlms-form-control " . $login_error_class . "\">";
$output .= "<input type=\"text\" id=\"login\" name=\"login\" value=\"" . $_POST['login'] . "\">";
$output .= "<span class=\"talentlms-help-inline\">" . " " . $login_error . "</span>";
$output .= "</div>";
$output .= "</div>";

$output .= "<div class=\"talentlms-form-group\">";
$output .= "<label class=\"talentlms-form-label\" for=\"password\">" . __('Password') . "</label>";
$output .= "<div class=\"talentlms-form-control " . $password_error_class . "\">";
$output .= "<input type=\"password\" id=\"password\" name=\"password\" value=\"" . $_POST['password'] . "\">";
$output .= "<span class=\"talentlms-help-inline\">" . " " . $password_error . "</span>";
$output .= "</div>";
$output .= "</div>";

if (is_array($custom_fields)) {
	$output .= "<hr />";

	foreach ($custom_fields as $custom_field) {
		switch($custom_field['type']) {
			case 'text' :
				$output .= "<div class=\"talentlms-form-group\">";
				$output .= "<label class=\"talentlms-form-label\" for=\"" . $custom_field['name'] . "\">" . $custom_field['name'] . "</label>";
				$output .= "<div class=\"talentlms-form-control " . $custom_field['error_class'] . "\">";
				$output .= "<input id=\"" . $custom_field['name'] . "\" name=\"" . $custom_field['name'] . "\" type=\"text\" value=\"" . $_POST[$custom_field['name']] . "\"/>";
				$output .= "<span class=\"talentlms-help-inline\">" . " " . $custom_field['error'] . "</span>";
				$output .= "</div>";
				$output .= "</div>";
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

				$output .= "<div class=\"talentlms-form-group\">";
				$output .= "<label class=\"talentlms-form-label\" for=\"" . $custom_field['name'] . "\">" . $custom_field['name'] . "</label>";
				$output .= "<div class=\"talentlms-form-control " . $custom_field['error_class'] . "\">";
				$output .= "<select id=\"" . $custom_field['name'] . "\" name=\"" . $custom_field['name'] . "\">";
				foreach ($options as $key => $option) {
					$output .= "<option value=\"" . trim($key) . "\">" . trim($option) . "</option>";
				}
				$output .= "</select>";
				$output .= "<span class=\"talentlms-help-inline\">" . " " . $custom_field['error'] . "</span>";
				$output .= "</div>";
				$output .= "</div>";
				break;
			case 'checkbox' :
				$output .= "<div class=\"talentlms-form-group\">";
				$output .= "<label class=\"talentlms-form-label\" for=\"" . $custom_field['name'] . "\">" . $custom_field['name'] . "</label>";
				$output .= "<div class=\"talentlms-form-control " . $custom_field['error_class'] . "\">";
				if (trim($custom_field['checkbox_status']) == 'on') {
					$output .= "<input id=\"" . $custom_field['name'] . "\" name=\"" . $custom_field['name'] . "\" type=\"checkbox\" checked=\"checked\" value=\"" . $custom_field['checkbox_status'] . "\" />";
				} else {
					$output .= "<input id=\"" . $custom_field['name'] . "\" name=\"" . $custom_field['name'] . "\" type=\"checkbox\" value=\"" . $custom_field['checkbox_status'] . "\" />";
				}
				$output .= "<span class=\"talentlms-help-inline\">" . " " . $custom_field['error'] . "</span>";
				$output .= "</div>";
				$output .= "</div>";
				break;
		}
	}
}

$output .= "<div class=\"talentlms-form-actions\">";
$output .= "<input class=\"btn btn-primary\" type=\"submit\" data-loading-text=\"Processing...\" value=\"" . __("Create account") . "\" name=\"submit\">";
$output .= "</div>";

$output .= "</form>";
?>