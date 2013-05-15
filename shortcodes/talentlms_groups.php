<?php

$output = "<div id='tl-group-container'>";

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

if($_POST['action'] == 'tl-join-group-post') {
	if($_POST['tl-group-key']) {
		if (isset($_SESSION['talentlms_user_id'])) {
			try{	
				$result = TalentLMS_Group::addUser(array('user_id' => $_SESSION['talentlms_user_id'], 'group_key' => $_POST['tl-group-key']));
				$output .= "<div class='alert alert-success'>";
				$output .= "<span style='display: block;'>" . _('You have successfully joined the group') . "</span>";
				$output .= "</div>";				
			} catch (Exception $e) {
				if ($e instanceof TalentLMS_ApiError) {
					$output .= "<div class='alert alert-error'>";
					$output .= $e -> getMessage();
					$output .= "</div>";
				}
			}			
		}
	} else {
		$output .= "<div class='alert alert-error'>";
		$output .= "<span style='display: block;'><strong>" . _('Group key cannot be empty') . "</strong></span>";
		$output .= "</div>";		
	}
}

$groups = tl_get_groups();

if (get_option('tl-groups-page-template-groups-per-page')) {
	$pagination_details = tl_setup_groups_pagination($groups, $_GET['paging']);
	extract($pagination_details);
}

if ((get_option('tl-groups-page-template-groups-per-page') && $numofpages > 1) && get_option('tl-groups-page-template-groups-top-pagination')) {
	include (_BASEPATH_ . '/templates/pagination.php');
}

$output .= "<table class='table'>";
$output .= "<thead>";
$output .= "<tr>";
$output .= "<th>" . __('Group Name') . "</th>";
$output .= "<th>" . __('Description') . "</th>";
$output .= "</tr>";
$output .= "</thead>";
$output .= "<tbody>";
foreach ($groups as $group) {
	$output .= "<tr class='tl-groups-list-tr'>";
	$output .= "<td>";
	if (isset($_SESSION['talentlms_user_id'])) {
		$output .= "<a id='tl-group-".$group['id']."' class='tl-group' href='javascript:void(0);'>" . $group['name'] . "</a>";
	} else {
		$output .= "<a id='tl-login-dialog-opener' href='javascript:void(0);'>" . $group['name'] . "</a>";
	}
	$output .= "</td>";
	$output .= "<td>" . $group['description'] . "</td>";
	$output .= "</tr>";
}

$output .= "</tbody>";
$output .= "</table>";

if ((get_option('tl-groups-page-template-groups-per-page') && $numofpages > 1) && get_option('tl-groups-page-template-groups-bottom-pagination')) {
	include (_BASEPATH_ . '/templates/pagination.php');
}

$output .= "<div id='tl-join-group-form-dialog' title='" . __('Join group') . "'>";
$output .= "	<form id='tl-join-group-form' name='tl-join-group-form' method='post' action='" . current_page_url() . "'>";
$output .= "		<input type='hidden' name='action' value='tl-join-group-post'>";
$output .= "		<fieldset>";
$output .= "			<div class='tl-form-group'>";
$output .= "				<label class='tl-form-label' for='tl-group-key'>" . __('Group Key:') . "</label>";
$output .= "				<div class='tl-form-control'>";
$output .= "					<input type='text' name='tl-group-key' id='tl-group-key' value='' />";
$output .= "				</div>";
$output .= "			</div>";
$output .= "		</fieldset>";
$output .= "	</form>";
$output .= "</div>";

include (_BASEPATH_ . '/templates/talentlms-login-dialog.php');

$output .= "</div>";
?>