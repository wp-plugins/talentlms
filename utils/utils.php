<?php

function limit_words($string, $word_limit) {
	$words = explode(" ", $string);
	return implode(" ", array_splice($words, 0, $word_limit));
}

function limit_sentence($string, $sentence_limit) {
	$sentences = explode(".", $string);
	return implode(".", array_splice($sentences, 0, $sentence_limit));
}

function is_domain($domain) {
	return preg_match("/^[a-z0-9-\.]{1,100}\w+$/", $domain) AND (strpos($domain, 'talentlms.com') !== false);
}

function is_talentlms_api_key($api_key) {
	if (strlen($api_key) == 30) {
		return true;
	}
	return false;
}

function setup_pagination($courses, $page) {
	$currentpage = ($page) ? trim($page) : 0;

	$perpage = get_option('talentlms-courses-per-page');

	$num_of_courses = 0;
	foreach ($courses as $course) {
		if (!$course['hide_from_catalog'] && $course['status'] == 'active') {
			$num_of_courses++;
		}
	}
	$numofpages = ceil($num_of_courses / $perpage);

	$start = $currentpage * $perpage;
	$end = ($currentpage * $perpage) + $perpage;

	$tmpCourses = $courses;
	unset($courses);
	for ($j = $start; $j < $end; $j++) {
		if ($tmpCourses[$j]) {
			$courses[] = $tmpCourses[$j];
		}
	}

	return array('courses' => $courses, 'numofpages' => $numofpages, 'currentpage' => $currentpage);
}

function talentlms_get_categories() {
	$categories = unserialize(get_cache_value('categories'));
	if (!$categories) {
		try{
			$categories = TalentLMS_Category::all();
			add_cache_value(array('name' => 'categories', 'value' => serialize($categories)));
		}catch(Exception $e){
			return $e;
		}		
	}
	return $categories;
}

function talentlms_get_category($category_id) {
	$category = unserialize(get_cache_value('category_' . $category_id));
	if (!$category) {
		try{
			$category = TalentLMS_Category::retrieve($category_id);
			add_cache_value(array('name' => 'category_' . $category_id, 'value' => serialize($category)));
		}catch(Exception $e){
			return $e;
		}		
	}
	return $category;
}

function talentlms_get_courses() {

	$courses = trim(get_cache_value('courses'));
	$courses = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $courses);
	$courses = unserialize($courses);

	if (!$courses) {
		try{
			$courses = TalentLMS_Course::all();
			add_cache_value(array('name' => 'courses', 'value' => serialize($courses)));
		}catch(Exception $e){
			return $e;
		}
	}
	return $courses;
}

function talentlms_get_course($course_id) {
	$course = unserialize(get_cache_value('course_' . $course_id));
	if (!$course) {
		try{
			$course = TalentLMS_Course::retrieve($course_id);
			add_cache_value(array('name' => 'course_' . $course['id'], 'value' => serialize($course)));
		}catch(Exception $e){
			return $e;
		}
	}
	return $course;
}

function talentlms_get_users() {
	$users = unserialize(get_cache_value('users'));
	if (!$users) {
		try{
			$users = TalentLMS_User::all();
			add_cache_value(array('name' => 'users', 'value' => serialize($users)));
		}catch(Exception $e){
			return $e;
		}		
	}
	return $users;
}

function talentlms_get_user($user_id) {
	$user = unserialize(get_cache_value('user_' . $user_id));
	if (!$user) {
		try{
			$user = TalentLMS_User::retrieve($user_id);
			add_cache_value(array('name' => 'user_' . $user_id, 'value' => serialize($user)));		
		}catch(Exception $e){
			return $e;
		}
	}
	return $user;
}
/*
function build_categories_tree($categories) {
	$dom = new DOMDocument;
	foreach ($categories as $category) {
		$node[$category['id']] = $dom -> createElement('li');

		$category_details = TalentLMS_Category::retrieve($category['id']);

		$atag = $dom -> createElement('a');
		$atag -> setAttribute("href", "?category=" . $category_details['id']);
		$atag -> nodeValue = $category_details['name'] . ' (' . count($category_details['courses']) . ')';

		$node[$category['id']] -> appendChild($atag);

		if (!$category['parent_category_id']) {
			$dom -> appendChild($node[$category['id']]);
			// append the element to dom document root
		} else {
			$node[$category['parent_category_id']] -> appendChild($node[$category['id']]);
			// append the element to that's parent element
		}
		$ul = $dom -> createElement('ul');
		$node[$category['id']] = $node[$category['id']] -> appendChild($ul);
	}

	$output = '<ul class="nav nav-list"><li><a href="?category=all">' . __("All courses") . '</a></li>' . str_replace('<ul></ul>', '', $dom -> saveHTML()) . '</ul>';
	// delete empty ul's
	return $output;
}
*/
function build_categories_tree($categories) {
	
	// category id's as array keys
	foreach ($categories as $category) {
		$temp[$category['id']] = $category;
	}
	$categories = $temp;
	
	// find category children
	foreach ($categories as $key => $category) {
		$parent_id = $category['parent_category_id'];
		if($parent_id){
		    $categories[$parent_id]['children'][] = $category;		
		}
	}
		
	$html = "<ul class=\"nav nav-list\">";
	$html .= "<li><a href=\"?category=all\">" . __("All courses") . "</a></li>";
	foreach($categories as $node){
		if(!$node['parent_category_id']){
			$html .= create_node($node);	
		}			
	}
	$html .= "</ul>";	
	
	return $html;	
}

function create_node($node) {	
	$html = "<li>"."<a href=\"?category=".$node['id']."\">".$node['name']."</a>"; 
	if (is_array($node['children'])) {		
		$html .= '<ul>';
		foreach ($node['children'] as $child) {	
			$html .= create_node($child);
		}
		$html .= '</ul>';
	}
	$html .= '</li>';
	return $html;
}

function talentlms_url($url){	
	if(get_option('talentlms-domain-map')) {
		return str_replace(get_option('talentlms-domain'), get_option('talentlms-domain-map'), $url);		
	} else {
		return $url;
	}
}
function get_login_key($url) {
	$arr = explode('key:', $url);
	$login_key = ',key:'.$arr[1];
	return $login_key;
}
?>