<?php
	if ($screen_id == $tl_admin_page) {
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About TalentLMS'),
			'content'	=>
				'<p>' . '<strong>' . __('TalentLMS') . '</strong>' . __(' a super-easy, cloud-based learning platform to train your people and customers') . '</p>' .
				'<p>' . '<strong>' . __('ShortCodes') . '</strong>' . '</p>' .
				'<ul>' .
					'<li>' . '<strong>[talentlms-courses]</strong> ' . __('Shortcode for listing your TalentLMS courses.') . '</li>' .
					'<li>' . '<strong>[talentlms-signup]</strong> ' . __('Shortcode for a signup to TalentLMS form. ') . '</li>' .
					'<li>' . '<strong>[talentlms-users]</strong> ' . __('Shortcode for listing your TalentLMS courses') . '</li>' .
					'<li>' . '<strong>[talentlms-forgot-credentials]</strong> ' . __('Shortcode for a forgot your TalentLMS username/password form') . '</li>' .
					'<li>' . '<strong>[talentlms-login]</strong> ' . __('Shortcode for a login to TalentLMS form') . '</li>' .
				'</ul>'
		) );
		get_current_screen()->add_help_tab( array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('TalentLMS Setup:') . '</p>' .
				'<ul>' .
					'<li>' . __('TalentLMS Domain: Fill in your TalentLMS domain.') . '</li>' .
					'<li>' . __('API Key: Fill in an TalentLMS API key.') . '</li>' .
				'</ul>' .
				'<p>' . __('Cache control:') . '</p>' .
				'<ul>' .
					'<li>' . __('Each time TalentLMS WordPress plugin communicates with TalentLMS via TalentLMS API the results are cached in WordPress. If you want to force communication of WordPress and TalentLMS clear your cache.') . '</li>' .
				'</ul>'
		) );
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.talentlms.com/" target="_blank">TalentLMS</a>') . '</p>' .
			'<p>' . __('<a href="http://support.talentlms.com/" target="_blank">Support</a>') . '</p>'
		);		
	}
	if($screen_id == $tl_options_page){
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About TalentLMS'),
			'content'	=>
				'<p>' . '<strong>' . __('TalentLMS') . '</strong>' . __(' a super-easy, cloud-based learning platform to train your people and customers') . '</p>'
		) );
		get_current_screen()->add_help_tab( array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('Logout options:') . '</p>' .
				'<ul>' .
					'<li>' . __('Choose what is going to happend each time you logout from TalentLMS. You can either stay in TalentLMS or get redirected back to your WP site. This option is valid only for the times that you have logged in to TalentLMS from your WP site, and have been redirect to TalentLMS from your WP site') .
				'</ul>' .
			
				'<p>' . __('Courses page - Courses page template:') . '</p>' .
				'<ul>' .
					'<li>' . __('Courses page - courses displayed in a tree-like representation within their nested categories') .
					'<li>' . __('Courses page with pagination') . 
						'<ul>' .
							'<li>' . __('Choose courses list template: You can have TalentLMS categories displayed on the right, left or top of your TalentLMS courses') . '</li>' .
							'<li>' . __('Courses per page: Choose how many courses are going to be displayed in each page. You can choose to have a top and a bottom pages navigation.') . '</li>' .
							'<li>' . __('Other options: Customize your courses list. Choose wheather your list shall include your one of the following: [courses thumbnails, descriptions, prices]') . '</li>' .
						'</ul>' .
					'</li>' .
				'</ul>' .
				'<p>' . __('Courses page - Single course page template:') . '</p>' .
				'<ul>' .
					'<li>' . __('Customize your single course page. Choose wheather the following details are going to be visible or not: [course description, course price, course instructors, course content, course rules, course prerequisites]') . '</li>' .
				'</ul>' .
				'<p>' . __('Users page - Users page template:') . '</p>' .
				'<ul>' .
					'<li>' . __('Customize your users page template. Choose wheather the following details are going to be visible or not: [user avatar, user bio]. Choose also how many users are going to be displayed in each page. You can choose to have a top and a bottom pages navigation.') . '</li>' .
				'</ul>' .
				'<p>' . __('Users page - Single user page template:') . '</p>' .
				'<ul>' .
					'<li>' . __('Customize your single users page template. Choose wheather the following details are going to be visible or not [user bio, user email, user courses]') . '</li>' .
				'</ul>' . 				
				'<p>' . __('Signup Page:') . '</p>' .
				'<ul>' .
					'<li>' . __('After a user signs up: After a user signs up select if he/she is going to be redirected to TalentLMS or stay in WP.') . '</li>' .
					'<li>' . __('Synchronize singup TalentLMS and WP: Select wheather after a user signs up to TalentLMS, he/she is going to be signed up to WP also.') . '</li>' .
				'</ul>' 				
		) );
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.talentlms.com/" target="_blank">TalentLMS</a>') . '</p>' .
			'<p>' . __('<a href="http://support.talentlms.com/" target="_blank">Support</a>') . '</p>'
		);			
	}
	if($screen_id == $tl_sync_page){
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About TalentLMS'),
			'content'	=>
				'<p>' . '<strong>' . __('TalentLMS') . '</strong>' . __(' a super-easy, cloud-based learning platform to train your people and customers') . '</p>'
		) );
		get_current_screen()->add_help_tab(array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('TalentLMS and WP Synchronization:') . '</p>' .
				'<ul>' .
					'<li>' . __('You can synchronize your TalentLMS and WP users, by making your WP also users in TalentLMS and vice versa. If you choose to perform a hard sync, all WP users\' details with the same username in TalentLMS will be overwritten by the corresponding TalentLMS details.') . '</li>' .
					'<li>' . __('You can synchronize your TalentLMS content with WP. Using this option, your TalentLMS categories will become WP categories and your TalentLMS courses will become WP posts assigned in the corresponding categories. NOTICE.! This synchronization will delete permanently your current WP categories and posts.') . '</li>' .
				'</ul>'
		));
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.talentlms.com/" target="_blank">TalentLMS</a>') . '</p>' .
			'<p>' . __('<a href="http://support.talentlms.com/" target="_blank">Support</a>') . '</p>'
		);
	}
	if($screen_id == $tl_css_page){
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About TalentLMS'),
			'content'	=>
				'<p>' . '<strong>' . __('TalentLMS') . '</strong>' . __(' a super-easy, cloud-based learning platform to train your people and customers') . '</p>'
		) );
		get_current_screen()->add_help_tab(array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('TalentLMS edit CSS:') . '</p>' .
				'<ul>' .
					'<li>' . __('You can edit CSS rules for TalentLMS WordPress plugin to best customize the look and feel of the plugin according to your WordPress theme.') . '</li>' .
				'</ul>'
		));
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.talentlms.com/" target="_blank">TalentLMS</a>') . '</p>' .
			'<p>' . __('<a href="http://support.talentlms.com/" target="_blank">Support</a>') . '</p>'
		);	
	}
	
	if($screen_id == $tl_subscriber_page) {
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About TalentLMS'),
			'content'	=>
				'<p>' . '<strong>' . __('TalentLMS') . '</strong>' . __(' a super-easy, cloud-based learning platform to train your people and customers') . '</p>'
		) );
		get_current_screen()->add_help_tab(array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('TalentLMS User Profile:') . '</p>' .
				'<ul>' .
					'<li>' . __('Login to TalentLMS if not already logged in.') . '</li>' .
					'<li>' . __('Once logged in view information about your profile, and navigate to TalentLMS and your TalentLMS course with one click') . '</li>' .
				'</ul>'
		));		
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.talentlms.com/" target="_blank">TalentLMS</a>') . '</p>' .
			'<p>' . __('<a href="http://support.talentlms.com/" target="_blank">Support</a>') . '</p>'
		);				
	}
	
?>