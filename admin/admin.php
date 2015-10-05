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
	global $admin_panel, $setup_page, $options_page, $css_page, $sync_page, $tl_subscriber_page;

	/* admin pages */
	$admin_panel  = add_menu_page(__('TalentLMS'), __('TalentLMS'), 'manage_options', 'talentlms', 'admin_panel');
	$setup_page   = add_submenu_page('talentlms', __('Dashboard'), __('Dashboard'), 'manage_options', 'talentlms', 'admin_panel');
	$setup_page   = add_submenu_page('talentlms', __('TalentLMS Setup'), __('Setup'), 'manage_options', 'talentlms-setup', 'setupPage');
	$options_page = add_submenu_page('talentlms', __('TalentLMS Options'), __('Options'), 'manage_options', 'talentlms-options', 'optionsPage');
	$sync_page 	  = add_submenu_page('talentlms', __('TalentLMS Sync'), __('Sync'), 'manage_options', 'talentlms-sync', 'syncPage');
	$css_page 	  = add_submenu_page('talentlms', __('TalentLMS Edit CSS'), __('Edit CSS'), 'manage_options', 'talentlms-css', 'cssPage');

	$tl_subscriber_page = add_menu_page(__('TalentLMS'), __('TalentLMS'), 'subscriber', 'talentlms-subscriber', 'talentlms_subscriber');
	//if(get_option('tl-integrate-woocommerce')) {
	//	$tl_customer_page = add_menu_page(__('TalentLMS'), __('TalentLMS'), 'customer', 'talentlms-subscriber', 'talentlms_subscriber');
	//}
	add_action("admin_print_scripts-$admin_panel", 'enqueueCssScripts');
	
	add_action("admin_print_scripts-$setup_page", 'enqueueCssScripts');
	add_action("admin_print_scripts-$options_page", 'enqueueCssScripts');
	add_action("admin_print_scripts-$sync_page", 'enqueueCssScripts');
	add_action("admin_print_scripts-$css_page", 'enqueueCssScripts');
	add_action("admin_print_scripts-$css_page", 'enqueueJsScripts');
	
	add_action("admin_print_styles-$tl_sync_page", 'enqueueCssScripts');
	add_action("admin_print_styles-$tl_css_page", 'enqueueCssScripts');
}

add_action('admin_menu', 'register_admininstartion_pages');


function enqueueJsScripts() {
	// JS required for edit CSS page
	wp_enqueue_script('tl-codemirror-js', _BASEURL_ . 'utils/codemirror-4.8/codemirror.js');
	wp_enqueue_script('tl-codemirror-css-js', _BASEURL_ . 'utils/codemirror-4.8/css.js');
	
	wp_enqueue_script('tl-admin', _BASEURL_ . 'js/tl-admin.js', false, '1.0');
	
}

function enqueueCssScripts() {
	wp_enqueue_style("talentlms-admin-style", _BASEURL_ . 'css/talentlms-admin-style.css', false, 1.0);
	wp_enqueue_style('tl-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
	wp_enqueue_style("tl-codemirror-css", _BASEURL_ . 'utils/codemirror-4.8/codemirror.css');
}

function talentlms_help($contextual_help, $screen_id, $screen) {
	global $admin_panel, $setup_page, $options_page, $css_page, $sync_page, $tl_subscriber_page;
	include (_BASEPATH_ . '/admin/pages/help.php');
}

add_filter('contextual_help', 'talentlms_help', 10, 3);

function admin_panel() {
	include (_BASEPATH_ . '/admin/pages/admin_panel.php');
}

function setupPage() {
	
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
					} else {
						update_option('talentlms-domain-map', '');
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
	
	include (_BASEPATH_ . '/admin/pages/setup.php');
}


function optionsPage() {
	if($_POST['action'] == 'tl-options') {
		update_option('tl-catalog-categories', $_POST['tl-catalog-categories']);
		//update_option('tl-catalog-view-mode', $_POST['tl-catalog-view-mode']);
		update_option('tl-catalog-view-mode', 'list');
		if($_POST['tl-catalog-per-page'] > 0) {
			update_option('tl-catalog-per-page', $_POST['tl-catalog-per-page']);
		} else {
			$action_status = "error";
			$action_message .= " " . _('Per page must be a positive integer.');
			//$form_validation = 'form-invalid';
			update_option('tl-catalog-per-page', '');
		}
		update_option('tl-signup-redirect', $_POST['tl-signup-redirect']);
		update_option('tl-signup-sync', $_POST['tl-signup-sync']);
		update_option('tl-login-action', $_POST['tl-login-action']);
		update_option('tl-logout', $_POST['tl-logout']);
		update_option('tl-logoutfromTL', $_POST['tl-logoutfromTL']);
	}

	
	if($_POST['action'] == 'tl-integrate-woocommerce') {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'woocommerce/woocommerce.php' )) {
			require_once (_BASEPATH_ . '/admin/integrations/woocommerce.php');
			$action_status = "updated";
			$action_message .= _('WooCommerce integration was successful.', 'talentlms');			
		} else {
			$action_status = "error";
			$action_message .= " " . _('WooCommerce in not installed or may not be active. Please check your Plugin Manager', 'talentlms');
		}
		update_option('tl-integrate-woocommerce', 1);
	}
	
	include (_BASEPATH_ . '/admin/pages/options.php');
}

function syncPage() {

	extract(tl_list_wp_tl_users());
	
	if ($_POST['action'] == 'tl-sync') {
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
			foreach ($sync_errors as $error) {
				$action_message .= "</p>" . $error . "</p>";
			}
		}
	}	

	if($_POST['tl-sync-periodicaly']) {
		update_option('tl-sync-periodicaly', 1);
	}

	$tl_content = TalentLMS_Course::all();
	$wp_content = trim(tl_get_cache_value('courses'));
	$wp_content = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $wp_content);
	$wp_content = unserialize($wp_content);
	
	
	if ($_POST['action'] == "tl-cache") {
		
		$tl_content = TalentLMS_Course::all();
		$wp_content = trim(tl_get_cache_value('courses'));
		$wp_content = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $wp_content);
		$wp_content = unserialize($wp_content);
		
		tl_empty_cache();
		$action_status = "updated";
		$action_message = _('TalentLMS content synced');
	}	
	
	include (_BASEPATH_ . '/admin/pages/sync.php');
}

if(get_option('tl-sync-periodicaly')) {
	function syncContent() {
		tl_empty_cache();
		/* add sync of users if sakis says so...*/
	}
	add_action('my_periodic_action','syncContent');

	
	
	add_action('after_setup_theme', 'tl_setup_events');
	function tl_setup_events() {
		if (!wp_next_scheduled('my_periodic_action') ) {
			wp_schedule_event(time(), 'twicedaily', 'my_periodic_action');
			//wp_schedule_event(current_time( 'timestamp' ), 'twicedaily', 'my_periodic_action');
			//wp_schedule_event(time(), 'twomin', 'my_periodic_action');
		}
	}	
}



function cssPage() {
	if ($_POST['action'] == 'edit-css') {
		file_put_contents(_BASEPATH_ . '/css/talentlms-style.css', stripslashes($_POST['tl-edit-css']));
		$action_status = "updated";
		$action_message = _('Details edited successfully');
	}
	include (_BASEPATH_ . '/admin/pages/css.php');
	
}



function talentlms_sync() {
	
	extract(tl_list_wp_tl_users());
	
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
			foreach ($sync_errors as $error) {
				$action_message .= "</p>" . $error . "</p>";
			}
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

function talentlms_subscriber() {

	if ($_POST['action'] == 'tl-subscriber-login') {
		if(!$_POST['tl-login']) {
			$action_status = "error";
			$login_validation = 'form-invalid';
			$action_message .= __('Login is required') . "<br />";
		}
		if(!$_POST['tl-password']) {
			$action_status = "error";
			$password_validation = 'form-invalid';
			$action_message .= _('Password required') . "<br />";
		}
		if($_POST['tl-login'] && $_POST['tl-password']) {
			try {
				$login = TalentLMS_User::login(array('login' => $_POST['tl-login'], 'password' => $_POST['tl-password'], 'logout_redirect' => (get_option('tl-logoutfromTL') == 'wordpress') ? get_bloginfo('wpurl') : 'http://'.get_option('talentlms-domain')));
				session_start();
				$_SESSION['talentlms_user_id'] = $login['user_id'];
				$_SESSION['talentlms_user_login'] = $_POST['tl-login'];
				$_SESSION['talentlms_user_pass'] = $_POST['tl-password'];
		
				unset($GLOBALS['talentlms_error_msg']);
			} catch (Exception $e) {
				if ($e instanceof TalentLMS_ApiError) {
					$action_status = "error";
					$action_message = $e -> getMessage();;
				}
			}
		}
	}		

	include (_BASEPATH_ . '/admin/pages/talentlms_subscriber.php');
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

	if(get_option('tl-signup-sync')) {
		include (_BASEPATH_ . '/admin/registration_form/tl-custom-registration-form.php');
	}	
	
}


function tl_logout() {
	try{
		TalentLMS_User::logout(array('user_id' => $_SESSION['talentlms_user_id']));
	} catch (Exception $e) {}

	unset($_SESSION['talentlms_user_id']);
	unset($_SESSION['talentlms_user_login']);
	unset($_SESSION['talentlms_user_pass']);
	
	if(get_option('tl-logout') == 'wordpress') {
		wp_redirect(home_url());
	} else {
		wp_redirect('http://'.get_option('talentlms-domain'));
	}
	exit;
}
add_action('wp_logout', 'tl_logout');

function tl_login() {
	try{
		$login = TalentLMS_User::login(array('login' => $_POST['log'], 'password' => $_POST['pwd'], 'logout_redirect' => (get_option('tl-logoutfromTL') == 'wordpress') ? get_bloginfo('wpurl') : 'http://'.get_option('talentlms-domain')));
		session_start();
		$_SESSION['talentlms_user_id'] = $login['user_id'];
		$_SESSION['talentlms_user_login'] = $_POST['log'];
		$_SESSION['talentlms_user_pass'] = $_POST['pwd'];
	} catch (Exception $e) {}
}
add_action('wp_login', 'tl_login');

if(get_option('tl-integrate-woocommerce')) {

	function tl_wc_login() {
		$login = TalentLMS_User::login(array('login' => $_POST['username'], 'password' => $_POST['password'], 'logout_redirect' => (get_option('tl-logoutfromTL') == 'wordpress') ? get_bloginfo('wpurl') : 'http://'.get_option('talentlms-domain')));
		session_start();
		$_SESSION['talentlms_user_id'] = $login['user_id'];
		$_SESSION['talentlms_user_login'] = $_POST['username'];
		$_SESSION['talentlms_user_pass'] = $_POST['password'];		
		wp_redirect( wc_get_page_permalink( 'myaccount' ) );
	}
	add_filter('woocommerce_login_redirect', 'tl_wc_login');
	/*	
	function tl_wc_signup() {
		echo "New WooCommerce customer created...";
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		
		[billing_first_name] => Vasilis
		[billing_last_name] => Prountzos
		[billing_company] =>
		[billing_email] => vprountzos@gmail.com
		[billing_phone] => 6974557321
		[billing_country] => GR
		[billing_address_1] => Aktaiou 24
		[billing_address_2] =>
		[billing_city] => Athens
		[billing_state] => I
		[billing_postcode] => 30014
		[createaccount] => 1
		[account_password] => 123456
		[order_comments] =>
		[_wpnonce] => 143bbda0b9
		[_wp_http_referer] => /talentlmsWordpress/checkout/?wc-ajax=update_order_review		
		
		exit;
	}
	add_filter('woocommerce_created_customer', 'tl_wc_signup');
	
	function test($new_customer_data) {
		echo "<pre>";
		print_r($new_customer_data);
		echo "</pre>";
	
		try {
			$signup_arguments = array('first_name' => $_POST['first-name'], 'last_name' => $_POST['last-name'], 'email' => $_POST['email'], 'login' => $_POST['login'], 'password' => $_POST['password']);
			if (is_array($custom_fields)) {
				foreach ($custom_fields as $custom_field) {
					$signup_arguments[$custom_field['key']] = $_POST[$custom_field['key']];
				}
			}
			$newUser = TalentLMS_User::signup($signup_arguments);
			$tl_signup_failed = false;
		} catch (Exception $e){
			if ($e instanceof TalentLMS_ApiError) {
				$tl_signup_failed = true;
				$tl_signup_fail_message .= $e -> getMessage();
			}
		}		
		
		exit;
	}
	apply_filters('woocommerce_new_customer_data', 'tl_wc_signup');
	*/
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !is_plugin_active( 'woocommerce/woocommerce.php' )) {
	update_option('tl-integrate-woocommerce', 0);
}

?>