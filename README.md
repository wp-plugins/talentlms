TalentLMS-WordPress-Plugin
==========================

This plugin integrates Talentlms with Wordpress. Use this plugin to promote your TalentLMS content through your WordPress site.

- Features:

1. List your TalentLMS courses and their content in WordPress.
2. List your TalentLMS users and their details in WordPress.
3. Allow users to signup to TalentLMS through your WordPress site.
4. Allow users to buy your TalentLMS courses through your WordPress site.

- Usage:

1. Courses: To list your TalentLMS courses use the shortcode [talentlms-courses]
2. Users: To list your TalentLMS users use the shortcode [talentlms-users]
3. Singup: To get a signup form to TalentLMS use [talentlms-signup]

- Caching

	* Each time you retreive a TalentLMS item (courses list, single course, categories list etc) this item is cached for performance reasons.
	  If you want to force cached items to be updated you should clear your cache. (Administration Panel > TalentLMS > Clear cache)

- Setting up TalentLMS WordPress plugin:

1. You need to change your Wordpress settings under Administration Panel > Settings > Permalink Settings
   You MUST change your Common Settings to use Post name
	  
2. Aftet plugin installation you need to provide your TalentLMS Domain and API key

=================================================================================================================================

VERSION 1.8:

	FEATURES:
		* Users page which lists instructors and instructor details
		* Customizable template for users page
		* Upon plugin installation courses, users and signup WordPress page with shortcodes are created.
		* Error messages of each TalentLMS API call
		* Clean CSS rules defined for each TalentLMS element
		* New version of TalentLMS API PHP library
		
	BUGFIX:
		* Various security issues
		
VERSION 1.7:

	FEATURES:
		* Tree like representation of TalentLMS categories 
		
	BUGFIX:
				
VERSION 1.6:

	FEATURES:
		* Single course template options
		* Courses list template options
		
	BUGFIX:
		* Courses pagination does not include inactive or hidden from catalog courses

VERSION 1.5:

	FEATURES:
		* Course thumbnails static urls
		
	BUGFIX:

VERSION 1.4:

	FEATURES:
		* TalentLMS signup supports TalentLMS custom fields
		
	BUGFIX:

VERSION 1.3:

	FEATURES:
		* Content to WordPress pages is inserted in its relative position to shortcodes.
		* Show instructors' names in single course page
		* Certification kai Certification duration removed from course page
		
	BUGFIX:
		* Mishandling of inactive and not-for-catalog courses
		* Bottom pagination bug fix 

VERSION 1.2: 

	FEATURES:
		* TalentLMS CSS editor in Wordpress Administration Panel
		* TalentLMS Option for customizition of TalentLMS Plugins
			- Courses per page
			- Templates for course page
			- Action after signup
		* Caching of TalentLMS data
		* Login modal in single course page
		* Users are prompted to buy TalentLMS course instead of just getting it

	BUGFIX:


VERSION 1.1: 
 
	FEATURES:
		* Users can go to courses in TalentLMS

	BUGFIX:
		* Login fixed
		* When logged in user first name/last name appear correctly
		* Course prices appear correctly

VERSION 1 (Initial release): 
 
	FEATURES:
 		* Administration Panel for TalentLMS management
 		* Login to TalentLMS widget for Wordpress
 		* shortcode for signup page to TalentLMS
 		* shortcode for listing courses from TalentLMS
	
	BUGFIX: