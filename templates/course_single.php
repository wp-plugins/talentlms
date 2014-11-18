<?php

$output = "<div id='tl-course-container'>";

if ($_POST['action'] == "tl-dialog-post") {
	try {
		if ($_POST['tl-dialog-login'] && $_POST['tl-dialog-password']) {
			$login = TalentLMS_User::login(array('login' => $_POST['tl-dialog-login'], 'password' => $_POST['tl-dialog-password'], 'logout_redirect' => (get_option('tl-logout') == 'WP') ? get_bloginfo('wpurl') : ''));
			session_start();
			$_SESSION['talentlms_user_id'] = $login['user_id'];
			$_SESSION['talentlms_user_login'] = $_POST['tl-dialog-login'];
			$_SESSION['talentlms_user_pass'] = $_POST['tl-dialog-password'];
			$user = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
			unset($GLOBALS['talentlms_error_msg']);
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

if (isset($_SESSION['talentlms_user_id'])) {
	try {
		$login = TalentLMS_User::login(array('login' => $_SESSION['talentlms_user_login'], 'password' => $_SESSION['talentlms_user_pass'], 'logout_redirect' => (get_option('tl-logout') == 'WP') ? get_bloginfo('wpurl') : ''));
	} catch(Exception $e) {
	}
}

$output .= "<div id='tl-course-top-details'>";
$output .= "<div id='tl-course-thumb'>";
$output .= "<img title='" . $course['name'] . "' alt='" . $course['name'] . "' src='" . $course['big_avatar'] . "'>";
$output .= "</div>";
$output .= "<div id='tl-course-details'>";
$output .= "<h2><span title='" . $course['name'] . "'>" . $course['name'] . "</span></h2>";
if ($course['category_id']) {
	$course_category = TalentLMS_Category::retrieve($course['category_id']);
	$output .= "<h3><span><strong>" . __('Category:') . "</strong></span>" . $course_category['name'] . "</h3>";
	if (get_option('tl-single-course-page-template-show-course-price')) {
		$price = (preg_replace("/\D+/", "", html_entity_decode($course['price'])) == 0) ? '-' : $course['price'];
		$output .= "<h3><span><strong>" . __('Price: ') . "</strong></span>" . $price . "</h3>";
	}
}
$output .= "</div>";
$output .= "<div class='clear'></div>";
$output .= "</div>";

$output .= "<div class='tl-course-bottom-details'>";

if ($course['description'] && get_option('tl-single-course-page-template-show-course-descr')) {
	$output .= "<div id='tl-course-description'>";
	$output .= "<h2>" . __('Description:') . "</h2>";
	$output .= "<p>" . $course['description'] . "</p>";
	$output .= "</div>";
}

if (is_array($course['users']) && get_option('tl-single-course-page-template-show-course-instructor')) {
	$output .= "<div id='tl-course-instructors'>";
	$output .= "<h2>" . __('Course Instructors:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['users'] as $course_user) {
		if ($course_user['role'] == 'instructor') {
			$output .= "<li>" . $course_user['name'] . "</li>";
		}
	}
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['units'] && get_option('tl-single-course-page-template-show-course-units')) {
	$output .= "<div id='tl-course-content'>";
	$output .= "<h2>" . __('Content:') . "</h2>";
	$output .= "<ul>";
	if (isset($_SESSION['talentlms_user_id'])) {
		foreach ($course['units'] as $unit) {
			$output .= "<li><a href='" . tl_talentlms_url($unit['url']) . tl_get_login_key($login['login_key']) . "' target='_blank'>" . $unit['name'] . "</a></li>";
		}
	} else {
		foreach ($course['units'] as $unit) {
			$output .= "<li>" . $unit['name'] . "</li>";
		}
	}
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['rules'] && get_option('tl-single-course-page-template-show-course-rules')) {
	$output .= "<div id='tl-course-completionrules'>";
	$output .= "<h2>" . __('Completion rules:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['rules'] as $rule) {
		$output .= "<li>" . $rule . "</li>";
	}
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['prerequisites'] && get_option('tl-single-course-page-template-show-course-prerequisites')) {
	$output .= "<div id='tl-course-prerequisites'>";
	$output .= "<h2>" . __('Prerequisites:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['prerequisites'] as $prerequisite) {
		$output .= "<li><a href='?tlcourse=" . $prerequisite['course_id'] . "'>" . $prerequisite['course_name'] . "</a></li>";
	}
	$output .= "</ul>";
	$output .= "</div>";
}

$output .= "</div>";

$output .= "<div id='tl-course-user-actions'>";
if ($course['shared']) {
	$output .= "<a class='btn' href='" . $course['shared_url'] . "'>" . __('View course') . "</a>";
} else {
	if (isset($_SESSION['talentlms_user_id'])) {
		$user = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
		$user_courses = array();
		foreach ($user['courses'] as $c) {
			$user_courses[] = $c['id'];
		}
		if (!in_array($_GET['tlcourse'], $user_courses)) {
			$output .= "<form class='tl-form-horizontal' method='post' action='" . tl_current_page_url() . "'>";
			$output .= "<input name='talentlms-get-course' type='hidden' value='" . $_GET['tlcourse'] . "'>";
			$output .= "<input name='talentlms-course-price' type='hidden' value='" . $course['price'] . "'>";
			$output .= "<button class='btn' type='submit'>" . _('Get this course') . "</button>" . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
			$output .= "</form>";
		} else {
			try {
				$urltoCourse = TalentLMS_Course::gotoCourse(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $course['id']));
			} catch(Exception $e) {
			}

			$output .= "<a class='btn' href='" . tl_talentlms_url($urltoCourse['goto_url']) . "' target='_blank'>" . __('View this course') . "</a> " . _('or') . "<a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";

		}
	} else {
		$output .= "<a id='tl-login-dialog-opener' class='btn' href='javascript:void(0);'>" . __('Login to get this course') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
	}
}
$output .= "</div>";
include (_BASEPATH_ . '/templates/talentlms-login-dialog.php');
$output .= "</div>";
?>