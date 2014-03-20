=== TalentLMS WordPress plugin ===
Contributors: V. 
Tags: TalentLMS, elearning, lms, lcms, hcm, learning management system
Requires at least: 2.0
Tested up to: 3.8.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin integrates Talentlms with Wordpress. Promote your TalentLMS content through your WordPress site.

== Description ==

[TalentLMS](http://www.talentlms.com/ "TalentLMS super-easy, cloud-based learning platform") is a cloud-based, lean LMS with an emphasis on usability and easy course creation. With TalentLMS we wanted to create a better learning experience in every way that actually matters – and we are excited about this new offering. The product focuses on small but growing organizations. There are a number of obstacles that prohibit small organizations from using elearning. To be productive, small businesses need a number of tools and several related services such as setup and maintenance, course creation and the support of end-users. All these require ample time, resources and money. It comes as no surprise that most small organizations find elearning a non-viable pursuit and prefer on-job or informal training methods.

Read more about TalentLMS in:

* [TalentLMS - an Introduction](http://blog.talentlms.com/talentlms-an-introduction/ "TalentLMS - an Introduction")
* [TalentLMS - Get started in 5'](http://blog.talentlms.com/talentlms-get-started-in-5/ "TalentLMS - Get started in 5'")

## Plugin Features ##

1. List your TalentLMS courses and their content in WordPress.
2. List your TalentLMS users and their details in WordPress.
3. Allow users to signup to TalentLMS through your WordPress site.
4. Allow users to buy your TalentLMS courses through your WordPress site.
5. Synch your TalentLMS content (courses and categories) with your WordPress site. Make your TalentLMS categories WP categories and your TalentLMS courses WP posts

- Caching

	* Each time you retreive a TalentLMS item (courses list, single course, categories list etc) this item is cached for performance reasons.
	  If you want to force cached items to be updated you should clear your cache. (_Administration Panel > TalentLMS > Clear cache_)


== Installation ==

#To Install:#

1. Download TalentLMS WordPress plugin
1. Unzip the file into a folder on your hard drive
1. Upload `/talentlms/` folder to the `/wp-content/plugins/` folder on your site
1. Visit your WordPress _Administration -> Plugins_ and activate TalentLMS WordPress plugin

Alternatively you can automatically install TalentLMS WordPress plugin from the  WordPress Plugin Directory. 

#Usage:#

* Once you have activated the plugin, provide your TalentLMS Domain name and TalentLMS API key.
* You must update your permalinks to use "Custom Structure" or if your using WordPress 3.3 and above you can use the "Post name" option just as long as you have `/%postname%/` at the end of the url. 
* Login to TalentLMS widget : Use this widget to login to your TalentLMS domain
* Use the shortcodes:
	* `[talentlms-courses]` : to list your TalentLMS courses
	* `[talentlms-users]`   : to list your TalentLMS users
	* `[talentlms-signup]`  : to have a signup form to TalentLMS
	* `[talentlms-forgot-credentials]`  : to have a forgot my credentials form to TalentLMS

== Frequently Asked Questions ==

If you have a question or any feedback you want to share send us an email at [support@talentlms.com](mailto:support@talentlms.com 'support')

== Screenshots ==

Here are some screenshots of the TalentLMS WordPress plugin.

##Administration panel##

1. Administration panel > TalentLMS main options.
`assets/screenshot-1.png`

2. Administration panel > TalentLMS > TalentLMS Options.
`assets/screenshot-2.png`

3. Administration panel > TalentLMS > TalentLMS Options.
`assets/screenshot-3.png`

4. Administration panel > TalentLMS > TalentLMS and WP Synchronization.
`assets/screenshot-4.png`

5. Administration panel > TalentLMS > Edit TalentLMS CSS.
`assets/screenshot-5.png`

##Front End##

1. TalentLMS courses list pagination
`assets/screenshot-6.png`

2. TalentLMS courses list tree
`assets/screenshot-7.png`

3. TalentLMS single course
`assets/screenshot-8.png`

4. TalentLMS users list
`assets/screenshot-9.png`

5. TalentLMS single user
`assets/screenshot-10.png`

6. TalentLMS signup
`assets/screenshot-11.png`

7. TalentLMS login widget
`assets/screenshot-12.png`




== Changelog ==

= 3.13 =

* New signup methods supported

= 3.12 =

* Edit TalentLMS CSS bug fixed

= 3.11 =

* Sync users bugs fixed
* Forgot login/pass bugs fixed

= 3.10 =

* New version of TalentLMSLib

= 3.9.1 =

* Signup issues fixed

= 3.9 =

* Forgot login/password checkboxes

= 3.8 =

* Forgot login/password bug fix

= 3.7 =

* More signup methods supported 

= 3.6 =

* Bugfix in custom fields 

= 3.5 =

* Bugfix in custom fields in signup page in case of multiple select custom fields

= 3.4 =

* Various typos fixed 

= 3.3 =

* Fixes issue with conflicts with other WP plugin due to query strings 

= 3.2 =

* New version of TalentLMS PHP library 

= 3.0 =

* TalentLMS users shortcode
* Sync TalentLMS content with WP 

= 2.2 =

* Building categories tree recursively. No longer depending to libxml PHP extension

= 2.1 =

* Plugin connects to TalentLMS domain map, if exists, instead of talentLMS domain
* Units in course, link to TalentLMS units (redirect without second login) 

= 2.0 =

* CSS additions

= 1.9.1 =

* When purchasing a course, does not redirect to PayPal

= 1.9 =

* Single course view, unit urls when user is logged in.

= 1.8 =

* Users page which lists instructors and instructor details
* Customizable template for users page
* Upon plugin installation courses, users and signup WordPress page with shortcodes are created.
* Error messages of each TalentLMS API call
* Clean CSS rules defined for each TalentLMS element
* New version of TalentLMS API PHP library

= 1.7 =

* Tree like representation of TalentLMS categories 

= 1.6 =

* Single course template options
* Courses list template options

= 1.5 =

* Course thumbnails static urls

= 1.4 =

* TalentLMS signup supports TalentLMS custom fields

= 1.3 = 

* Content to WordPress pages is inserted in its relative position to shortcodes.
* Show instructors' names in single course page
* Certification kai Certification duration removed from course page

= 1.2 =

* TalentLMS CSS editor in Wordpress Administration Panel
* TalentLMS Option for customizition of TalentLMS Plugins
	* Courses per page
	* Templates for course page
	* Action after signup
* Caching of TalentLMS data
* Login modal in single course page
* Users are prompted to buy TalentLMS course instead of just getting it

= 1.1 =

* Users can go to courses in TalentLMS

= 1.0 (Initial release) =

* Administration Panel for TalentLMS management
* Login to TalentLMS widget for Wordpress
* shortcode for signup page to TalentLMS
* shortcode for listing courses from TalentLMS

== Upgrade Notice ==

= 3.1 =

* Various minor bugfixes

= 3.0 =

* Updated version of TalentLMS library
* Various minor/major bugfixes

= 2.0 =

* Users can buy categories

= 1.9.1 =

* When purchasing a course, does not redirect to PayPal fixed

= 1.8 =

Various security issues

= 1.6 =

Courses pagination does not include inactive or hidden from catalog courses

= 1.3 = 

Mishandling of inactive and not-for-catalog courses
Bottom pagination bug fix 

= 1.1 =

Login fixed
When logged in user first name/last name appear correctly
Course prices appear correctly
