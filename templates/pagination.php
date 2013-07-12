<?php
$output .= "<div class='tl-pagination'>";

$query_string = ($_GET['tlcategory']) ? '&tlcategory=' . $_GET['tlcategory'] : '';

$output .= "<ul>";
if ($currentpage > 0 && $currentpage < $numofpages) {
	$output .= "<li><a href='?paging=" . ($currentpage - 1) . $query_string . "'>" . __('Prev') . "</a></li>";
}

for ($i = 0; $i < $numofpages; $i++) {
	$output .= "<li><a href='?paging=" . $i . $query_string . "'>" . $i . "</a></li>";
}

if ($numofpages > $currentpage && ($currentpage + 1) < $numofpages) {
	$output .= "<li><a href='?paging=" . ($currentpage + 1) . $query_string . "'>" . __('Next') . "</a></li>";
}

$output .= "</ul>";
$output .= "</div>";
?>