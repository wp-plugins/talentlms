<?php
$courses = tl_get_courses();
$categories = tl_get_categories();

foreach ($categories as $category) {
	foreach ($courses as $course) {
		if($category['id'] == $course['category_id']){
			$category_courses[$category['id']][] = $course;	
		}
	}
}

$output .= "<div id='tl-courses-tree'>";
$output .= tl_build_courses_template_tree($categories, $category_courses);
$output .= "</div>";

//echo "<pre>";
//print_r($category_courses);
//echo "</pre>";

//echo "<pre>";
//print_r($courses);
//echo "</pre>";

?>