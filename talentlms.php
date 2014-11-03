<?php
/*
 Plugin Name: TalentLMS
 Plugin URI: http://wordpress.org/extend/plugins/talentlms/
 Description: This plugin integrates Talentlms with Wordpress. Promote your TalentLMS content through your WordPress site.
 Version: 3.17.1
 Author: Vasilis Proutzos / Epignosis LTD
 Author URI: www.talentlms.com
 License: GPL2
 */

define("_VERSION_", "3.17");
define("_BASEPATH_", dirname(__FILE__));
define("_BASEURL_", plugin_dir_url(__FILE__));

require_once (_BASEPATH_ . '/TalentLMSLib/lib/TalentLMS.php');
require_once (_BASEPATH_ . '/utils/utils.php');
require_once (_BASEPATH_ . '/utils/db.php');
require_once (_BASEPATH_ . '/admin/admin.php');
require_once (_BASEPATH_ . '/widgets/reg_widgets.php');

function start_talentlms_session() {
	if (!session_id()) {
		session_start();
	}
}

add_action('init', 'start_talentlms_session', 1);

function tl_install() {
	tl_db_setup();
	tl_add_options();
	tl_add_wp_pages();
}

register_activation_hook(__FILE__, 'tl_install');

function tl_uninstall() {
	tl_delete_options();
	tl_db_drop();
	tl_delete_wp_pages();
}

register_deactivation_hook(__FILE__, 'tl_uninstall');

function tl_add_wp_pages() {
	tl_add_courses_page();
	tl_add_users_page();
	tl_add_signup_page();
	tl_add_forgot_credentials_page();
	tl_add_login_page();
}

function tl_delete_wp_pages() {
	tl_delete_courses_page();
	tl_delete_users_page();
	tl_delete_signup_page();
	tl_delete_forgot_credentials_page();
	tl_delete_login_page();
}

function tl_add_courses_page() {
	global $wpdb;

	$the_page_title = 'Courses';
	$the_page_name = 'courses';

	delete_option("tl_courses_page_title");
	add_option("tl_courses_page_title", $the_page_title, '', 'yes');
	delete_option("tl_courses_page_name");
	add_option("tl_courses_page_name", $the_page_name, '', 'yes');
	delete_option("tl_courses_page_id");
	add_option("tl_courses_page_id", '0', '', 'yes');

	$the_page = get_page_by_title($the_page_title);
	if (!$the_page) {
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[talentlms-courses]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);
		$the_page_id = wp_insert_post($_p);
	} else {
		$the_page_id = $the_page -> ID;
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}
	delete_option('tl_courses_page_id');
	add_option('tl_courses_page_id', $the_page_id);
}

function tl_add_signup_page() {
	global $wpdb;

	$the_page_title = 'Signup';
	$the_page_name = 'signup';

	delete_option("tl_signup_page_title");
	add_option("tl_signup_page_title", $the_page_title, '', 'yes');
	delete_option("tl_signup_page_name");
	add_option("tl_signup_page_name", $the_page_name, '', 'yes');
	delete_option("tl_signup_page_id");
	add_option("tl_signup_page_id", '1', '', 'yes');

	$the_page = get_page_by_title($the_page_title);
	if (!$the_page) {
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[talentlms-signup]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);
		$the_page_id = wp_insert_post($_p);
	} else {
		$the_page_id = $the_page -> ID;
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}
	delete_option('tl_signup_page_id');
	add_option('tl_signup_page_id', $the_page_id);
}

function tl_add_users_page() {
	global $wpdb;

	$the_page_title = 'Users';
	$the_page_name = 'users';

	delete_option("tl_users_page_title");
	add_option("tl_users_page_title", $the_page_title, '', 'yes');
	delete_option("tl_users_page_name");
	add_option("tl_users_page_name", $the_page_name, '', 'yes');
	delete_option("tl_users_page_id");
	add_option("tl_users_page_id", '2', '', 'yes');

	$the_page = get_page_by_title($the_page_title);
	if (!$the_page) {
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[talentlms-users]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);
		$the_page_id = wp_insert_post($_p);
	} else {
		$the_page_id = $the_page -> ID;
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}
	delete_option('tl_users_page_id');
	add_option('tl_users_page_id', $the_page_id);
}

function tl_add_forgot_credentials_page() {
	global $wpdb;

	$the_page_title = 'Forgot Login / Password??';
	$the_page_name = 'forgot-login-password';
	
	delete_option("tl_forgot_page_title");
	add_option("tl_forgot_page_title", $the_page_title, '', 'yes');
	delete_option("tl_forgot_page_name");
	add_option("tl_forgot_page_name", $the_page_name, '', 'yes');
	delete_option("tl_forgot_page_id");
	add_option("tl_forgot_page_id", '0', '', 'yes');
	
	$the_page = get_page_by_title($the_page_title);
	if (!$the_page) {
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[talentlms-forgot-credentials]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);
		$the_page_id = wp_insert_post($_p);
	} else {
		$the_page_id = $the_page -> ID;
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}
	delete_option('tl_forgot_page_id');
	add_option('tl_forgot_page_id', $the_page_id);	
	
}

function tl_add_login_page() {
	global $wpdb;
	
	$the_page_title = 'Login to TalentLMS??';
	$the_page_name = 'login-talentlms';
	
	delete_option("tl_login_talentlms_page_title");
	add_option("tl_login_talentlms_page_title", $the_page_title, '', 'yes');
	delete_option("tl_login_talentlms_page_name");
	add_option("tl_login_talentlms_page_name", $the_page_name, '', 'yes');
	delete_option("tl_login_talentlms_page_id");
	add_option("tl_login_talentlms_page_id", '0', '', 'yes');
	
	$the_page = get_page_by_title($the_page_title);
	if (!$the_page) {
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[talentlms-login]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);
		$the_page_id = wp_insert_post($_p);
	} else {
		$the_page_id = $the_page -> ID;
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}
	delete_option('tl_login_talentlms_page_id');
	add_option('tl_login_talentlms_page_id', $the_page_id);	
}

function tl_delete_courses_page() {
	global $wpdb;

	$the_page_title = get_option("tl_courses_page_title");
	$the_page_name = get_option("tl_courses_page_name");
	$the_page_id = get_option('tl_courses_page_id');
	if ($the_page_id) {
		wp_delete_post($the_page_id);
	}
	delete_option("tl_courses_page_title");
	delete_option("tl_courses_page_name");
	delete_option("tl_courses_page_id");
}

function tl_delete_signup_page() {
	global $wpdb;

	$the_page_title = get_option("tl_signup_page_title");
	$the_page_name = get_option("tl_signup_page_name");
	$the_page_id = get_option('tl_signup_page_id');
	if ($the_page_id) {
		wp_delete_post($the_page_id);
	}
	delete_option("tl_signup_page_title");
	delete_option("tl_signup_page_name");
	delete_option("tl_signup_page_id");
}

function tl_delete_users_page() {
	global $wpdb;

	$the_page_title = get_option("tl_users_page_title");
	$the_page_name = get_option("tl_users_page_name");
	$the_page_id = get_option('tl_users_page_id');
	if ($the_page_id) {
		wp_delete_post($the_page_id);
	}
	delete_option("tl_users_page_title");
	delete_option("tl_users_page_name");
	delete_option("tl_users_page_id");
}

function tl_delete_forgot_credentials_page() {
	global $wpdb;

	$the_page_title = get_option("tl_forgot_page_title");
	$the_page_name = get_option("tl_forgot_page_name");
	$the_page_id = get_option('tl_forgot_page_id');
	if ($the_page_id) {
		wp_delete_post($the_page_id);
	}
	delete_option("tl_forgot_page_title");
	delete_option("tl_forgot_page_name");
	delete_option("tl_forgot_page_id");	
}

function tl_delete_login_page() {
	global $wpdb;
	
	$the_page_title = get_option("tl_login_talentlms_page_title");
	$the_page_name = get_option("tl_login_talentlms_page_name");
	$the_page_id = get_option('tl_login_talentlms_page_id');
	if ($the_page_id) {
		wp_delete_post($the_page_id);
	}
	delete_option("tl_login_talentlms_page_title");
	delete_option("tl_login_talentlms_page_name");
	delete_option("tl_login_talentlms_page_id");	
}

function tl_add_options() {
	update_option('tl-logout', 'WP');
	
	/* Courses Page */
	update_option('tl-courses-page-template', 'tl-courses-page-template-pagination');
		
	update_option('tl-courses-page-pagination-template', 'tl-categories-right');	
	update_option('tl-courses-page-pagination-template-courses-per-page', 10);
	update_option('tl-courses-page-pagination-template-top-pagination', false);
	update_option('tl-courses-page-pagination-template-bottom-pagination', true);
	update_option('tl-courses-page-pagination-template-show-course-list-thumb', true);
	update_option('tl-courses-page-pagination-template-show-course-list-descr', true);
	update_option('tl-courses-page-pagination-template-show-course-list-descr-limit', '');
	update_option('tl-courses-page-pagination-template-show-course-list-price', true);
	
	/* Single course page */
	update_option('tl-single-course-page-template-show-course-descr', true);
	update_option('tl-single-course-page-template-show-course-price', true);
	update_option('tl-single-course-page-template-show-course-instructor', true);
	update_option('tl-single-course-page-template-show-course-units', true);
	update_option('tl-single-course-page-template-show-course-rules', true);
	update_option('tl-single-course-page-template-show-course-prerequisites', true);

	/* Users page */
	update_option('tl-users-page-template-show-user-list-avatar', true);
	update_option('tl-users-page-template-show-user-list-bio', true);
	update_option('tl-users-page-template-show-user-list-bio-limit', '');
	update_option('tl-users-page-template-users-per-page', 10);
	update_option('tl-users-page-template-users-top-pagination', false);
	update_option('tl-users-page-template-users-bottom-pagination', true);	
	
	/* Single user page */
	update_option('tl-single-user-page-template-show-user-bio', true);
	update_option('tl-single-user-page-template-show-user-email', true);
	update_option('tl-single-user-page-template-show-user-courses', true);

	/* Groups page */
	update_option('tl-groups-page-template-groups-per-page', 10);
	update_option('tl-groups-page-template-groups-top-pagination', true);
	update_option('tl-groups-page-template-groups-bottom-pagination', true);
	
	/* Signup page*/
	update_option('tl-signup-page-post-signup', 'redirect');
	update_option('tl-singup-page-sync-signup', true);
	update_option('tl-singup-page-sync-signup-2', true);
	
}

function tl_delete_options() {
	delete_option('tl-logout', 'WP');
	
	/* Courses Page */
	delete_option('tl-courses-page-template', 'tl-courses-page-template-pagination');
		
	delete_option('tl-courses-page-pagination-template', 'tl-categories-right');	
	delete_option('tl-courses-page-pagination-template-courses-per-page', 10);
	delete_option('tl-courses-page-pagination-template-top-pagination', false);
	delete_option('tl-courses-page-pagination-template-bottom-pagination', true);
	delete_option('tl-courses-page-pagination-template-show-course-list-thumb', true);
	delete_option('tl-courses-page-pagination-template-show-course-list-descr', true);
	delete_option('tl-courses-page-pagination-template-show-course-list-descr-limit', '');
	delete_option('tl-courses-page-pagination-template-show-course-list-price', true);
	
	/* Single course page */
	delete_option('tl-single-course-page-template-show-course-descr', true);
	delete_option('tl-single-course-page-template-show-course-price', true);
	delete_option('tl-single-course-page-template-show-course-instructor', true);
	delete_option('tl-single-course-page-template-show-course-units', true);
	delete_option('tl-single-course-page-template-show-course-rules', true);
	delete_option('tl-single-course-page-template-show-course-prerequisites', true);

	/* Users page */
	delete_option('tl-users-page-template-show-user-list-avatar', true);
	delete_option('tl-users-page-template-show-user-list-bio', true);
	delete_option('tl-users-page-template-show-user-list-bio-limit', '');
	delete_option('tl-users-page-template-users-per-page', 10);
	delete_option('tl-users-page-template-users-top-pagination', false);
	delete_option('tl-users-page-template-users-bottom-pagination', true);	
	
	/* Single user page */
	delete_option('tl-single-user-page-template-show-user-bio', true);
	delete_option('tl-single-user-page-template-show-user-email', true);
	delete_option('tl-single-user-page-template-show-user-courses', true);

	/* Groups page */
	delete_option('tl-groups-page-template-groups-per-page');
	delete_option('tl-groups-page-template-groups-top-pagination');
	delete_option('tl-groups-page-template-groups-bottom-pagination');

	/* Signup page*/
	delete_option('tl-signup-page-post-signup', 'redirect');
	delete_option('tl-singup-page-sync-signup', true);
	delete_option('tl-singup-page-sync-signup-2', true);
}
?>
