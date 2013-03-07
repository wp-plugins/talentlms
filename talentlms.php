<?php
/*
 Plugin Name: TalentLMS
 Plugin URI: http://wordpress.org/extend/plugins/talentlms/
 Description: This plugin integrates Talentlms with Wordpress. Promote your TalentLMS content through your WordPress site.
 Version: 2.2.2
 Author: Vasilis Proutzos / Epignosis LTD
 Author URI: www.talentlms.com
 License: GPL2
 */

define("_VERSION_", "2.2.2");
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

function install() {
	talentlms_db_create();
	talentlms_add_options();
	talentlms_add_wp_pages();
}

register_activation_hook(__FILE__, 'install');

function uninstall() {
	talentlms_delete_options();
	talentlms_db_drop();
	talentlms_delete_wp_pages();
}

register_deactivation_hook(__FILE__, 'uninstall');

function talentlms_add_wp_pages() {
	talentlms_add_courses_page();
	talentlms_add_signup_page();
	talentlms_add_users_page();
}

function talentlms_delete_wp_pages() {
	talentlms_delete_courses_page();
	talentlms_delete_signup_page();
	talentlms_delete_users_page();
}

function talentlms_add_courses_page() {
	global $wpdb;

	$the_page_title = 'Courses';
	$the_page_name = 'courses';

	// the menu entry...
	delete_option("talentlms_courses_page_title");
	add_option("talentlms_courses_page_title", $the_page_title, '', 'yes');
	// the slug...
	delete_option("talentlms_courses_page_name");
	add_option("talentlms_courses_page_name", $the_page_name, '', 'yes');
	// the id...
	delete_option("talentlms_courses_page_id");
	add_option("talentlms_courses_page_id", '0', '', 'yes');

	$the_page = get_page_by_title($the_page_title);

	if (!$the_page) {
		// Create post object
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[talentlms-courses]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);

		// Insert the post into the database
		$the_page_id = wp_insert_post($_p);

	} else {
		$the_page_id = $the_page -> ID;
		//make sure the page is not trashed...
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}

	delete_option('talentlms_courses_page_id');
	add_option('talentlms_courses_page_id', $the_page_id);
}

function talentlms_add_signup_page() {
	global $wpdb;

	$the_page_title = 'Signup';
	$the_page_name = 'signup';

	// the menu entry...
	delete_option("talentlms_signup_page_title");
	add_option("talentlms_signup_page_title", $the_page_title, '', 'yes');
	// the slug...
	delete_option("talentlms_signup_page_name");
	add_option("talentlms_signup_page_name", $the_page_name, '', 'yes');
	// the id...
	delete_option("talentlms_signup_page_id");
	add_option("talentlms_signup_page_id", '1', '', 'yes');

	$the_page = get_page_by_title($the_page_title);

	if (!$the_page) {
		// Create post object
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[talentlms-signup]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);

		// Insert the post into the database
		$the_page_id = wp_insert_post($_p);

	} else {
		$the_page_id = $the_page -> ID;
		//make sure the page is not trashed...
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}

	delete_option('talentlms_signup_page_id');
	add_option('talentlms_signup_page_id', $the_page_id);
}

function talentlms_add_users_page() {
	global $wpdb;

	$the_page_title = 'Users';
	$the_page_name = 'users';

	// the menu entry...
	delete_option("talentlms_users_page_title");
	add_option("talentlms_users_page_title", $the_page_title, '', 'yes');
	// the slug...
	delete_option("talentlms_users_page_name");
	add_option("talentlms_users_page_name", $the_page_name, '', 'yes');
	// the id...
	delete_option("talentlms_users_page_id");
	add_option("talentlms_users_page_id", '2', '', 'yes');

	$the_page = get_page_by_title($the_page_title);

	if (!$the_page) {
		// Create post object
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[talentlms-users]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);

		// Insert the post into the database
		$the_page_id = wp_insert_post($_p);

	} else {
		$the_page_id = $the_page -> ID;
		//make sure the page is not trashed...
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}

	delete_option('talentlms_users_page_id');
	add_option('talentlms_users_page_id', $the_page_id);
}

function talentlms_delete_courses_page() {
	global $wpdb;

	$the_page_title = get_option("talentlms_courses_page_title");
	$the_page_name = get_option("talentlms_courses_page_name");

	//  the id of our page...
	$the_page_id = get_option('talentlms_courses_page_id');
	if ($the_page_id) {

		wp_delete_post($the_page_id);
		// this will trash, not delete

	}

	delete_option("talentlms_courses_page_title");
	delete_option("talentlms_courses_page_name");
	delete_option("talentlms_courses_page_id");
}

function talentlms_delete_signup_page() {
	global $wpdb;

	$the_page_title = get_option("talentlms_signup_page_title");
	$the_page_name = get_option("talentlms_signup_page_name");

	//  the id of our page...
	$the_page_id = get_option('talentlms_signup_page_id');
	if ($the_page_id) {

		wp_delete_post($the_page_id);
		// this will trash, not delete

	}

	delete_option("talentlms_signup_page_title");
	delete_option("talentlms_signup_page_name");
	delete_option("talentlms_signup_page_id");
}

function talentlms_delete_users_page() {
	global $wpdb;

	$the_page_title = get_option("talentlms_users_page_title");
	$the_page_name = get_option("talentlms_users_page_name");

	//  the id of our page...
	$the_page_id = get_option('talentlms_users_page_id');
	if ($the_page_id) {

		wp_delete_post($the_page_id);
		// this will trash, not delete

	}

	delete_option("talentlms_users_page_title");
	delete_option("talentlms_users_page_name");
	delete_option("talentlms_users_page_id");
}

function talentlms_add_options() {
	update_option('talentlms-caching-enabled', '1');
	update_option('talentlms-courses-template', 'categories-right-courses-left');
	update_option('talentlms-after-signup', 'redirect');

	update_option('talentlms-show-course-description', 1);
	update_option('talentlms-show-course-price', 1);
	update_option('talentlms-show-course-instructor', 1);
	update_option('talentlms-show-course-units', 1);
	update_option('talentlms-show-course-rules', 1);
	update_option('talentlms-show-course-prerequisites', 1);

	update_option('talentlms-show-course-list-thumb', 1);
	update_option('talentlms-show-course-list-description', 1);
	update_option('talentlms-show-course-list-description-limit', '');
	update_option('talentlms-show-course-list-price', 1);

	update_option('talentlms-show-user-list-avatar', 1);
	update_option('talentlms-show-user-list-bio', 1);
	update_option('talentlms-show-user-list-bio-limit', '');
	
	update_option('talentlms-show-user-bio', 1);
	update_option('talentlms-show-user-email', 1);
	update_option('talentlms-show-user-courses', 1);

	update_option('talentlms-courses-per-page', 10);
	update_option('talentlms-courses-bottom-pagination', 1);
}

function talentlms_delete_options() {
	delete_option('talentlms-api-key');
	delete_option('talentlms-domain');
	delete_option('talentlms-domain-map');

	delete_option('talentlms-caching-enabled');
	delete_option('talentlms-courses-template');
	delete_option('talentlms-after-signup');

	delete_option('talentlms-show-course-description');
	delete_option('talentlms-show-course-price');
	delete_option('talentlms-show-course-instructor');
	delete_option('talentlms-show-course-units');
	delete_option('talentlms-show-course-rules');
	delete_option('talentlms-show-course-prerequisites');

	delete_option('talentlms-show-course-list-thumb');
	delete_option('talentlms-show-course-list-description');
	delete_option('talentlms-show-course-list-description-limit');
	delete_option('talentlms-show-course-list-price');

	delete_option('talentlms-show-user-list-avatar');
	delete_option('talentlms-show-user-list-bio');
	delete_option('talentlms-show-user-list-bio-limit');
	
	delete_option('talentlms-show-user-bio');
	delete_option('talentlms-show-user-email');
	delete_option('talentlms-show-user-courses');

	delete_option('talentlms-courses-per-page');
	delete_option('talentlms-courses-top-pagination');
	delete_option('talentlms-courses-bottom-pagination');
}
?>
