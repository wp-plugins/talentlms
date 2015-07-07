<?php

if ($_POST['tl-forgot-credentials'] == 'post') {
	if ($_POST['tl-reset-password']) {
		try {
			TalentLMS_User::forgotPassword(array('username' => $_POST['tl-forgot-login']));
			$output .= "<div class='alert alert-success'>";
			$output .= _('An email for password reset has been sent to your account\'s email.');
			$output .= "</div>";			
		} catch(Exception $e) {
			if ($e instanceof TalentLMS_ApiError) {
				$output .= "<div class='alert alert-error'>";
				$output .= "<strong>" . _('Something is wrong!') . "</strong> " . $e -> getMessage();
				$output .= "</div>";
			}
		}
	}

	if ($_POST['tl-send-login']) {
		try {
			TalentLMS_User::forgotUsername(array('email' => $_POST['tl-forgot-email']));
			$output .= "<div class='alert alert-success'>";
			$output .= _('An email with your username has been sent to your account\'s email.');
			$output .= "</div>";
		} catch(Exception $e) {
			if ($e instanceof TalentLMS_ApiError) {
				$output .= "<div class='alert alert-error'>";
				$output .= "<strong>" . _('Something is wrong!') . "</strong> " . $e -> getMessage();
				$output .= "</div>";
			}
		}
	}
}
$output .= "<div>";
$output .= "	<form id='tl-forgot-credentials-form' action='" . tl_current_page_url() . "' method='post'>";
$output .= "		<div style='display: none;'>";
$output .= "			<input type='hidden' name='tl-forgot-credentials' value='post' ><br>";
$output .= "		</div>";

$output .= "		<div class='tl-form-group'>";
$output .= "			<label class='tl-form-label'>" . __('Check this box if you have forgotten your Password') . "</label>";
$output .= "			<div class='tl-form-control'>";
$output .= "				<input type='checkbox' value=" . __('Reset my Password') . " name='tl-reset-password' id='tl-reset-password' >&nbsp;";
$output .= "			</div>";
$output .= "		</div>";

$output .= "		<div id='tl-forgot-email-div' class='tl-form-group' style='display:none;'>";
$output .= "			<label class='tl-form-label' for='tl-forgot-login'>" . __('Username') . "</label>";
$output .= "			<div class='tl-form-control'>";
$output .= "				<input type='text' id='tl-forgot-login' name='tl-forgot-login' value=''>";
$output .= "			</div>";
$output .= "		</div>";

$output .= "		<div class='tl-form-group'>";
$output .= "			<label class='tl-form-label'>" . __('Check this box if you have forgotten your Username') . "</label>";
$output .= "			<div class='tl-form-control'>";
$output .= "				<input type='checkbox' value=" . __('Resend my username') . " name='tl-send-login' id='tl-send-login' >&nbsp;";
$output .= "			</div>";
$output .= "		</div>";

$output .= "		<div id='tl-forgot-login-div' class='tl-form-group' style='display:none;'>";
$output .= "			<label class='tl-form-label' for='tl-forgot-email'>" . __('Registered Email Address') . "</label>";
$output .= "			<div class='tl-form-control'>";
$output .= "				<input type='text' id='tl-forgot-email' name='tl-forgot-email' value=''>";
$output .= "			</div>";
$output .= "		</div>";

$output .= "		<div class='form-actions'>";
$output .= "			<button class='btn' name='submit' type='submit'>".__('Submit')."</button>";
$output .= "		</div>";

$output .= "	</form>";
$output .= "</div>";
?>