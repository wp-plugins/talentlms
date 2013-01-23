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

function pluginAddAdminMenus() {
	$talentlmspage = add_menu_page(__('TalentLMS'), __('TalentLMS'), 'manage_options', 'talentlms', 'talentlms_admin');
	$templateMenu = add_submenu_page('talentlms', __('TalentLMS Options'), __('TalentLMS Options'), 'manage_options', 'talentlms-appearance-options', 'talentlms_appearance_options');
	$cssMenu = add_submenu_page('talentlms', __('Edit TalentLMS CSS'), __('Edit TalentLMS CSS'), 'manage_options', 'talentlms-edit-css', 'talentlms_edit_css');

	add_action("admin_print_scripts-$talentlmspage", 'enqueueJsScripts');
	add_action("admin_print_styles-$talentlmspage", 'enqueueCssScripts');
}

add_action('admin_menu', 'pluginAddAdminMenus');

function enqueueJsScripts() {
	//    wp_enqueue_script('jquery-ui-core');
	//    wp_enqueue_script('jquery-ui-progressbar');
}

function enqueueCssScripts() {
	//    wp_enqueue_style( "jquery-ui-css", "http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css");
}

function talentlms_appearance_options() {

	if ($_POST['action'] == "post") {
		// pagination options
		if ($_POST['courses-per-page'] && $_POST['courses-per-page'] > 0) {
			update_option('talentlms-courses-per-page', $_POST['courses-per-page']);
		} else {
			update_option('talentlms-courses-per-page', '');
		}
		if ($_POST['top-pagination']) {
			update_option('talentlms-courses-top-pagination', $_POST['top-pagination']);
		} else {
			update_option('talentlms-courses-top-pagination', '');
		}
		if ($_POST['bottom-pagination']) {
			update_option('talentlms-courses-bottom-pagination', $_POST['bottom-pagination']);
		} else {
			update_option('talentlms-courses-bottom-pagination', '');
		}

		// course list template option
		update_option('talentlms-courses-template', $_POST['courses-template']);
		if ($_POST['show-course-list-thumb']) {
			update_option('talentlms-show-course-list-thumb', $_POST['show-course-list-thumb']);
		} else {
			update_option('talentlms-show-course-list-thumb', '');
		}
		if ($_POST['show-course-list-description']) {
			update_option('talentlms-show-course-list-description', $_POST['show-course-list-description']);
		} else {
			update_option('talentlms-show-course-list-description', '');
		}
		if ($_POST['show-course-list-description-limit'] && $_POST['show-course-list-description-limit'] > 0) {
			update_option('talentlms-show-course-list-description-limit', $_POST['show-course-list-description-limit']);
		} else {
			update_option('talentlms-show-course-list-description-limit', '');
		}
		if ($_POST['show-course-list-price']) {
			update_option('talentlms-show-course-list-price', $_POST['show-course-list-price']);
		} else {
			update_option('talentlms-show-course-list-price', '');
		}
            
		// single course template options
		if ($_POST['show-course-description']) {
			update_option('talentlms-show-course-description', $_POST['show-course-description']);
		} else {
			update_option('talentlms-show-course-description', '');
		}
		if ($_POST['show-course-price']) {
			update_option('talentlms-show-course-price', $_POST['show-course-price']);
		} else {
			update_option('talentlms-show-course-price', '');
		}
		if ($_POST['show-course-instructor']) {
			update_option('talentlms-show-course-instructor', $_POST['show-course-instructor']);
		} else {
			update_option('talentlms-show-course-instructor', '');
		}
		if ($_POST['show-course-units']) {
			update_option('talentlms-show-course-units', $_POST['show-course-units']);
		} else {
			update_option('talentlms-show-course-units', '');
		}
		if ($_POST['show-course-rules']) {
			update_option('talentlms-show-course-rules', $_POST['show-course-rules']);
		} else {
			update_option('talentlms-show-course-rules', '');
		}
		if ($_POST['show-course-prerequisites']) {
			update_option('talentlms-show-course-prerequisites', $_POST['show-course-prerequisites']);
		} else {
			update_option('talentlms-show-course-prerequisites', '');
		}

		// user list template options
		if ($_POST['show-user-list-avatar']) {
			update_option('talentlms-show-user-list-avatar', $_POST['show-user-list-avatar']);
		} else {
			update_option('talentlms-show-user-list-avatar', '');
		}
		if ($_POST['show-user-list-bio']) {
			update_option('talentlms-show-user-list-bio', $_POST['show-user-list-bio']);
		} else {
			update_option('talentlms-show-user-list-bio', '');
		}
		if ($_POST['show-user-list-bio-limit'] && $_POST['show-user-list-bio-limit'] > 0) {
			update_option('talentlms-show-user-list-bio-limit', $_POST['show-user-list-bio-limit']);
		} else {
			update_option('talentlms-show-user-list-bio-limit', '');
		}

		// single user template options
		if ($_POST['show-user-bio']) {
			update_option('talentlms-show-user-bio', $_POST['show-user-bio']);
		} else {
			update_option('talentlms-show-user-bio', '');
		}
		if ($_POST['show-user-email']) {
			update_option('talentlms-show-user-email', $_POST['show-user-email']);
		} else {
			update_option('talentlms-show-user-email', '');
		}
		if ($_POST['show-user-courses']) {
			update_option('talentlms-show-user-courses', $_POST['show-user-courses']);
		} else {
			update_option('talentlms-show-user-courses', '');
		}
		
		// after signup option
		update_option('talentlms-after-signup', $_POST['after-signup']);
	}

	include (_BASEPATH_ . '/admin/pages/talentlms_appearance_options.php');
}

function talentlms_edit_css() {

	if ($_POST['talentlms_edit_css']) {
		file_put_contents(_BASEPATH_ . '/css/talentlms-style.css', stripslashes($_POST['talentlms_edit_css']));
	}

	include (_BASEPATH_ . '/admin/pages/talentlms_edit_css.php');
}

function talentlms_admin() {

	if ($_POST['action'] == "post") {
		if (!$_POST['talentlms_domain']) {
			$domain_validation = 'form-invalid';
		} else {
			TalentLMS::setDomain($_POST['talentlms_domain']);

		}
		if (!$_POST['api_key']) {
			$api_validation = 'form-invalid';
		} else {
			TalentLMS::setApiKey($_POST['api_key']);
		}

		try {
			$site_info = TalentLMS_Siteinfo::get();
			if (is_array($site_info)) {
				if ($_POST['talentlms_domain'] != get_option('talentlms-domain') && $_POST['api_key'] != get_option('talentlms-api-key')) {
					update_option('talentlms-domain', $_POST['talentlms_domain']);
					update_option('talentlms-api-key', $_POST['api_key']);
					if($site_info['domain_map']) {
						update_option('talentlms-domain-map', $site_info['domain_map']);
					}
					empty_cache_values();
				}
			}
		} catch(Exception $e) {
			if ($e instanceof TalentLMS_ApiError) {
				$setting_library_error = $e -> getMessage() . " " . $e->getHttpStatus() . " " . $e->getHttpBody() . " " . $e->getJsonBody() ;
			}
		}

	}

	if ($_POST['action'] == "cache") {
		empty_cache_values();
	}

	include (_BASEPATH_ . '/admin/pages/talentlms_admin.php');

}

if ((!get_option('talentlms-domain') && !$_POST['talentlms_domain']) || (!get_option('talentlms-api-key') && !$_POST['api_key'])) {
	function talentlms_warning() {
		echo "<div id='talentlms-warning' class='error fade'><p><strong>" . __('You need to specify a TalentLMS domain and a TalentLMS API key.') . "</strong> " . sprintf(__('You must <a href="%1$s">enter your domain and API key</a> for it to work.'), "admin.php?page=talentlms") . "</p></div>";
	}

	add_action('admin_notices', 'talentlms_warning');
} else {

	TalentLMS::setApiKey(get_option('talentlms-api-key'));
	TalentLMS::setDomain(get_option('talentlms-domain'));
	
	wp_enqueue_script('jquery');
	wp_enqueue_style('talentlms-css', _BASEURL_ . '/css/talentlms-style.css', false, '1.0');

	function talentlms_course_list($atts) {
		wp_enqueue_style("jquery-ui-css", "http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css");

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
}
?>