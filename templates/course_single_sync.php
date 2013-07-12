<?php

$output .= "<div id='tl-course-container'>";
$output .= "<div id='tl-course-top-details'>";
$output .= "<div id='tl-course-details'>";
$output .= "<h3><span><strong>" . __('Category:') . "</strong></span> " . "<a href='".esc_url( $category_link ) ."'>" . $category_name . "</a>" . "</h3>";
if(get_option('tl-single-course-page-template-show-course-price')){
$price = (preg_replace("/\D+/", "", html_entity_decode($course['price'])) == 0) ? '-' : $course['price'];
$output .= "<h3><span><strong>" . __('Price: ') . "</strong></span>" . $price . "</h3>";
}
$output .= "</div>";
$output .= "<div class='clear'></div>";
$output .= "</div>";

$output .= "<div class='tl-course-bottom-details'>";

if ($course['description'] && get_option('tl-single-course-page-template-show-course-descr')) {
	$output .= "<div id='tl-course-description'>";
	$output .= "<h2>" . __('Description:') . "</h2>";
	$output .= "<p>" . $course['description'] . "</p>";
	$output .= "</div>";
}

if(is_array($course['users']) && get_option('tl-single-course-page-template-show-course-instructor')) {
	$output .= "<div id='tl-course-instructors'>";
	$output .= "<h2>" . __('Course Instructors:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['users'] as $course_user) {
		if($course_user['role'] == 'instructor'){
			$output .= "<li>" . $course_user['name'] . "</li>";
		}
	}
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['units'] && get_option('tl-single-course-page-template-show-course-units')) {
	$output .= "<div id='tl-course-content'>";
	$output .= "<h2>" . __('Content:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['units'] as $unit) {
		$output .= "<li>" . $unit['name'] . "</li>";
	}		
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['rules'] && get_option('tl-single-course-page-template-show-course-rules')) {
	$output .= "<div id='tl-course-completionrules'>";
	$output .= "<h2>" . __('Completion rules:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['rules'] as $rule) {
		$output .= "<li>" . $rule . "</li>";
	}
	$output .= "</ul>";
	$output .= "</div>";
}

if ($course['prerequisites'] && get_option('tl-single-course-page-template-show-course-prerequisites')) {
	$output .= "<div id='tl-course-prerequisites'>";
	$output .= "<h2>" . __('Prerequisites:') . "</h2>";
	$output .= "<ul>";
	foreach ($course['prerequisites'] as $prerequisite) {
		$output .= "<li><a href='?tlcourse=" . $prerequisite['course_id'] . "'>" . $prerequisite['course_name'] . "</a></li>";
	}
	$output .= "</ul>";
	$output .= "</div>";
}

$output .= "</div>";
$output .= "</div>";
?>