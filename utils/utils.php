<?php
/**
 * Limit a string to a given number of words
 *
 * @param string $string The input string
 * @param int $word_limit the number of words to limit the string to
 * @return string The original string truncated to the speficied number of words
 * */
function tl_limit_words($string, $word_limit) {
	if ($word_limit) {
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	} else {
		return $string;
	}
}

/**
 * Limit a string to a given number of sentences. Each sentence is denoted by . (period)
 *
 * @param string $string The input string
 * @param int $sentence_limit the number of sentences to limit the string to
 * @return string The original string truncated to the speficied number of sentences
 * */
function tl_limit_sentence($string, $sentence_limit) {
	$sentences = explode(".", $string);
	return implode(".", array_splice($sentences, 0, $sentence_limit));
}

/**
 * Check if a given domain name is a TalentLMS domain or not
 *
 * @param string $domain The input domain name
 * @return boolean true if TalentLMS, false otherwise
 * */
function tl_is_domain($domain) {
	return preg_match("/^[a-z0-9-\.]{1,100}\w+$/", $domain) AND (strpos($domain, 'talentlms.com') !== false);
}

/**
 * Check if a given API key is a valid TalentLMS API key
 *
 * @param string $api_key The input API key
 * @return boolean true if valid API key, false otherwise
 * */
function tl_is_api_key($api_key) {
	if (strlen($api_key) == 30) {
		return true;
	}
	return false;
}


/**
 * Setup pagination for users template
 *
 * @param array $users An array of TalentLMS users
 * @param int $page The current page
 * @return array An array of users, along with the number of pages and the current page
 * */
function tl_setup_users_pagination($users, $page) {
	$currentpage = ($page) ? trim($page) : 0;

	$perpage = get_option('tl-users-page-template-users-per-page');

	$num_of_users = 0;
	foreach ($users as $user) {
		if ($user['status'] == 'active') {
			$num_of_users++;
		}
	}
	$numofpages = ceil($num_of_users / $perpage);

	$start = $currentpage * $perpage;
	$end = ($currentpage * $perpage) + $perpage;

	$tmpUsers = $users;
	unset($users);
	for ($j = $start; $j < $end; $j++) {
		if ($tmpUsers[$j]) {
			$users[] = $tmpUsers[$j];
		}
	}

	return array('users' => $users, 'numofpages' => $numofpages, 'currentpage' => $currentpage);
}


/**
 * Retreives TalentLMS categories from the cache. If categories do not exist in cache, it retrieves the categories from the API and caches the result
 *
 * @return array An array of categories' details
 * */
function tl_get_categories() {
	$categories = unserialize(tl_get_cache_value('categories'));
	if (!$categories) {
		try {
			$categories = TalentLMS_Category::all();
			foreach($categories as $key => $category) {
				$category_details = tl_get_category($category['id']);
				if(empty($category_details['courses'])) {
					unset($categories[$key]);
				} else {
					$categories[$key]['courses_count'] = count($category_details['courses']);
				}
			}			
			tl_add_cache_value(array('name' => 'categories', 'value' => serialize($categories)));
		} catch(Exception $e) {
			return $e;
		}
	}
	return $categories;
}

/**
 * Retreives a TalentLMS category from the cache. If the category does not exist in cache, it retrieves the category from the API and caches the result
 *
 * @param int $category_id The TalentLMS id for the category
 * @return array An array of category's details
 * */
function tl_get_category($category_id) {
	$category = unserialize(tl_get_cache_value('category_' . $category_id));
	if (!$category) {
		try {
			$category = TalentLMS_Category::retrieve($category_id);
			tl_add_cache_value(array('name' => 'category_' . $category_id, 'value' => serialize($category)));
		} catch(Exception $e) {
			return $e;
		}
	}
	return $category;
}

/**
 * Retreives TalentLMS courses from the cache. If courses do not exist in cache, it retrieves the courses from the API and caches the result
 *
 * @return array An array of users' details
 * */
function tl_get_courses() {
	$courses = trim(tl_get_cache_value('courses'));
	$courses = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $courses);
	$courses = unserialize($courses);

	if (!$courses) {
		try {
			$categories = tl_get_categories();
			$courses = TalentLMS_Course::all();
			foreach($courses as &$course) {
				foreach($categories as $category) {
					if($course['category_id'] == $category['id']) {
						$course['category_name'] = $category['name'];
					}
				}
			}
			tl_add_cache_value(array('name' => 'courses', 'value' => serialize($courses)));
		} catch(Exception $e) {
			return $e;
		}
	}
	return $courses;
}

/**
 * Retreives a TalentLMS course from the cache. If the course does not exist in cache, it retrieves the course from the API and caches the result
 *
 * @param int $course_id The TalentLMS id for the course
 * @return array An array of course's details
 * */
function tl_get_course($course_id) {
	$course = unserialize(tl_get_cache_value('course_' . $course_id));
	if (!$course) {
		try {
			$course = TalentLMS_Course::retrieve($course_id);
			tl_add_cache_value(array('name' => 'course_' . $course['id'], 'value' => serialize($course)));
		} catch(Exception $e) {
			return $e;
		}
	}
	return $course;
}

/**
 * Retreives TalentLMS users from the cache. If users do not exist in cache, it retrieves the users from the API and caches the result
 *
 * @return array An array of users' details
 * */
function tl_get_users() {
	$users = unserialize(tl_get_cache_value('users'));
	if (!$users) {
		try {
			$users = TalentLMS_User::all();
			tl_add_cache_value(array('name' => 'users', 'value' => serialize($users)));
		} catch(Exception $e) {
			return $e;
		}
	}
	return $users;
}

/**
 * Retreives a TalentLMS user from the cache. If the user does not exists in cache, it retrieves the user from the API and caches the result
 *
 * @param int $user_id The TalentLMS id of the user
 * @return array An array of user's details
 * */
function tl_get_user($user_id) {
	$user = unserialize(tl_get_cache_value('user_' . $user_id));
	if (!$user) {
		try {
			$user = TalentLMS_User::retrieve($user_id);
			tl_add_cache_value(array('name' => 'user_' . $user_id, 'value' => serialize($user)));
		} catch(Exception $e) {
			return $e;
		}
	}
	return $user;
}

/**
 * Retreives TalentLMS groups from the cache. If groups do not exist in cache, it retrieves the groups from the API and caches the result
 *
 * @return array An array of groups details
 * */
function tl_get_groups() {
	$groups = unserialize(tl_get_cache_value('groups'));
	if (!$groups) {
		try {
			$groups = TalentLMS_Group::all();
			tl_add_cache_value(array('name' => 'groups', 'value' => serialize($groups)));
		} catch(Exception $e) {
			return $e;
		}
	}
	return $groups;	
}

function tl_get_siteinfo() {
	$site_info = unserialize(tl_get_cache_value('site_info'));
	if(!$site_info) {
		try{
			$site_info = TalentLMS_Siteinfo::get();
			tl_add_cache_value(array('name' => 'site_info', 'value' => serialize($site_info)));
		} catch (Exception $e) {
			return $e;
		}
	}
	return $site_info;
}

function tl_get_custom_fields() {
	$custom_fields = unserialize(tl_get_cache_value('custom_fields'));
	if(!$custom_fields) {
		try {
			$custom_fields = TalentLMS_User::getCustomRegistrationFields();
			tl_add_cache_value(array('name' => 'custom_fields', 'value' => serialize($custom_fields)));
		} catch (Exception $e){
			return $e;
		}
	}
	return $custom_fields;
}

/**
 * Replaces a TalentLMS domain with a TalentLMS domain map, is TalentLMS domain map exists
 *
 * @param string $url the given TalentLMS domain
 * @return string The corresponding TalentLMS domain map, otherwith the same TalentLMS domain
 */
function tl_talentlms_url($url) {
	if (get_option('talentlms-domain-map')) {
		return str_replace(get_option('talentlms-domain'), get_option('talentlms-domain-map'), $url);
	} else {
		return $url;
	}
}

/**
 * Get the login key from a TalentLMS url
 *
 * @param string $tl_url The TalentLMS url
 * @return string The login key
 * */
function tl_get_login_key($tl_url) {
	$arr = explode('key:', $tl_url);
	$login_key = ',key:' . $arr[1];
	return $login_key;
}

/**
 * Get the current page url
 *
 * @return string The current page url
 * */
function tl_current_page_url() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"])) {
		if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

/**
 * List users from WP and TalentLMS and find the differences between the two sets
 * @return Array An array four arrays. One of WP users to be synced to TalentLMS, one of TalentLMS users to be synced to WP, 0ne of total TalentLMS users and one of total WP users
 * */
function tl_list_wp_tl_users() {
	try{
		$talentlms_users = TalentLMS_User::all();
		$custom_fields = tl_get_custom_fields();
	} catch(Exception $e) {
		return array('action_status' => "error", 'action_message' => $e->getMessage());
	}

	$tl_users = array();
	foreach ($talentlms_users as $user) {
		$tl_users[$user['login']] = array('ID' => '', 'login' => $user['login'], 'first_name' => $user['first_name'], 'last_name' => $user['last_name'], 'email' => $user['email']);
		if(is_array($custom_fields)) {
			foreach($custom_fields as $custom_field) {
				$tl_users[$user['login']][$custom_field['key']] = $user[$custom_field['key']];
			} 
		}
	}
	
	$blog_users = get_users();
	$wp_users = array();
	foreach ($blog_users as $user) {
		$wp_users[$user -> user_login] = array('ID' => $user -> ID, 'login' => $user -> user_login, 'first_name' => $firstName = get_user_meta($user -> ID, 'first_name', true), 'last_name' => $lastName = get_user_meta($user -> ID, 'last_name', true), 'email' => $user -> user_email);
		if(is_array($custom_fields)) {
			foreach($custom_fields as $custom_field) {
				$wp_users[$user -> user_login][$custom_field['key']] = esc_attr(get_the_author_meta($custom_field['key'], $user->ID));
			}			
		}
	}

	$tl_users_to_wp = array_diff_key($tl_users, $wp_users);
	$wp_users_to_tl = array_diff_key($wp_users, $tl_users);

	return array('wp_users' => $wp_users, 'tl_users' => $tl_users, 'tl_users_to_wp' => $tl_users_to_wp, 'wp_users_to_tl' => $wp_users_to_tl, );
}

/**
 * Sync users from WP and users from TalentLMS
 * @param Array $tl_users_to_wp TalentLMS users to be synced to WP
 * @param Array $wp_users_to_tl WP users to be synced to TalentLMS
 * @param boolean $hard_sync forces WP users details to be overwritten by details in TalentLMS
 * @param Array $all_users All the users in WP and TalentLMS
 * @return boolean|Array true if sync was successfull or an array of sync errors
 * */
function tl_sync_wp_tl_users($tl_users_to_wp, $wp_users_to_tl, $hard_sync, $all_users) {
	$custom_fields = tl_get_custom_fields();

	$sync_errors = array();
	foreach ($tl_users_to_wp as $user) {
		$new_wp_user_id = wp_insert_user(array('user_login' => $user['login'], 'user_pass' => $user['email'], 'user_email' => $user['email'], 'first_name' => $user['first_name'], 'last_name' => $user['last_name']));
		if (is_array($custom_fields)) {
			foreach($custom_fields as $custom_field) {
				update_user_meta($new_wp_user_id, $custom_field['key'], $user[$custom_field['key']] );
			}
		}
		if (is_wp_error($new_wp_user_id)) {
			$sync_errors[] = "User: " . $user['login'] . " cannot be synchronized from TalentLMS.	Error: " . $new_wp_user_id -> get_error_message();
		}
	}

	foreach ($wp_users_to_tl as $user) {
		try {
			$signup_arguments = array('first_name' => $user['first_name'], 'last_name' => $user['last_name'], 'email' => $user['email'], 'login' => $user['login'], 'password' => $user['login']);
			if (is_array($custom_fields)) {
				foreach ($custom_fields as $custom_field) {
					$signup_arguments[$custom_field['key']] = esc_attr(get_the_author_meta( $custom_field['key'], $user['ID']));
				}
			}
			$new_user = TalentLMS_User::signup($signup_arguments);
		} catch (Exception $e) {
			$sync_errors[] = "User: " . $user['login'] . "	Error: " . $e -> getMessage();
		}
	}
	if ($hard_sync) {
		foreach ($all_users as $user) {
			wp_insert_user(array('ID' => $user['ID'], 'user_login' => $user['login'], 'user_email' => $user['email'], 'first_name' => $user['first_name'], 'last_name' => $user['last_name']));
			if (is_array($custom_fields)) {
				foreach($custom_fields as $custom_field) {
					update_user_meta($user['ID'], $custom_field['key'], $_POST[$custom_field['key']] );
				}
			}			
		}
	}

	if (!empty($sync_errors)) {
		return $sync_errors;
	} else {
		return true;
	}

}

/**
 * Create an array of TalentLMS categories with children field. Nested categories.
 *
 * @param array @categories An array of TalentLMS categories as returned by TalentLMS_Category::all()
 * @return array Nested TalentLMS cateogories
 * */
function tl_categories_tree($categories) {
	foreach ($categories as $category) {
		$nodes[$category['id']] = $category;
	}

	$categories = $nodes;
	$rejected = array();
	$count = 0;
	while (sizeof($categories) > 1 && $count++ < 1000) {
		foreach ($nodes as $key => $value) {
			if ($value['parent_category_id'] == 0 || in_array($value['parent_category_id'], array_keys($nodes))) {
				$parentNodes[$value['parent_category_id']][] = $value;
				$categories[$value['parent_category_id']]['children'][$value['id']] = array();
			} else {
				$rejected = $rejected + array($value['id'] => $value);
				unset($nodes[$key]);
				unset($parentNodes[$value['parent_category_id']]);
			}
		}
		if (isset($parentNodes)) {
			$leafNodes = array_diff(array_keys($nodes), array_keys($parentNodes));
			foreach ($leafNodes as $leaf) {
				$parent_id = $nodes[$leaf]['parent_category_id'];
				$categories[$parent_id]['children'][$leaf] = $categories[$leaf];
				unset($categories[$leaf]);
				unset($nodes[$leaf]);
			}
			unset($parentNodes);
		}
	}
	if (sizeof($categories) > 0 && !isset($categories[0])) {
		$categories = array($categories);
	}
	foreach ($categories as $key => $value) {
		if ($key != 0) {
			$rejected[$key] = $value;
		}
	}

	return $categories[0]['']['children'];
}

/**
 * TalentLMS to WP categories
 *
 * @param array $categories Nested TalentLMS categories as return by tl_categories_tree()
 * @uses  tl_create_wp_category()
 * */
function tl_create_wp_categories($categories) {
	foreach ($categories as $node) {
		if (!$node['parent_category_id']) {
			tl_create_wp_category($node);
		}
	}
}

function tl_create_wp_category($node, $parent_id) {
	$wp_cat_id = wp_create_category($node['name'], $parent_id);
	if (is_array($node['children'])) {
		foreach ($node['children'] as $child) {
			tl_create_wp_category($child, $wp_cat_id);
		}
	}
}

/*
 * =======================================================================================
 * */

/**
 * Get WP category id by name
 *
 * @param string $cat_name The category name
 * @return int the category id
 * */
function tl_get_wp_category_id($cat_name) {
	$term = get_term_by('name', $cat_name, 'category');
	return $term -> term_id;
}

/**
 * Set feature image to post. Uploads an image to wp-upload directory and sets it as featured.
 *
 * @param int $post_id The post id
 * @param string $image_url The image url
 * */
function tl_set_wp_post_featured_image($post_id, $image_url) {
	$upload_dir = wp_upload_dir();
	$image_data = file_get_contents($image_url);
	$filename = basename($image_url);
	if (wp_mkdir_p($upload_dir['path']))
		$file = $upload_dir['path'] . '/' . $filename;
	else
		$file = $upload_dir['basedir'] . '/' . $filename;
	file_put_contents($file, $image_data);

	$wp_filetype = wp_check_filetype($filename, null);
	$attachment = array('post_mime_type' => $wp_filetype['type'], 'post_title' => sanitize_file_name($filename), 'post_content' => '', 'post_status' => 'inherit');
	$attach_id = wp_insert_attachment($attachment, $file, $post_id);
	require_once (ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata($attach_id, $file);
	wp_update_attachment_metadata($attach_id, $attach_data);

	set_post_thumbnail($post_id, $attach_id);
}

/**
 * Retrieve a post given its title.
 *
 * @uses $wpdb
 *
 * @param string $post_title Page title
 * @param string $post_type post type ('post','page','any custom type')
 * @param string $output Optional. Output type. OBJECT, ARRAY_N, or ARRAY_A.
 * @return mixed
 */
function tl_get_post_by_title($page_title, $post_type = 'post', $output = OBJECT) {
	global $wpdb;
	$post = $wpdb -> get_var($wpdb -> prepare("SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type= %s", $page_title, $post_type));
	if ($post)
		return get_post($post, $output);

	return null;
}

/**
 * Delete all WP posts
 */
function tl_delete_wp_posts() {
	$posts = get_posts();
	foreach ($posts as $post) {
		wp_delete_post($post -> ID, true);
	}
}

/**
 * Delete all WP categories
 */
function tl_delete_wp_categories() {
	$categories = get_categories(array('hide_empty' => 0, 'taxonomy' => 'category'));
	foreach ($categories as $category) {
		wp_delete_category($category -> term_id);
	}
}

require_once (_BASEPATH_ . '/utils/template_utils/template_pagination_utils.php');
require_once (_BASEPATH_ . '/utils/template_utils/template_tree_utils.php');
?>