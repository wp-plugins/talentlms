<?php

$output .= "<div id='talentlms-course-container'>";

if ($_POST['action'] == "dialog-post") {
	try {
		if ($_POST['talentlms-dialog-login'] && $_POST['talentlms-dialog-password']) {
			$login = TalentLMS_User::login(array('login' => $_POST['talentlms-dialog-login'], 'password' => $_POST['talentlms-dialog-password']));
			session_start();
			$_SESSION['talentlms_user_id'] = $login['user_id'];
			$_SESSION['talentlms_user_pass'] = $_POST['talentlms-dialog-password'];
			$user = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
			unset($GLOBALS['talentlms_error_msg']);
			$output .= "<div class=\"alert alert-success\">";
			$output .= "<span style='display:block'>" . _('Welcome back') . " <strong>" . $user['first_name'] . " " . $user['last_name'] . "</strong></span>";
			$output .= "<span style='display:block'>" . _('You can visit your TalentLMS domain here: ') . " <a target='_blank' href='" . $login['login_key'] . "'>" . get_option('talent-domain') . "</a></span>";
			$output .= "</div>";
		} else {
			$output .= "<div class=\"alert alert-error\">";
			if (!$_POST['talentlms-dialog-login']) {
				$output .= "<span style='display: block;'><strong>" . _('Username cannot be empty') . "</strong></span>";
			}
			if (!$_POST['talentlms-dialog-password']) {
				$output .= "<span style='display: block;'><strong>" . _('Password cannot be empty') . "</strong></span>";
			}
			$output .= "</div>";
		}
	} catch (Exception $e) {
		if ($e instanceof TalentLMS_ApiError) {
			$output .= "<div class=\"alert alert-error\">";
			$output .= $e -> getMessage();
			$output .= "</div>";
		}
	}
}

$output .= "<div id='talentlms-course-top-details'>";
$output .= "<div id='talentlms-course-thumb'>";
if (strstr($course['big_avatar'], 'unknown_small')) {
	$output .= "<img title=\"" . $course['name'] . "\" alt=\"" . $course['name'] . "\" src=\"http://" . $course['big_avatar'] . "\">";
} else {
	$output .= "<img title=\"" . $course['name'] . "\" alt=\"" . $course['name'] . "\" src=\"" . $course['big_avatar'] . "\">";
}
$output .= "</div>";
$output .= "<div id=\"talentlms-course-details\">";
$output .= "<h2><span title=\"" . $course['name'] . "\">" . $course['name'] . "</span></h2>";
if ($course['category_id']) {
	$course_category = TalentLMS_Category::retrieve($course['category_id']);
	$output .= "<h3><span><strong>" . __('Category:') . "</strong></span>" . $course_category['name'] . "</h3>";
	if(get_option('talentlms-show-course-price')){
		$price = (preg_replace("/\D+/", "", html_entity_decode($course['price'])) == 0) ? '-' : $course['price'];
		$output .= "<h3><span><strong>" . __('Price: ') . "</strong></span>" . $price . "</h3>";
	}
}
$output .= "</div>";
$output .= "<div class=\"clear\"></div>";
$output .= "</div>";

$output .= "<div class=\"talentlms-course-bottom-details\">";

if ($course['description'] && get_option('talentlms-show-course-description')) {
	$output .= "<div id=\"talentlms-course-description\">";
	$output .= "<h2>" . __('Description:') . "</h2>";
	$output .= "<p>" . $course['description'] . "</p>";
	$output .= "</div>";
}

if(is_array($course['users']) && get_option('talentlms-show-course-instructor')) {
	$output .= "<div id=\"talentlms-course-instructors\">";
	$output .= "<h2>" . __('Course Instructors:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['users'] as $course_user) {
		if($course_user['role'] == 'instructor'){
			$output .= "<li>" . $course_user['name'] . "</li>";
		}
	}
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['units'] && get_option('talentlms-show-course-units')) {
	$output .= "<div id=\"talentlms-course-content\">";
	$output .= "<h2>" . __('Content:') . "</h2>";
	$output .= "<ul>";
	if (isset($_SESSION['talentlms_user_id'])) {
		foreach ($course['units'] as $unit) {
			$output .= "<li><a href=\"".$unit['url']."\" target=\"_blank\">" . $unit['name'] . "</a></li>";
		}				
	} else {
		foreach ($course['units'] as $unit) {
			$output .= "<li>" . $unit['name'] . "</li>";
		}		
	}
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['rules'] && get_option('talentlms-show-course-rules')) {
	$output .= "<div id=\"talentlms-course-completionrules\">";
	$output .= "<h2>" . __('Completion rules:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['rules'] as $rule) {
		$output .= "<li>" . $rule . "</li>";
	}
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['prerequisites'] && get_option('talentlms-show-course-prerequisites')) {
	$output .= "<div id=\"talentlms-course-prerequisites\">";
	$output .= "<h2>" . __('Prerequisites:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['prerequisites'] as $prerequisite) {
		$output .= "<li><a href=\"?course=" . $prerequisite['course_id'] . "\">" . $prerequisite['course_name'] . "</a></li>";
	}
	$output .= "</ul>";
	$output .= "</div>";
}

$output .= "</div>";

$output .= "<div id=\"talentlms-course-user-actions\">";
if ($course['shared']) {
	$output .= "<a class=\"btn\" href=\"" . $course['shared_url'] . "\">" . __('View course') . "</a>";
} else {
	if (isset($_SESSION['talentlms_user_id'])) {
		$user = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
		$user_courses = array();
		foreach ($user['courses'] as $c) {
			$user_courses[] = $c['id'];
		}
		if (!in_array($_GET['course'], $user_courses)) {
			$output .= "<form class=\"form-horizontal\" method=\"post\" action=\"" . $_SERVER['REDIRECT_URL'] . "?" . $_SERVER['QUERY_STRING'] . "\">";
			$output .= "<input name=\"talent-get-course\" type=\"hidden\" value=\"" . $_GET['course'] . "\">";
			$output .= "<input name=\"talent-course-price\" type=\"hidden\" value=\"" . $course['price'] . "\">";
			$output .= "<button class=\"btn\" type=\"submit\">" . _('Get this course') . "</button>" . _('or') . " <a href=\"javascript:history.go(-1);\">" . _('Go Back') . "</a>";
			$output .= "</form>";
		} else {
			try {
				$urltoCourse = TalentLMS_Course::gotoCourse(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $course['id']));
			} catch(Exception $e) {
			}

			$output .= "<a class=\"btn\" href=\"" . $urltoCourse['goto_url'] . "\" target=\"_blank\">" . __('View this course') . "</a> " . _('or') . "<a href=\"javascript:history.go(-1);\">" . _('Go Back') . "</a>";

		}
	} else {
		$output .= "<a id=\"talentlms-login-dialog-opener\" class=\"btn\" href=\"javascript:void(0);\">" . __('Login to get this course') . "</a> " . _('or') . " <a href=\"javascript:history.go(-1);\">" . _('Go Back') . "</a>";
	}
}
$output .= "</div>";

$output .= "<div id=\"talentlms-dialog-form\" title=\"" . __('Login') . "\">";
$output .= "<form id=\"talentlms-dialog-login-form\" name=\"talentlms-dialog-login-form\" method=\"post\" action=\"" . htmlentities($_SERVER['REQUEST_URI']) . "\">";
$output .= "<input type=\"hidden\" name=\"action\" value=\"dialog-post\">";
$output .= "<fieldset>";
$output .= "<div class=\"talentlms-form-group\">";
$output .= "<label class=\"talentlms-form-label\" for=\"talentlms-dialog-login\">" . __('Username:') . "</label>";
$output .= "<div class=\"talentlms-form-control\">";
$output .= "<input type=\"text\" name=\"talentlms-dialog-login\" id=\"talentlms-dialog-login\" value=\"" . $_POST['talentlms-dialog-login'] . "\" />";
$output .= "</div>";
$output .= "</div>";
$output .= "<div class=\"talentlms-form-group\">";
$output .= "<label class=\"talentlms-form-label\" for=\"talentlms-dialog-password\">" . __('Password:') . "</label>";
$output .= "<div class=\"talentlms-form-control\">";
$output .= "<input type=\"password\" name=\"talentlms-dialog-password\" id=\"talentlms-dialog-password\" value=\"" . $_POST['talentlms-dialog-password'] . "\" />";
$output .= "</div>";
$output .= "</div>";
$output .= "</fieldset>";
$output .= "</form>";
$output .= "</div>";

$output .= "<script type=\"text/javascript\">";
$output .= "jQuery(document).ready(function() {";
$output .= "jQuery(\"#talentlms-dialog-form\").dialog({";
$output .= "width : 350,";
$output .= "modal : true,";
$output .= "autoOpen : false,";
$output .= "buttons : {";
$output .= "\"Login\" : function() {";
$output .= "jQuery('#talentlms-dialog-login-form').submit();";
$output .= "},";
$output .= "Cancel : function() {";
$output .= "jQuery(this).dialog(\"close\");";
$output .= "}";
$output .= "},";
$output .= "});";
$output .= "});";

$output .= "jQuery(\"#talentlms-login-dialog-opener\").click(function() {";
$output .= "jQuery(\"#talentlms-dialog-form\").dialog(\"open\");";
$output .= "return false;";
$output .= "});";
$output .= "</script>";

$output .= "</div>";
?>