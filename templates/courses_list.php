<?php

/*
$output .= "<div>";
$output .= "<a href='javascript:void(0);' onclick='listView();'><i class='fa fa-th-list'></i></a>";
$output .= "&nbsp;";
$output .= "<a href='javascript:void(0);' onclick='gridView();'><i class='fa fa-th-large'></i></a>";
$output .= "</div>";
*/
if (isset($_SESSION['talentlms_user_id'])) {
	$user = TalentLMS_User::retrieve($_SESSION['talentlms_user_id']);
	$user_courses = array();
	foreach ($user['courses'] as $c) {
		$user_courses[] = $c['id'];
	}
}

if(get_option('tl-catalog-view-mode') == 'list') {
	$output .= "<script type='text/javascript'>";
	$output .= "	jQuery(document).ready(function() {";
	$output .= "		var listTable = jQuery('#tl-catalog-list').DataTable({";
	$output .= "			'bLengthChange': false,";
	$output .= "			'oLanguage': { 'sSearch': '' } ,";
	$output .= "			'pageLength': ".get_option('tl-catalog-per-page').",";
	$output .= "			'columnDefs':[{";
	$output .= "				'targets': [ 3 ],";
	$output .= "				'visible': false,";
	$output .= "				'searchable': true";
	$output .= "			},{";
	$output .= "				'targets': [ 4 ],";
	$output .= "				'visible': false,";
	$output .= "				'searchable': true";
	$output .= "			},{";
	$output .= "				'targets': [ 5 ],";
	$output .= "				'visible': false,";
	$output .= "				'searchable': false";
	$output .= "			},{";
	$output .= "				'targets': [ 6 ],";
	$output .= "				'visible': false,";
	$output .= "				'searchable': true";
	$output .= "			}],";
	$output .= "		});";
	
	$output .= "		jQuery('.dataTables_filter input').attr('placeholder', '".__("Search")."');";
	
	$output .= "		jQuery('#tl-sort-by').change(function(){";
	$output .= "			var column_index = jQuery('#tl-sort-by').val();";
	$output .= "			var oSettings = jQuery('#tl-catalog-list').dataTable().fnSettings();";
	$output .= "			var direction = oSettings.aaSorting[0][1];";
	//$output .= "			alert(direction + ' - ' + column + ' - ' + column_index);";

	$output .= "			if(column_index == '3') {";
	$output .= "				jQuery('#tl-catalog-list').dataTable().fnSort([[3, 'desc']]);";
	$output .= "				return;";
	$output .= "			}";
	
	$output .= "			if(column_index == '5' || column_index == '6') {";
	$output .= "				if(direction == 'desc') {";
	$output .= "					jQuery('#tl-catalog-list').dataTable().fnSort([[column_index, 'asc']]);";
	$output .= "				} else {";
	$output .= "					jQuery('#tl-catalog-list').dataTable().fnSort([[column_index, 'desc']]);";
	$output .= "				}";
	$output .= "			}";
	$output .= "		});";	

	$output .= "	});";
	
	$output .= "	function sortByCourseCategory(category_id){";
	$output .= "		var listTable = jQuery('#tl-catalog-list').DataTable();";
	$output .= "		listTable.column(4).search(category_id, true, true).draw();";
	$output .= "	};";	
	
	$output .= "</script>";

	
	$output .= "<div class='tl-catalog'>";

	if(get_option('tl-catalog-categories') == 'left') {
		$categories_side = 'tl-left';
		$courses_side = 'tl-right';
	} else if (get_option('tl-catalog-categories') == 'right') {
		$categories_side = 'tl-right';
		$courses_side = 'tl-left';
	}	
	
	/* Categories filter */
	$categories_filter .= "	<div class='tl-catalog-categories ".$categories_side."'>";
	
	$Catoption = 'roukou';
	if($Catoption == 'dropdown') {
		$categories_filter .= "			<select id='tl-category-filter' name='tl-category-filter'>";
		$categories_filter .= "				<option value='-1'>".__('All courses')."</option>";
		foreach($categories as $category) {
			$categories_filter .= "				<option value='".$category['id']."'>".$category['name']."</option>";
		}
		$categories_filter .= "			</select>";
		$categories_filter .= "			<script type='text/javascript'>";
		$categories_filter .= "				jQuery('#tl-category-filter').change(function(){";
		$categories_filter .= "					var myTable = jQuery('#tl-catalog-list').DataTable();";
		$categories_filter .= "					var categoryId = jQuery('#tl-category-filter').val();";
		$categories_filter .= "					if(categoryId == -1) {";
		$categories_filter .= "						jQuery('#tl-catalog-list').dataTable().fnFilter('', 4)";
		$categories_filter .= "					} else {";
		$categories_filter .= "						myTable.column(4).search(categoryId, true, true).draw();";
		$categories_filter .= "					}";
		$categories_filter .= "				});";
		$categories_filter .= "			</script>";
	}else {
		$categories_filter .= "		<ul>";
		$categories_filter .= "			<span><a id='tl-all-categories-filter' href='javascript:void(0);'>".__('All courses')."</a></span>";
		foreach($categories as $category) {
			$categories_filter .= "		<li>";
			$categories_filter .= "			<input type='checkbox' class='tl-category-filter' name='tl-category-filter' value='".$category['id']."' />";
			$categories_filter .= 				$category['name'] . " (" . $category['courses_count'] . ")" . "<br />";
			$categories_filter .= "		</li>";
		}
		$categories_filter .= "		</ul>";
		
		$categories_filter .= "<script type='text/javascript'>";

		$categories_filter .= "		jQuery('.tl-category-filter').click(function(){";
		$categories_filter .= "			var selected_filter = new Array();";
		$categories_filter .= "			jQuery('.tl-category-filter').each(function() {";
		$categories_filter .= "				if(this.checked) {";
		$categories_filter .= "					selected_filter.push(jQuery(this).val());";
		$categories_filter .= "				}";
		$categories_filter .= "			});";
		$categories_filter .= "			if(selected_filter.length > 0) {";
		$categories_filter .= "				var myTable = jQuery('#tl-catalog-list').DataTable();";
		$categories_filter .= "				myTable.column(4).search(selected_filter.join('|'), true, true).draw();";
		$categories_filter .= "			} else {";
		$categories_filter .= "				jQuery('#tl-catalog-list').dataTable().fnFilter('', 4)";
		$categories_filter .= "			}";
		$categories_filter .= "		});";
		
		$categories_filter .= "		jQuery('#tl-all-categories-filter').click(function(){";
		$categories_filter .= "			jQuery('.tl-category-filter').each(function() {";
		$categories_filter .= "				jQuery(this).attr('checked', false);";
		$categories_filter .= "			});";
		$categories_filter .= "			jQuery('#tl-catalog-list').dataTable().fnFilter('', 4);";
		$categories_filter .= "		});";
		$categories_filter .= "</script>";
	}

	$categories_filter .= "		<hr />";
	$categories_filter .= "		<div class='tl-order-by-filter'>";
	$categories_filter .= "			<span>".__('Sort by')."</span>";
	$categories_filter .= "			<select id='tl-sort-by' name='tl-sort-by'>";
	$categories_filter .= "				<option value='6'>".__('Name')."</option>";
	$categories_filter .= "				<option value='5'>".__('Date')."</option>";
	$categories_filter .= "				<option value='3'>".__('Price')."</option>";
	$categories_filter .= "			</select>";
	$categories_filter .= "		</div>";
	
	$categories_filter .= "	</div>";
		
	$course_list .= "	<div class='tl-catalog-courses ".$courses_side."'>";
	$course_list .= "		<table id='tl-catalog-list' cellspacing='0' width='100%'>";
	$course_list .= "		<thead>";
	$course_list .= "			<tr>";
	$course_list .= "				<th style='display:none;'></th>";
	$course_list .= "				<th style='display:none;'></th>";//name
	$course_list .= "				<th style='display:none;'></th>";
	$course_list .= "				<th></th>";//price
	$course_list .= "				<th></th>";//category
	$course_list .= "				<th></th>";//date
	$course_list .= "				<th></th>";//name
	$course_list .= "			</tr>";
	$course_list .= "		</thead>";
	$course_list .= "		<tbody>";
	foreach ($courses as $course) {
		$courseTitle  = "<span class='tl-course-name'>".$course['name'] ."</span>";
		$courseTitle .= ($course['code']) ? " <span class='tl-course-code'>(". $course['code'] . ")</span>" : '';
		
		$price = (preg_replace("/\D+/", "", html_entity_decode($course['price'])) == 0) ? '-' : $course['price'];
	
		$course_list .= "<tr>";
		$course_list .= "<td class='tl-course-thumb'>";
		$course_list .= "<a href=\"?tlcourse=" . $course['id'] . "\">";
		if (strstr($course['avatar'], 'unknown_small.png')) {
			$course_list .= "<img title=\"" . $course['name'] . "\" title=\"" . $courseTitle . "\" alt=\"" . $courseTitle . "\" src=\"" . $course['avatar'] . "\">";
		} else {
			$course_list .= "<img title=\"" . $course['name'] . "\" title=\"" . $courseTitle . "\" alt=\"" . $courseTitle . "\" src=\"" . $course['avatar'] . "\">";
		}
		$course_list .= "</a>";
		$course_list .= "</td>";
		$course_list .= "<td>";
		$course_list .= "<a class='tl-course-title' href=\"?tlcourse=" . $course['id'] . "\">".$courseTitle."</a>";
		$course_list .= "<br />";
		$course_list .= "<span style='cursor: pointer;' onclick='sortByCourseCategory(".$course['category_id'].")'>".$course['category_name']."</span>";
		$course_list .= "<div>".$course['description']."</div>";
		$course_list .= "</td>";
		$course_list .= "<td class='tl-course-price-btn'>";
		if($price != '-') {
			$course_list .= "<a class='btn btn-small' href=\"?tlcourse=" . $course['id'] . "\">".__('More info')." (".$course['price'].")"."</a>";
		} else {
			$course_list .= "<a class='btn btn-small' href=\"?tlcourse=" . $course['id'] . "\">".__('More info')."</a>";
		}
		if($_SESSION['talentlms_user_id'] && in_array($course['id'], $user_courses)) {
			$course_list .= "<span class='tl-label-own'>".__('You have this course')."</span>";
		}
		$course_list .= "</td>";
		$course_list .= "<td>";
		$course_list .= $price;
		$course_list .= "</td>";
		$course_list .= "<td>";
		$course_list .= $course['category_id'];
		$course_list .= "</td>";
		$course_list .= "<td>";
		$course_list .= strtotime($course['creation_date']);
		$course_list .= "</td>";
		$course_list .= "<td>";
		$course_list .= $course['name'];
		$course_list .= "</td>";
	
		$course_list .= "</tr>";
	}
	$course_list .= "		</tbody>";
	$course_list .= "		</table>";
	$course_list .= "	</div>";
	
	if(get_option('tl-catalog-categories') == 'left') {
		$output .= $categories_filter . $course_list;
	} else if (get_option('tl-catalog-categories') == 'right') {
		$output .= $course_list . $categories_filter ;
	}
	
	$output .= "</div>";
}
