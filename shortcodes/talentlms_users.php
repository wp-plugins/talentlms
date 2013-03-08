<?php

if (isset($_GET['user']) && $_GET['user'] != '') {
	$user = talentlms_get_user($_GET['user']);

	if ($user instanceof TalentLMS_ApiError) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $user -> getMessage();
		$output .= "</div>";
	} else {
		$output .= "<div id=\"user-single-container\">";

		$output .= "<div id='talentlms-user-avatar'>";
		$output .= "<img title=\"" . $user['first_name'] . " " . $user['last_name'] . "\" alt=\"" . $user['first_name'] . " " . $user['last_name'] . "\" src=\"" . $user['avatar'] . "\">";
		$output .= "</div>";

		$output .= "<div id=\"talentlms-user-details\">";
		$output .= "<h3><span title=\"" . $user['first_name'] . " " . $user['last_name'] . "\">" . $user['first_name'] . " " . $user['last_name'] . "</span></h3>";
		$output .= "</div>";
		$output .= "<div class=\"clear\"></div>";

		if ($user['email'] && get_option('talentlms-show-user-email')) {
			$output .= "<div id=\"talentlms-user-email\">";
			$output .= "<h2>" . __('Email:') . "</h2>";
			$output .= "<p><a href=\"mailto:" . $user['email'] . "\">" . $user['email'] . "</a></p>";
			$output .= "</div>";
		}

		if ($user['bio'] && get_option('talentlms-show-user-bio')) {
			$output .= "<div id=\"talentlms-user-bio\">";
			$output .= "<h2>" . __('Bio:') . "</h2>";
			$output .= "<p style=\"text-align: justify;\">" . $user['bio'] . "</p>";
			$output .= "</div>";
		}

		if (is_array($user['courses']) && get_option('talentlms-show-user-courses')) {
			$output .= "<div id=\"talentlms-user-courses\">";
			$output .= "<h2>" . __('Courses:') . "</h2>";
			$output .= "<ul>";
			foreach ($user['courses'] as $course) {
				$output .= "<li><a href=\"" . get_page_link(get_option("talentlms_courses_page_id")) . "?course=" . $course['id'] . "\">" . $course['name'] . "</a></li>";
			}
			$output .= "</ul>";
			$output .= "</div>";
		}

		$output .= "</div>";
	}

} else {
	$users = talentlms_get_users();
	if ($users instanceof TalentLMS_ApiError) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $users -> getMessage();
		$output .= "</div>";
	} else {
		$output .= "<div id=\"user-list-container\">";
		$output .= "<table class=\"table\">";
		$output .= "<thead>";
		$output .= "<tr>";
		if (get_option('talentlms-show-user-list-avatar')) {
			$output .= "<th colspan=\"2\" style=\"text-align: center\">" . __('Instructor') . "</th>";
		} else {
			$output .= "<th>" . __('Instructor') . "</th>";
		}
		if (get_option('talentlms-show-user-list-bio')) {
			$output .= "<th>" . __('Bio') . "</th>";
		}
		$output .= "</tr>";
		$output .= "</thead>";
		$output .= "<tbody>";
		foreach ($users as $user) {
			if (/*$user['user_type'] = 'Instructor' &&*/$user['status'] == 'active') {
				$output .= "<tr class=\"user-list-tr\">";

				if (get_option('talentlms-show-user-list-avatar')) {
					$output .= "<td>";
					$output .= "<a href=\"?user=" . $user['id'] . "\">";
					$output .= "<img title=\"" . $user['first_name'] . " " . $user['last_name'] . "\" alt=\"" . $user['first_name'] . " " . $user['last_name'] . "\" src=\"" . $user['avatar'] . "\">";
					$output .= "</a>";
					$output .= "</td>";
				}

				$output .= "<td>";
				$output .= "<a href=\"?user=" . $user['id'] . "\">" . $user['first_name'] . " " . $user['last_name'] . "</a>";
				$output .= "</td>";

				if (get_option('talentlms-show-user-list-bio')) {
					$output .= "<td>";
					if (get_option('talentlms-show-user-list-bio-limit')) {
						$output .= "<p>" . tl_limit_words($user['bio'], get_option('talentlms-show-user-list-bio-limit')) . "</p>";
					} else {
						$output .= "<p>" . $user['bio'] . "</p>";
					}
					$output .= "</td>";
				}

				$output .= "</tr>";
			}
		}
		$output .= "</tbody>";
		$output .= "</table>";
		$output .= "</div>";
	}
}
?>