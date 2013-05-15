<?php

/**
 * Builds a tree representation of TalentLMS categories.
 * 
 * @param array $categories An array of TalentLMS categories. Array keys are id, name and parent_id
 * @uses tl_create_node()
 * @return html An HTML representation of nested <ul>, <li> tags representing categories in a tree
 * */
function tl_build_categories_tree($categories) {

	foreach ($categories as $category) {
		$nodes[$category['id']] = $category;
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

		
	$html = "<ul class=\"nav nav-list\">";
	$html .= "<li><a href=\"?category=all\">" . __("All courses") . "</a></li>";
	foreach($categories[0]['']['children'] as $node){
		if(!$node['parent_category_id']){
			$html .= tl_create_node($node);	
		}			
	}
	$html .= "</ul>";	
	
	return $html;	
}

function tl_create_node($node) {	
	$html = "<li>"."<a href=\"?category=".$node['id']."\">".$node['name']."</a>"; 
	if (is_array($node['children'])) {		
		$html .= '<ul>';
		foreach ($node['children'] as $child) {	
			$html .= tl_create_node($child);
		}
		$html .= '</ul>';
	}
	$html .= '</li>';
	return $html;
}

?>