<?php
if ($_POST['action'] == "tl-dialog-post") {
	try {
		if ($_POST['tl-dialog-login'] && $_POST['tl-dialog-password']) {
			$login = TalentLMS_User::login(array('login' => $_POST['tl-dialog-login'], 'password' => $_POST['tl-dialog-password'], 'logout_redirect' => (get_option('tl-logout') == 'WP') ? get_bloginfo('wpurl') : ''));
			session_start();
			$_SESSION['talentlms_user_id'] = $login['user_id'];
			$_SESSION['talentlms_user_login'] = $_POST['tl-dialog-login'];
            $_SESSION['talentlms_user_pass'] = $_POST['tl-dialog-password'];
			
			$user = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
			unset($GLOBALS['talentlms_error_msg']);
			$output .= "<div class='alert alert-success'>";
			$output .= "<span style='display:block'>" . _('Welcome back') . " <strong>" . $user['first_name'] . " " . $user['last_name'] . "</strong></span>";
			$output .= "<span style='display:block'>" . _('Goto to your learning portal') . " <a target='_blank' href='" . tl_talentlms_url($login['login_key']) . "'>" . _('here') . "</a></span>";
			$output .= "</div>";
		} else {
			$output .= "<div class='alert alert-error'>";
			if (!$_POST['tl-dialog-login']) {
				$output .= "<span style='display: block;'><strong>" . _('Username cannot be empty') . "</strong></span>";
			}
			if (!$_POST['tl-dialog-password']) {
				$output .= "<span style='display: block;'><strong>" . _('Password cannot be empty') . "</strong></span>";
			}
			$output .= "</div>";
		}
	} catch (Exception $e) {
		if ($e instanceof TalentLMS_ApiError) {
			$output .= "<div class='alert alert-error'>";
			$output .= $e -> getMessage();
			$output .= "</div>";
		}
	}
}

if ($_POST['talentlms-login'] && $_POST['talentlms-password']) {
	try {
		$login = TalentLMS_User::login(array('login' => $_POST['talentlms-login'], 'password' => $_POST['talentlms-password'], 'logout_redirect' => (get_option('tl-logout') == 'WP') ? get_bloginfo('wpurl') : ''));
		session_start();
		$_SESSION['talentlms_user_id'] = $login['user_id'];
	} catch (Exception $e) {
		if ($e instanceof TalentLMS_ApiError) {
			$output .= "<div class='alert alert-error'>";
			$output .= $e -> getMessage();
			$output .= "</div>";
		}
	}
}
try {
	$talentlms_info = TalentLMS_Siteinfo::get();
} catch (Exception $e) {
	if ($e instanceof TalentLMS_ApiError) {
		$output .= "<div class='alert alert-error'>";
		$output .= $e -> getMessage();
		$output .= "</div>";
	}
}
if ($_POST['talentlms-get-course']) {
	session_start();
	if (preg_replace("/\D+/", "", html_entity_decode($_POST['talentlms-course-price'])) > 0 && $talentlms_info['paypal_email']) {
		$buyCourse = TalentLMS_Course::buyCourse(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $_POST['talentlms-get-course']));
		$output .= "<script type='text/javascript'>window.location = '" . tl_talentlms_url($buyCourse['redirect_url']) . "'</script>";
		echo $output;
		//header("location:".$buyCourse['redirect_url']);
		exit ;
	} else {
		$addUserToCourse = TalentLMS_Course::addUser(array('user_id' => $_SESSION['talentlms_user_id'], 'course_id' => $_POST['talentlms-get-course']));
	}
}

if($_POST['tl-get-category-courses']) {
	session_start();
	$buyCategory = TalentLMS_Category::buyCategoryCourses(array('user_id' => $_SESSION['talentlms_user_id'], 'category_id' => $_POST['tl-get-category-courses']));
	$output .= "<script type='text/javascript'>window.location = '" . tl_talentlms_url($buyCategory['redirect_url']) . "'</script>";
	echo $output;

}
?>

<?php
if (isset($_GET['course']) && $_GET['course'] != '') {

	$course = tl_get_course($_GET['course']);
	if ($course instanceof TalentLMS_ApiError) {
		$output .= "<div class='alert alert-error'>";
		$output .= $course -> getMessage();
		$output .= "</div>";
	} else {
		include (_BASEPATH_ . '/templates/course_single.php');
	}
} else {
	if ($_GET['category'] == 'all' || !$_GET['category']) {
		$courses = tl_get_courses();
		if ($courses instanceof TalentLMS_ApiError) {
			$output .= "<div class='alert alert-error'>";
			$output .= $courses -> getMessage();
			$output .= "</div>";
		}		
	} else {
		$category = tl_get_category($_GET['category']);
		if ($category instanceof TalentLMS_ApiError) {
			$output .= "<div class='alert alert-error'>";
			$output .= $category -> getMessage();
			$output .= "</div>";
		}
		$category_price = (preg_replace("/\D+/", "", html_entity_decode($category['price'])) == 0) ? '-' : $category['price'];
		$courses = $category['courses'];
	}
	$categories = tl_get_categories();
	if ($categories instanceof TalentLMS_ApiError) {
		$output .= "<div class='alert alert-error'>";
		$output .= $categories -> getMessage();
		$output .= "</div>";
	}

	if(get_option('tl-courses-page-template') == 'tl-courses-page-template-pagination'){
			
		// Setup pagination
		if (get_option('tl-courses-page-pagination-template-courses-per-page')) {
			$pagination_details = tl_setup_courses_pagination($courses, $_GET['paging']);
			extract($pagination_details);
		}
		
		// Load template
		switch(get_option('tl-courses-page-pagination-template')) {
			case 'tl-categories-right' :
				include (_BASEPATH_ . '/templates/courses_pagination_templates/categories_right.php');
				break;
			case 'tl-categories-left' :
				include (_BASEPATH_ . '/templates/courses_pagination_templates/categories_left.php');
				break;
			case 'tl-categories-top' :
				include (_BASEPATH_ . '/templates/courses_pagination_templates/categories_top.php');
				break;
		}		
	} else {
		wp_enqueue_script('tl-courses-tree-template', _BASEURL_ . 'js/tl-courses-tree-template.js', false, '1.0');
		include (_BASEPATH_ . '/templates/courses_tree_template.php');
	}
}
?>

