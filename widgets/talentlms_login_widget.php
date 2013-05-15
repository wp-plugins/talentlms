<?php
/**
 * TalentLMS login widget
 *
 * @since 1.0
 */
class TalentLMS_login extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_talentlms_login', 'description' => __('Login form to TalentLMS'));
		parent::__construct('talentlms-login', __('Login to TalentLMS'), $widget_ops);
	}

	function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';

		echo "<p>";
		echo "<label for='" . $this -> get_field_id('title') . "'>" . _('Title:') . "</label>";
		echo "<input class='widefat' id='" . $this -> get_field_id('title') . "' name='" . $this -> get_field_name('title') . "' type='text' value='" . $title . "' />";
		echo "</p>";

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint($new_instance['number']);
		return $instance;
	}

	function widget($args, $instance) {
		global $wpdb;
		extract($args, EXTR_SKIP);
		$loggin_error = false;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

		$output = '';

		$output .= $before_widget;
		if ($title)
			$output .= $before_title . $title . $after_title;

		if ($_POST['talentlms-logout']) {
			session_start();
			unset($_SESSION['talentlms_user_id']);
			unset($_SESSION['talentlms_user_login']);
			unset($GLOBALS['talentlms_error_msg']);
		}

		if ($_POST['talentlms-login'] && $_POST['talentlms-password']) {
			try {
				$login = TalentLMS_User::login(array('login' => $_POST['talentlms-login'], 'password' => $_POST['talentlms-password'], 'logout_redirect' => (get_option('tl-logout') == 'WP') ? get_bloginfo('wpurl') : ''));
				session_start();
				$_SESSION['talentlms_user_id'] = $login['user_id'];
				$_SESSION['talentlms_user_login'] = $_POST['talentlms-login'];
	            $_SESSION['talentlms_user_pass'] = $_POST['talentlms-password'];
				
				unset($GLOBALS['talentlms_error_msg']);
			} catch (Exception $e) {
				if ($e instanceof TalentLMS_ApiError) {
					$loggin_error = true;
				}
			}

		}

		if (isset($_SESSION['talentlms_user_id'])) {
			try {
				session_start();
				$user = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
				$login = TalentLMS_User::login(array('login' => $_SESSION['talentlms_user_login'], 'password' => $_SESSION['talentlms_user_pass'], 'logout_redirect' => (get_option('tl-logout') == 'WP') ? get_bloginfo('wpurl') : ''));
				
				$output .= "<span style='display:block'>" . _('Welcome back') . " <b>" . $user['first_name'] . " " . $user['last_name'] . "</b></span>";
				$output .= "<span style='display:block'>" . _('Goto to your learning portal') . " <a target='_blank' href='" . tl_talentlms_url($login['login_key']) . "'>" . _('here') . "</a></span>";

				$output .= "<form class='tl-form-horizontal' method='post' action='" . current_page_url() . "'>";
				$output .= "<input id='talentlms-login' name='talentlms-logout' type='hidden' value='logout'>";
				$output .= "<button class='btn' type='submit'>" . _('Logout') . "</button>";
				$output .= "</form>";
			} catch (Exception $e) {
				if ($e instanceof TalentLMS_ApiError) {
					$output .= "<div class=\"alert alert-error\">";
					$output .= $e -> getMessage();
					$output .= "</div>";
					
					$output .= "<form class='tl-form-horizontal' method='post' action='" . current_page_url() . "'>";
					$output .= "<div>";
					$output .= "<label for='talentlms-login'>" . _('Login') . "</label>";
					$output .= "<div >";
					$output .= "<input class='span' id='talentlms-login' name='talentlms-login' type='text'>";
					$output .= "</div>";
					$output .= "</div>";
					$output .= "<div>";
					$output .= "<label for='talentlms-password'>" . _('Password') . "</label>";
					$output .= "<div >";
					$output .= "<input class='span' id='talentlms-password' name='talentlms-password' type='password'>";
					$output .= "</div>";
					$output .= "</div>";
					$output .= "<div class='form-actions' style='text-align:right;'>";
					$output .= "<button class='btn' type='submit'>" . _('Login') . "</button>";
					$output .= "</div>";
					$output .= "</form>";
					$output .= "<div>";
					$output .= "<a href='" . get_page_link(get_option("tl_forgot_page_id")) . "'>"._('Forgot login/password?')."</a>";
					$output .= "</div>";
				}
			}
		} else {

			if ($loggin_error) {
				$output .= "<div class=\"alert alert-error\">";
				$output .= $e -> getMessage();
				$output .= "</div>";
			}

			$output .= "<form class='tl-form-horizontal' method='post' action='" . current_page_url() . "'>";
			$output .= "<div>";
			$output .= "<label for='talentlms-login'>" . _('Login') . "</label>";
			$output .= "<div >";
			$output .= "<input class='span' id='talentlms-login' name='talentlms-login' type='text'>";
			$output .= "</div>";
			$output .= "</div>";
			$output .= "<div>";
			$output .= "<label for='talentlms-password'>" . _('Password') . "</label>";
			$output .= "<div >";
			$output .= "<input class='span' id='talentlms-password' name='talentlms-password' type='password'>";
			$output .= "</div>";
			$output .= "</div>";
			$output .= "<div class='form-actions' style='text-align:right;'>";
			$output .= "<button class='btn' type='submit'>" . _('Login') . "</button>";
			$output .= "</div>";
			$output .= "</form>";
			$output .= "<div>";
			$output .= "<a href='" . get_page_link(get_option("tl_forgot_page_id")) . "'>"._('Forgot login/password?')."</a>";
			$output .= "</div>";
		}
		$output .= $after_widget;
		echo $output;

	}

}
?>