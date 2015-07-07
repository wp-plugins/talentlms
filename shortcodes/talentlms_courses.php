<?php

wp_enqueue_style('tl-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');

if ($_POST['action'] == "tl-dialog-post") {
	try {
		if ($_POST['tl-dialog-login'] && $_POST['tl-dialog-password']) {
			$login = TalentLMS_User::login(array('login' => $_POST['tl-dialog-login'], 'password' => $_POST['tl-dialog-password'], 'logout_redirect' => (get_option('tl-logout') == 'wordpress') ? get_bloginfo('wpurl') : 'http://'.get_option('talentlms-domain')));
			session_start();
			$_SESSION['talentlms_user_id'] = $login['user_id'];
			$_SESSION['talentlms_user_login'] = $_POST['tl-dialog-login'];
            $_SESSION['talentlms_user_pass'] = $_POST['tl-dialog-password'];
			
			$user = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
			unset($GLOBALS['talentlms_error_msg']);
			$output .= "<div class='alert alert-success'>";
			$output .= "<span style='display:block'>" . _('Welcome back') . " <strong>" . $user['first_name'] . " " . $user['last_name'] . "</strong></span>";
			$output .= "<span style='display:block'>" . _('Goto to your learning portal') . " <a target='_blank' href='" . tl_talentlms_url($login['login_key']) . "'>" . _('here') . "</a></span>";
			$output .= "</div>";
		} else {
			$output .= "<div class='alert alert-error'>";
			if (!$_POST['tl-dialog-login']) {
				$output .= "<span style='display: block;'><strong>" . _('Username cannot be empty') . "</strong></span>";
			}
			if (!$_POST['tl-dialog-password']) {
				$output .= "<span style='display: block;'><strong>" . _('Password cannot be empty') . "</strong></span>";
			}
			$output .= "</div>";
		}
	} catch (Exception $e) {
		if ($e instanceof TalentLMS_ApiError) {
			$output .= "<div class='alert alert-error'>";
			$output .= $e -> getMessage();
			$output .= "</div>";
		}
	}
}

$talentlms_info = tl_get_siteinfo();
if($talentlms_info instanceof TalentLMS_ApiError) {
	$output .= "<div class='alert alert-error'>";
	$output .= $e -> getMessage();
	$output .= "</div>";
	return false;
}
 
if ($_POST['talentlms-get-course']) {
	session_start();
	if (preg_replace("/\D+/", "", html_entity_decode($_POST['talentlms-course-price'])) > 0 && $talentlms_info['paypal_email']) {
		$buyCourse = TalentLMS_Course::buyCourse(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $_POST['talentlms-get-course']));
		$output .= "<script type='text/javascript'>window.location = '" . tl_talentlms_url($buyCourse['redirect_url']) . "'</script>";
		echo $output;
		//header("location:".$buyCourse['redirect_url']);
		exit ;
	} else {
		$addUserToCourse = TalentLMS_Course::addUser(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $_POST['talentlms-get-course']));
	}
}
?>

<?php
if (isset($_GET['tlcourse']) && $_GET['tlcourse'] != '') {
	$course = tl_get_course($_GET['tlcourse']);
	if ($course instanceof TalentLMS_ApiError) {
		$output .= "<div class='alert alert-error'>";
		$output .= $course -> getMessage();
		$output .= "</div>";
	} else {
		include (_BASEPATH_ . '/templates/course_single.php');
	}
} else {
	$courses = tl_get_courses();
	if ($courses instanceof TalentLMS_ApiError) {
		$output .= "<div class='alert alert-error'>";
		$output .= $courses -> getMessage();
		$output .= "</div>";
	}
	$categories = tl_get_categories();
	if ($categories instanceof TalentLMS_ApiError) {
		$output .= "<div class='alert alert-error'>";
		$output .= $categories -> getMessage();
		$output .= "</div>";
	}
	include (_BASEPATH_ . '/templates/courses_list.php');

}
?>

