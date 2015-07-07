<?php

function talentlms_course_list($atts) {
	wp_enqueue_style("jquery-ui-css", "http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css");
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-dialog');

	wp_enqueue_script('tl-datatables-js', '//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js');
	wp_enqueue_script('tl-datatables-bootstrap-js', '//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js');
	wp_enqueue_style('tl-datatables-css', '//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css');
	
	
	
	wp_enqueue_script('tl-course-list', _BASEURL_ . 'js/tl-course-list.js', false, '1.0');
	wp_enqueue_script('tl-jquery-dialogOptions', _BASEURL_ . 'utils/jquery.dialogOptions.js');
	//wp_enqueue_style('jquery-ui-bootstrap', _BASEURL_ . 'utils/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.0.custom.css', false);
	
	include (_BASEPATH_ . '/shortcodes/talentlms_courses.php');
	return $output;
}

add_shortcode('talentlms-courses', 'talentlms_course_list');

function talentlms_signup($atts) {
	include (_BASEPATH_ . '/shortcodes/talentlms_signup.php');
	return $output;
}

add_shortcode('talentlms-signup', 'talentlms_signup');

function talentlms_forgot_credentials($atts) {
	wp_enqueue_script('tl-forgot', _BASEURL_ . 'js/tl-forgot.js', false, '1.0');
	
	include (_BASEPATH_ . '/shortcodes/talentlms_forgot_credentials.php');
	return $output;
}

add_shortcode('talentlms-forgot-credentials', 'talentlms_forgot_credentials');

function talentlms_login($atts) {
	include (_BASEPATH_ . '/shortcodes/talentlms_login.php');
	return $output;
}
add_shortcode('talentlms-login', 'talentlms_login');
?>