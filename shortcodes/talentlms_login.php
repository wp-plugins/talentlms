<?php

if ($_POST['talentlms-logout']) {
	try{
		TalentLMS_User::logout(array('user_id' => $_SESSION['talentlms_user_id']));
	} catch (Exception $e) {}
	session_start();
	unset($_SESSION['talentlms_user_id']);
	unset($_SESSION['talentlms_user_login']);
	unset($GLOBALS['talentlms_error_msg']);
	wp_logout();
	wp_redirect(home_url());
}

if ($_POST['talentlms-login'] && $_POST['talentlms-password']) {
	try {
		$login = TalentLMS_User::login(array('login' => $_POST['talentlms-login'], 'password' => $_POST['talentlms-password'], 'logout_redirect' => (get_option('tl-logoutfromTL') == 'wordpress') ? get_bloginfo('wpurl') : 'http://'.get_option('talentlms-domain')));
		session_start();
		$_SESSION['talentlms_user_id'] = $login['user_id'];
		$_SESSION['talentlms_user_login'] = $_POST['talentlms-login'];
		$_SESSION['talentlms_user_pass'] = $_POST['talentlms-password'];
	            
		$creds = array();
		$creds['user_login'] = $_SESSION['talentlms_user_login'];
		$creds['user_password'] = $_SESSION['talentlms_user_pass'];
		$wpuser = wp_signon( $creds, false );
	            
		if(is_wp_error($wpuser)) {
	    	unset($_SESSION['talentlms_user_id']);
	        unset($_SESSION['talentlms_user_login']);
			unset($_SESSION['talentlms_user_pass']);
	            	
			$tl_login_failed = true;
			$tl_login_fail_message = $wpuser->get_error_message() . " (" . __('WordPress authentication') . ")";	             
		} else {
			wp_redirect(admin_url('admin.php?page=talentlms-subscriber'));
		}
	} catch (Exception $e) {
		if ($e instanceof TalentLMS_ApiError) {
			unset($_SESSION['talentlms_user_id']);
			unset($_SESSION['talentlms_user_login']);
			unset($_SESSION['talentlms_user_pass']);
						
			$tl_login_failed = true;
			$tl_login_fail_message = $e -> getMessage()  . " (" . __('TalentLMS authentication') . ")";;
		}
	}
}


if (isset($_SESSION['talentlms_user_id'])) {
	$output .= "<span style='display:block'>" . _('Welcome back') . " <b>" . $user['first_name'] . " " . $user['last_name'] . "</b></span>";
	$output .= "<span style='display:block'>" . _('Goto to your learning portal') . " <a target='_blank' href='" . tl_talentlms_url($login['login_key']) . "'>" . _('here') . "</a></span>";

	$output .= "<form class='tl-form-horizontal' method='post' action='" . tl_current_page_url() . "'>";
	$output .= "<input id='talentlms-login' name='talentlms-logout' type='hidden' value='logout'>";
	$output .= "<button class='btn' type='submit'>" . _('Logout') . "</button>";
	$output .= "</form>";
} else {

	if ($tl_login_failed) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $tl_login_fail_message;
		$output .= "</div>";
	}

	$output .= "<form class='tl-form-horizontal' method='post' action='" . tl_current_page_url() . "'>";
	$output .= "<div>";
	$output .= "<label for='talentlms-login'>" . _('Login') . "</label>";
	$output .= "<div >";
	$output .= "<input class='span' id='talentlms-login' name='talentlms-login' type='text'>";
	$output .= "</div>";
	$output .= "</div>";
	$output .= "<div>";
	$output .= "<label for='talentlms-password'>" . _('Password') . "</label>";
	$output .= "<div >";
	$output .= "<input class='span' id='talentlms-password' name='talentlms-password' type='password'>";
	$output .= "</div>";
	$output .= "</div>";
	$output .= "<div class='form-actions' style='text-align:right;'>";
	$output .= "<button class='btn' type='submit'>" . _('Login') . "</button>";
	$output .= "</div>";
	$output .= "</form>";
	$output .= "<div>";
	$output .= "<a href='" . get_page_link(get_option("tl_forgot_page_id")) . "'>"._('Forgot login/password?')."</a>";
	$output .= "</div>";
}