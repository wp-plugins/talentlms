<?php
/**
 * Builds a tree representation of TalentLMS courses.
 * 
 * @param array $categories An array of TalentLMS categories. Array keys are id, name and parent_id
 * @param array $courses An array of TalentLMS courses.
 * @uses tl_create_course_node()
 * @return html An HTML representation of nested <ul>, <li> tags representing categories in a tree
 * */
function tl_build_courses_template_tree($categories, $courses) {

	foreach ($categories as $category) {
		$nodes[$category['id']] = $category;
		$nodes[$category['id']]['content'] = $courses[$category['id']];
	}

	$categories = $nodes;
	$rejected = array();
	$count = 0;
	while (sizeof($categories) > 1 && $count++ < 1000) {
		foreach ($nodes as $key => $value) {
			if ($value['parent_category_id'] == 0 || in_array($value['parent_category_id'], array_keys($nodes))) {
				$parentNodes[$value['parent_category_id']][]	  = $value;
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
		
	$html = "<ul id='tl-courses-tree-root'>";
	foreach($categories[0]['']['children'] as $node){		
		if(!$node['parent_category_id']){
			$html .= tl_create_course_node($node);	
		}			
	}
	$html .= "</ul>";	
	
	return $html;	
}

/**
 * @uses output_category_content()
 * */
function tl_create_course_node($node) {
	$html = "<li>";
	$html .= "<div class='tl-toggle-category' id='tl-category-" . $node['id'] . "'>";
	$html .= "<img src='" . _BASEURL_ . "/img/arrow_down.png' />";
	$html .= "<strong>" . $node['name'] . "</strong>";
	$html .= "</div>";
	
	if (is_array($node['children'])) {		
		$html .= "<ul id='tl-category-contents-" . $node['id'] . "'>";
		$html .= output_category_content($node['content']);
		foreach ($node['children'] as $child) {	
			$html .= tl_create_course_node($child);
		}
		$html .= '</ul>';
	} else {
		$html .= "<ul id='tl-category-contents-" . $node['id'] . "'>";
		if($node['content']){
			$html .= output_category_content($node['content']);
		} else {
			$html .= "<li>" . __('Empty category') . "</li>";
		}	
		$html .= "</ul>";		
	}
	
	
	$html .= '</li>';
	return $html;
}

function output_category_content($courses) {
	$output .= "<ul>";
	foreach ($courses as $course) {
		$output .= "<li><a href='?tlcourse=" . $course['id'] . "'>" . $course['name'] . "</a></li>";
	}		
	$output .= "</ul>";
	return $output;
}

?>