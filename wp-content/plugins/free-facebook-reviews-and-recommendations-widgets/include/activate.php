<?php
require_once(ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'upgrade.php');
global $wpdb;
$wpdb->hide_errors();
include $this->get_plugin_dir() . 'include' . DIRECTORY_SEPARATOR . 'schema.php';
$not_created_tables = [];
$mysql_error = "";
foreach(array_keys($ti_db_schema) as $table_name)
{
if(!$this->is_table_exists($table_name))
{
dbDelta($ti_db_schema[ $table_name ]);
}
if($wpdb->last_error)
{
$mysql_error = $wpdb->last_error;
}
if(!$this->is_table_exists($table_name))
{
$not_created_tables []= $table_name;
}
}
if($not_created_tables)
{
$this->loadI18N();
deactivate_plugins(plugin_basename($this->plugin_file_path));
$sqls_to_run = array_map(function($table_name) use($ti_db_schema) {
return trim($ti_db_schema[ $table_name ]);
}, $not_created_tables);
$pre_style = 'background: #eee; padding: 10px 20px; word-wrap: break-word; white-space: pre-wrap';
wp_die(
'<strong>' . self::___('Plugin activation is failed because the required database tables could not created!') . '</strong><br /><br />' .
self::___('We got the following error from %s:', [ self::___('database') ]) .
'<pre style="'. $pre_style .'">'. $mysql_error .'</pre>' .
'<strong>' . self::___('Run the following SQL codes in your database administration interface (e.g. PhpMyAdmin) to create the tables or contact your system administrator:') . '</strong>' .
'<pre style="'. $pre_style .'">' . implode('</pre><pre style="'. $pre_style .'">', $sqls_to_run) . '</pre>' .
'<strong>' . self::___('Then try activate the plugin again.') . '</strong>'
);
}
update_option($this->get_option_name('active'), '1');
update_option($this->get_option_name('version'), $this->version);
?>