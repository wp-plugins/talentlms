<?php
$output .= "<div id=\"container-courses-left-categories-right\">";

// Courses
$output .= "<div id=\"courses-container\">";
if ((get_option('talentlms-courses-per-page') && $numofpages > 1) && get_option('talentlms-courses-top-pagination')) {
	include (_BASEPATH_ . '/templates/pagination.php');
}

$output .= "<table class=\"table\">";
$output .= "<thead>";
$output .= "<tr>";
if(get_option('talentlms-show-course-list-thumb')){
	$output .= "<th colspan=\"2\" style=\"text-align: center\">" . __('Course') . "</th>";
} else {
	$output .= "<th>" . __('Course') . "</th>";	
}
if(get_option('talentlms-show-course-list-description')) {
	$output .= "<th style=\"text-align: center\">" . __('Description') . "</th>";
}
if(get_option('talentlms-show-course-list-price')){
	$output .= "<th style=\"text-align: center\">" . __('Price') . "</th>";
}
$output .= "</tr>";
$output .= "</thead>";
$output .= "<tbody>";
foreach ($courses as $course) {
	if(!$course['hide_from_catalog'] && $course['status'] == 'active' ){
		$output .= "<tr class=\"course-catalog-tr\">";
		
		if(get_option('talentlms-show-course-list-thumb')){
			$output .= "<td>";
			$output .= "<a href=\"?course=" . $course['id'] . "\">";
			if (strstr($course['avatar'], 'unknown_small.png')) {
				$output .= "<img title=\"" . $course['name'] . "\" alt=\"" . $course['name'] . "\" src=\"http://" . $course['avatar'] . "\">";
			} else {
				$output .= "<img title=\"" . $course['name'] . "\" alt=\"" . $course['name'] . "\" src=\"" . $course['avatar'] . "\">";
			}
			$output .= "</a>";
			$output .= "</td>";
		}
		
		$output .= "<td>";
		$course_name = ($course['code']) ? $course['name'] . ' (' . $course['code'] . ')' : $course['name'];
		$output .= "<a href=\"?course=" . $course['id'] . "\">" . $course_name . "</a>";
		$output .= "</td>";
		
		if(get_option('talentlms-show-course-list-description')) {
			$output .= "<td>";
			if(get_option('talentlms-show-course-list-description-limit')){
				$output .= "<p style=\"text-align:justify;\">" . limit_words($course['description'], get_option('talentlms-show-course-list-description-limit')) . "</p>";
			} else {
				$output .= "<p style=\"text-align:justify;\">" . $course['description'] . "</p>";
			}
			$output .= "</td>";
		}

		if(get_option('talentlms-show-course-list-price')){
			$output .= "<td width=\"10%\" style=\"text-align: center; vertical-align: middle;\">";
			$output .= (preg_replace("/\D+/", "", html_entity_decode($course['price'])) == 0) ? '-' : $course['price'];
			$output .= "</td>";			
		}
				
		$output .= "</tr>";
	}
}
$output .= "</tbody>";
$output .= "</table>";
if ((get_option('talentlms-courses-per-page') && $numofpages > 1) && get_option('talentlms-courses-bottom-pagination')) {
	include (_BASEPATH_ . '/templates/pagination.php');
}
$output .= "</div>";

// Categories
$categories = build_categories_tree($categories);
$output .= "<div id=\"categories-container\">";
$output .= "<fieldset>";
$output .= "<legend>" . __('Categories:') . "</legend>";
$output .= $categories;
$output .= "</fieldset>";
$output .= "</div>"; 

$output .= "<div class=\"clear\"></div>";
$output .= "</div>";
?>