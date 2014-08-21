<?php
function talentlms_course_list($atts) {
	wp_enqueue_style("jquery-ui-css", "http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css");

	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-dialog');

	include (_BASEPATH_ . '/shortcodes/talentlms_courses.php');
	return $output;
}

add_shortcode('talentlms-courses', 'talentlms_course_list');

function talentlms_signup($atts) {
	include (_BASEPATH_ . '/shortcodes/talentlms_signup.php');
	return $output;
}

add_shortcode('talentlms-signup', 'talentlms_signup');

function talentlms_users($atts) {
	include (_BASEPATH_ . '/shortcodes/talentlms_users.php');
	return $output;
}

add_shortcode('talentlms-users', 'talentlms_users');

/*
function talentlms_groups() {
	wp_enqueue_style("jquery-ui-css", "http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css");
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('tl-groups', _BASEURL_ . 'js/tl-groups.js', false, '1.0');

	include (_BASEPATH_ . '/shortcodes/talentlms_groups.php');
	return $output;
}

add_shortcode('talentlms-groups', 'talentlms_groups');
 */
function talentlms_forgot_credentials($atts) {
	wp_enqueue_script('tl-forgot', _BASEURL_ . 'js/tl-forgot.js', false, '1.0');
	
	include (_BASEPATH_ . '/shortcodes/talentlms_forgot_credentials.php');
	return $output;
}

add_shortcode('talentlms-forgot-credentials', 'talentlms_forgot_credentials');
?>