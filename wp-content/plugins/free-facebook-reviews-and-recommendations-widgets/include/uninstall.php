<?php
foreach($this->get_option_names() as $opt_name)
{
delete_option($this->get_option_name($opt_name));
}
global $wpdb;
include $this->get_plugin_dir() . 'include' . DIRECTORY_SEPARATOR . 'schema.php';
foreach(array_keys($ti_db_schema) as $table_name)
{
$wpdb->query('DROP TABLE IF EXISTS `'. $this->get_tablename($table_name) .'`');
}
?>