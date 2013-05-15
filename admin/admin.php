<?php
/**
 *
 * Administration Menus
 *
 * @package TalentLMS plugin
 * @author V.
 * @copyright 2012
 * @access public
 * @since 1.0
 *
 */
?>
<?php

function register_admininstartion_pages() {
	global $tl_admin_page, $tl_options_page, $tl_sync_page, $tl_css_page;

	$tl_admin_page = add_menu_page(__('TalentLMS'), __('TalentLMS'), 'manage_options', 'talentlms', 'talentlms_admin');
	$tl_options_page = add_submenu_page('talentlms', __('TalentLMS Options'), __('TalentLMS Options'), 'manage_options', 'talentlms-options', 'talentlms_options');
	$tl_sync_page = add_submenu_page('talentlms', __('TalentLMS Sync'), __('TalentLMS Sync'), 'manage_options', 'talentlms-sync', 'talentlms_sync');
	$tl_css_page = add_submenu_page('talentlms', __('Edit TalentLMS CSS'), __('Edit TalentLMS CSS'), 'manage_options', 'talentlms-edit-css', 'talentlms_edit_css');

	add_action("admin_print_scripts-$tl_options_page", 'enqueueJsScripts');
	add_action("admin_print_styles-$tl_sync_page", 'enqueueCssScripts');
	add_action("admin_print_styles-$tl_css_page", 'enqueueCssScripts');
}

add_action('admin_menu', 'register_admininstartion_pages');

function enqueueJsScripts() {
	wp_enqueue_script('tl-admin', _BASEURL_ . 'js/tl-admin.js', false, '1.0');
}

function enqueueCssScripts() {
	wp_enqueue_style("talentlms-admin-style", _BASEURL_ . 'css/talentlms-admin-style.css', false, 1.0);
}

function talentlms_help($contextual_help, $screen_id, $screen) {
	global $tl_admin_page, $tl_options_page, $tl_sync_page, $tl_css_page;
	include (_BASEPATH_ . '/admin/pages/talentlms_help.php');
}

add_filter('contextual_help', 'talentlms_help', 10, 3);

function talentlms_admin() {
	if ($_POST['action'] == "tl-setup") {

		if ($_POST['tl-domain'] && $_POST['tl-api-key']) {
			$set = true;

			if (!tl_is_domain($_POST['tl-domain'])) {
				$action_status = "error";
				$action_message = $_POST['tl-domain'] . ': ' . _('is not a valid TalentLMS domain');
				$set = false;
			}

			if (!tl_is_api_key($_POST['tl-api-key'])) {
				$action_status = "error";
				$action_message = _('API key seems to be invalid');
				$set = false;
			}

			if ($set) {
				TalentLMS::setDomain($_POST['tl-domain']);
				TalentLMS::setApiKey($_POST['tl-api-key']);

				try {
					$site_info = TalentLMS_Siteinfo::get();
					if ($site_info['domain_map']) {
						update_option('talentlms-domain-map', $site_info['domain_map']);
					}
				} catch(Exception $e) {
					if ($e instanceof TalentLMS_ApiError) {
						$action_status = "error";
						$action_message = $e -> getMessage() . " " . $e -> getHttpStatus() . " " . $e -> getHttpBody() . " " . $e -> getJsonBody();
					}
				}

				update_option('talentlms-domain', $_POST['tl-domain']);
				update_option('talentlms-api-key', $_POST['tl-api-key']);

				tl_empty_cache();

				$action_status = "updated";
				$action_message = _('Details edited successfully');
			}
		} else {
			$action_status = "error";

			if (!$_POST['talentlms_domain']) {
				$domain_validation = 'form-invalid';
				$action_message = _('TalentLMS Domain required') . "<br />";
				update_option('talentlms-domain', '');
			}

			if (!$_POST['api_key']) {
				$api_validation = 'form-invalid';
				$action_message .= _('TalentLMS API key required') . "<br />";
				update_option('talentlms-api-key', '');
			}
		}
	}

	if ($_POST['action'] == "tl-cache") {
		tl_empty_cache();
		$action_status = "updated";
		$action_message = _('TalentLMS cache cleared');
	}

	include (_BASEPATH_ . '/admin/pages/talentlms_admin.php');
}

function talentlms_options() {

	if ($_POST['action'] == "tl-setup-templates") {
		$action_status = "updated";
		$action_message = _('Details edited successfully');

		update_option('tl-logout', $_POST['tl-logout']);

		update_option('tl-courses-page-template', $_POST['tl-courses-page-template']);
		update_option('tl-courses-page-pagination-template', $_POST['tl-courses-page-pagination-template']);

		// Courses page template with pagination
		if ($_POST['tl-courses-page-pagination-template-courses-per-page']) {
			if ($_POST['tl-courses-page-pagination-template-courses-per-page'] > 0) {
				update_option('tl-courses-page-pagination-template-courses-per-page', $_POST['tl-courses-page-pagination-template-courses-per-page']);
			} else {
				$action_status = "error";
				$action_message = _('Courses per page must be a positive number.');
				update_option('tl-courses-page-pagination-template-courses-per-page', '');
				update_option('tl-courses-page-pagination-template-top-pagination', false);
				update_option('tl-courses-page-pagination-template-bottom-pagination', false);
			}
		} else {
			update_option('tl-courses-page-pagination-template-courses-per-page', '');
		}
		update_option('tl-courses-page-pagination-template-top-pagination', $_POST['tl-courses-page-pagination-template-top-pagination']);
		update_option('tl-courses-page-pagination-template-bottom-pagination', $_POST['tl-courses-page-pagination-template-bottom-pagination']);

		update_option('tl-courses-page-pagination-template-show-course-list-thumb', $_POST['tl-courses-page-pagination-template-show-course-list-thumb']);		
		update_option('tl-courses-page-pagination-template-show-course-list-descr', $_POST['tl-courses-page-pagination-template-show-course-list-descr']);
		if ($_POST['tl-courses-page-pagination-template-show-course-list-descr-limit']) {
			if ($_POST['tl-courses-page-pagination-template-show-course-list-descr-limit'] > 0) {
				update_option('tl-courses-page-pagination-template-show-course-list-descr-limit', $_POST['tl-courses-page-pagination-template-show-course-list-descr-limit']);
			} else {
				$action_status = "error";
				$action_message .= " " . _('Limim must be a positive number.');
				update_option('tl-courses-page-pagination-template-show-course-list-descr', '');
			}
		} else {
			update_option('tl-courses-page-pagination-template-show-course-list-descr-limit', '');
		}
		update_option('tl-courses-page-pagination-template-show-course-list-price', $_POST['tl-courses-page-pagination-template-show-course-list-price']);


		// single course template options
		update_option('tl-single-course-page-template-show-course-descr', $_POST['tl-single-course-page-template-show-course-descr']);
		update_option('tl-single-course-page-template-show-course-price', $_POST['tl-single-course-page-template-show-course-price']);
		update_option('tl-single-course-page-template-show-course-instructor', $_POST['tl-single-course-page-template-show-course-instructor']);
		update_option('tl-single-course-page-template-show-course-units', $_POST['tl-single-course-page-template-show-course-units']);
		update_option('tl-single-course-page-template-show-course-rules', $_POST['tl-single-course-page-template-show-course-rules']);
		update_option('tl-single-course-page-template-show-course-prerequisites', $_POST['tl-single-course-page-template-show-course-prerequisites']);

		// Users page template
		update_option('tl-users-page-template-show-user-list-avatar', $_POST['tl-users-page-template-show-user-list-avatar']);
		update_option('tl-users-page-template-show-user-list-bio', $_POST['tl-users-page-template-show-user-list-bio']);
		if ($_POST['tl-users-page-template-show-user-list-bio-limit']) {
			if ($_POST['tl-users-page-template-show-user-list-bio-limit'] > 0) {
				update_option('tl-users-page-template-show-user-list-bio-limit', $_POST['tl-users-page-template-show-user-list-bio-limit']);
			} else {
				$action_status = "error";
				$action_message .= " " . _('Limim must be a positive number.');
			}
		} else {
			update_option('tl-users-page-template-show-user-list-bio-limit', '');
		}

		if ($_POST['tl-users-page-template-users-per-page']) {
			if ($_POST['tl-users-page-template-users-per-page'] > 0) {
				update_option('tl-users-page-template-users-per-page', $_POST['tl-users-page-template-users-per-page']);
			} else {
				$action_status = "error";
				$action_message = _('Users per page must be a positive number.');
				update_option('tl-users-page-template-users-per-page', '');
				update_option('tl-users-page-template-users-top-pagination', false);
				update_option('tl-users-page-template-users-bottom-pagination', false);
			}
		} else {
			update_option('tl-users-page-template-users-per-page', '');
		}
		update_option('tl-users-page-template-users-top-pagination', $_POST['tl-users-page-template-users-top-pagination']);
		update_option('tl-users-page-template-users-bottom-pagination', $_POST['tl-users-page-template-users-bottom-pagination']);

		// Single user page template
		update_option('tl-single-user-page-template-show-user-bio', $_POST['tl-single-user-page-template-show-user-bio']);
		update_option('tl-single-user-page-template-show-user-email', $_POST['tl-single-user-page-template-show-user-email']);
		update_option('tl-single-user-page-template-show-user-courses', $_POST['tl-single-user-page-template-show-user-courses']);

		// Groups page template
		if ($_POST['tl-groups-page-template-groups-per-page']) {
			if ($_POST['tl-groups-page-template-groups-per-page'] > 0) {
				update_option('tl-groups-page-template-groups-per-page', $_POST['tl-groups-page-template-groups-per-page']);
			} else {
				$action_status = "error";
				$action_message = _('Groups per page must be a positive number.');
				update_option('tl-groups-page-template-groups-per-page', '');
				update_option('tl-groups-page-template-groups-top-pagination', false);
				update_option('tl-groups-page-template-groups-bottom-pagination', false);
			}
		} else {
			update_option('tl-groups-page-template-groups-per-page', '');
		}
		update_option('tl-groups-page-template-groups-top-pagination', $_POST['tl-groups-page-template-groups-top-pagination']);
		update_option('tl-groups-page-template-groups-bottom-pagination', $_POST['tl-groups-page-template-groups-bottom-pagination']);		

		// Signup page
		update_option('tl-signup-page-post-signup', $_POST['tl-signup-page-post-signup']);
		update_option('tl-singup-page-sync-signup', $_POST['tl-singup-page-sync-signup']);
	}

	include (_BASEPATH_ . '/admin/pages/talentlms_options.php');
}

function talentlms_edit_css() {
	if ($_POST['talentlms_edit_css']) {
		file_put_contents(_BASEPATH_ . '/css/talentlms-style.css', stripslashes($_POST['tl-edit-css']));
		$action_status = "updated";
		$action_message = _('Details edited successfully');
	}
	include (_BASEPATH_ . '/admin/pages/talentlms_edit_css.php');
}

function talentlms_sync() {
	
	if ($_POST['action'] == 'tl-sync-users') {
		$action_status = "updated";
		$action_message = _('Operation completed successfully');
			
		foreach ($tl_users as $user) {
			$wp_users[$user['login']]['login'] = $user['login'];
			$wp_users[$user['login']]['email'] = $user['email'];
			$wp_users[$user['login']]['first_name'] = $user['first_name'];
			$wp_users[$user['login']]['last_name'] = $user['last_name'];
		}
		
		$all_users =  array_merge($tl_users, $wp_users);
		$sync_errors = tl_sync_wp_tl_users($tl_users_to_wp, $wp_users_to_tl, $_POST['tl-hard-sync'], $all_users);

		extract(tl_list_wp_tl_users());

		if(is_array($sync_errors) && !empty($sync_errors)) {
			$action_status = "error";
			$action_message = _('Operation completed but some errors have occured');
		}		
	}	
	
	
			
	if($_POST['action'] == 'tl-sync-content'){
		tl_delete_wp_categories();
		$tl_categories = TalentLMS_Category::all();
		$tl_categories = tl_categories_tree($tl_categories);
		tl_create_wp_categories($tl_categories);

		tl_delete_wp_posts();
		
		$tl_categories = TalentLMS_Category::all();
		foreach ($tl_categories as $category) {
			$categories[$category['id']] = $category['name']; 
		}
		$tl_categories = $categories;
		
		$tl_courses = TalentLMS_Course::all();
		foreach ($tl_courses as $course) {
			$course['category'] = $tl_categories[$course['category_id']];	
			$courses[] = $course;
		}
		$tl_courses = $courses;
		
		$current_user = wp_get_current_user();
		foreach ($tl_courses as $course) {
			$post_id = tl_get_post_by_title($course['name']);
			$category_id = tl_get_wp_category_id($course['category']);
			$category_name = $course['category'];
			$category_link = get_category_link( $category_id );
			
			$course = TalentLMS_Course::retrieve($course['id']);
						
			include (_BASEPATH_ . '/templates/course_single_sync.php');
						
			$course_post = array(
				'ID'             => ($post_id->ID) ? $post_id->ID : '',
				'comment_status' => 'open',
				'ping_status'    => 'open',
				'post_author'    => $current_user->ID,
				'post_category'  => array($category_id),
				'post_content'   => $output,
				'post_date'      => date(),
				'post_status'    => 'publish',
				'post_title'     => $course['name'],
				'post_type'      => 'post',
			);
			
			$post_id = wp_insert_post($course_post);					
			tl_set_wp_post_featured_image($post_id, $course['big_avatar']);
			unset($course_post);
			unset($category_id);
			unset($output);
		}
		
		$action_status = "updated";
		$action_message = _('Operation completed successfully');
	}
	
	include (_BASEPATH_ . '/admin/pages/talentlms_sync.php');
}


if ((!get_option('talentlms-domain') && !$_POST['talentlms_domain']) || (!get_option('talentlms-api-key') && !$_POST['api_key'])) {
	function talentlms_warning() {
		echo "<div id='talentlms-warning' class='error fade'><p><strong>" . __('You need to specify a TalentLMS domain and a TalentLMS API key.') . "</strong> " . sprintf(__('You must <a href="%1$s">enter your domain and API key</a> for it to work.'), "admin.php?page=talentlms") . "</p></div>";
	}

	add_action('admin_notices', 'talentlms_warning');
} else {
	try{
		TalentLMS::setApiKey(get_option('talentlms-api-key'));
		TalentLMS::setDomain(get_option('talentlms-domain'));
	} catch(Exception $e) {
		if ($e instanceof TalentLMS_ApiError) {
			echo "<div class='alert alert-error'>";
			echo $e -> getMessage();
			echo "</div>";
		}
	}

	wp_enqueue_script('jquery');
	wp_enqueue_style('talentlms-css', _BASEURL_ . '/css/talentlms-style.css', false, '1.0');

	include (_BASEPATH_ . '/shortcodes/reg_shortcodes.php');

}
?>