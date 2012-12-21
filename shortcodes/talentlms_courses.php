<?php

if ($_POST['talentlms-login'] && $_POST['talentlms-password']) {

	try {
		$login = TalentLMS_User::login(array('login' => $_POST['talentlms-login'], 'password' => $_POST['talentlms-password']));

		session_start();
		$_SESSION['talentlms_user_id'] = $login['user_id'];

	} catch (Exception $e) {
		if ($e instanceof TalentLMS_ApiError) {

			$output .= "<div class=\"alert alert-error\">";
			$output .= $e -> getMessage();
			$output .= "</div>";
		}
	}
}

$talentlms_info = TalentLMS_Siteinfo::get();
if ($_POST['talent-get-course']) {
	session_start();

	if (preg_replace("/\D+/", "", html_entity_decode($_POST['talent-course-price'])) > 0 && $talentlms_info['paypal_email']) {
		$buyCourse = TalentLMS_Course::buyCourse(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $_POST['talent-get-course']));
		$output .= "<script type='text/javascript'>window.location = '" . $buyCourse['redirect_url'] . "'</script>";
		//header("location:".$buyCourse['redirect_url']);
		exit ;
	} else {
		$addUserToCourse = TalentLMS_Course::addUser(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $_POST['talent-get-course']));
	}
}
?>

<?php
if (isset($_GET['course']) && $_GET['course'] != '') {

	$course = talentlms_get_course($_GET['course']);
	if ($course instanceof TalentLMS_ApiError) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $course -> getMessage();
		$output .= "</div>";
	} else {
		include (_BASEPATH_ . '/templates/course_single.php');
	}
} else {

	if ($_GET['category'] == 'all' || !$_GET['category']) {
		$courses = talentlms_get_courses();
		if ($courses instanceof TalentLMS_ApiError) {
			$output .= "<div class=\"alert alert-error\">";
			$output .= $courses -> getMessage();
			$output .= "</div>";
		}		
	} else {
		$category = talentlms_get_category($_GET['category']);
		if ($category instanceof TalentLMS_ApiError) {
			$output .= "<div class=\"alert alert-error\">";
			$output .= $category -> getMessage();
			$output .= "</div>";
		}		
		$courses = $category['courses'];
	}
	$categories = talentlms_get_categories();
	if ($categories instanceof TalentLMS_ApiError) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $categories -> getMessage();
		$output .= "</div>";
	}

	// Setup pagination
	if (get_option('talentlms-courses-per-page')) {
		$pagination_details = setup_pagination($courses, $_GET['paging']);
		extract($pagination_details);
	}

	// Load template
	switch(get_option('talentlms-courses-template')) {
		case 'categories-right-courses-left' :
			include (_BASEPATH_ . '/templates/categories_right_courses_left.php');
			break;
		case 'categories-left-courses-right' :
			include (_BASEPATH_ . '/templates/categories_left_courses_right.php');
			break;
		case 'categories-top-courses-bottom' :
			include (_BASEPATH_ . '/templates/categories_top_courses_bottom.php');
			break;
	}
}
?>

