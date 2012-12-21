<?php

global $wpdb;

define("TALENTLMS_TABLE", $wpdb -> prefix . "talentlms");

function talentlms_db_create() {

    global $wpdb;

    $sql = "CREATE TABLE " . TALENTLMS_TABLE . " (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                name VARCHAR(64),
                value LONGTEXT
            );";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);

}

function talentlms_db_drop() {
    global $wpdb;
    $wpdb -> query("DROP TABLE " . TALENTLMS_TABLE);
}

function get_cache_value($value_name) {
    global $wpdb;
    $db_result = $wpdb -> get_row("SELECT value FROM " . TALENTLMS_TABLE . " WHERE name = '" . $value_name ."'");
    return $db_result->value;
}

function add_cache_value($array) {
    global $wpdb;
    $wpdb -> insert(TALENTLMS_TABLE, array('name' => $array['name'], 'value' => $array['value']));
}

function update_cache_value($array) {
    global $wpdb;

    $wpdb -> update(TALENTLMS_TABLE, array('value' => $array['value'], ), array('name' => $array['name']));
}

function delete_value($value_name) {
    global $wpdb;
    $wpdb -> query("DELETE FROM " . TALENTLMS_TABLE . " WHERE name = '" . $value_name . "'");
}

function empty_cache_values() {
    global $wpdb;
    $wpdb -> query("TRUNCATE TABLE " . TALENTLMS_TABLE);
}

function is_cache_empty() {
    global $wpdb;
    $db_result = $wpdb->query("SELECT * FROM " . TALENTLMS_TABLE);
    if(!$db_result)
        return true;
    return false;
}
?>