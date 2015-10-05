<?php
// wooCommerce Integration
/**
 * Detect plugin. For use on Front End only.
 */

function integrateWooCommerce() {
	//plugin is activated
	$current_user = wp_get_current_user();
	$user_id = $current_user -> ID ;
	$courses = tl_get_courses();

	//create product categories
	$categories = tl_categories_tree(tl_get_categories());
	tlwc_create_categories($categories);

	
	$terms = get_terms('product_cat', array('hide_empty' => 0));
	
	// create products
	foreach ($courses as $course) {
		if(!$course['hide_from_catalog'] && $course['status'] == 'active'){
			preg_match_all('!\d+!', $course['price'], $matches);
			$post = array(
					'post_author' => $user_id,
					'post_content' => $course['description'],
					'post_status' => "publish",
					'post_title' => $course['name'],
					'post_parent' => '',
					'post_type' => "product",
			);

			$post_id = wp_insert_post($post, $wp_error);

			wp_set_object_terms($post_id, $course['category_name'], 'product_cat' );
			wp_set_object_terms($post_id, 'simple', 'product_type');

			update_post_meta($post_id, '_visibility', 'visible');
			update_post_meta($post_id, '_stock_status', 'instock');
			update_post_meta($post_id, 'total_sales', '0');
			update_post_meta($post_id, '_downloadable', 'no');
			update_post_meta($post_id, '_virtual', 'yes');
			update_post_meta($post_id, '_purchase_note', "");
			update_post_meta($post_id, '_featured', "no");
			update_post_meta($post_id, '_weight', "");
			update_post_meta($post_id, '_length', "");
			update_post_meta($post_id, '_width', "");
			update_post_meta($post_id, '_height', "");
			update_post_meta($post_id, '_sku', "");
			update_post_meta($post_id, '_product_attributes', array());
			update_post_meta($post_id, '_sale_price_dates_from', "");
			update_post_meta($post_id, '_sale_price_dates_to', "");
			update_post_meta($post_id, '_price', $matches[0][1]);
			update_post_meta($post_id, '_regular_price', $matches[0][1]);
			update_post_meta($post_id, '_sale_price', $matches[0][1]);
			update_post_meta($post_id, '_sold_individually', "");
			update_post_meta($post_id, '_manage_stock', "no");
			update_post_meta($post_id, '_backorders', "no");
			update_post_meta($post_id, '_stock', "");
			
			
			//add product image:
			//require_once 'inc/add_pic.php';
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			$thumb_url = $course['big_avatar'];
			
			// Download file to temp location
			$tmp = download_url($thumb_url);
			
			// Set variables for storage
			// fix file name for query strings
			preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
			$file_array['name'] = basename($matches[0]);
			$file_array['tmp_name'] = $tmp;
			
			// If error storing temporarily, unlink
			if ( is_wp_error( $tmp ) ) {
				@unlink($file_array['tmp_name']);
				$file_array['tmp_name'] = '';
				$logtxt .= "Error: download_url error - $tmp\n";
			}else{
				$logtxt .= "download_url: $tmp\n";
			}
			
			//use media_handle_sideload to upload img:
			$thumbid = media_handle_sideload($file_array, $post_id, $course['name']);
			// If error storing permanently, unlink
			if ( is_wp_error($thumbid) ) {
				@unlink($file_array['tmp_name']);
				$file_array['tmp_name'] = '';				
			}
			
			set_post_thumbnail($post_id, $thumbid);			
			
		}
	}
}

function tlwc_create_categories($categories) {
	// Turn off all error reporting
	error_reporting(0);
	foreach ($categories as $node) {
		if (!$node['parent_category_id']) {
			tlwc_create_category($node);
		}
	}
}

function tlwc_create_category($node, $parent_id) {
	$wp_cat_id = wp_insert_category(array(
		'cat_name' => $node['name'],
		'category_nicename' => strtolower($node['name']),
		'category_parent' => $parent_id,
		'taxonomy' => 'product_cat'));
	if (is_array($node['children'])) {
		foreach ($node['children'] as $child) {
			tlwc_create_category($child, $wp_cat_id);
		}
	}
}


integrateWooCommerce();


