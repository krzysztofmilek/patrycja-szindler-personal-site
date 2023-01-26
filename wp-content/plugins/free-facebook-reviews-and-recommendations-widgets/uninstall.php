<?php
require_once plugin_dir_path( __FILE__ ) . 'trustindex-plugin.class.php';
$trustindex_pm_facebook = new TrustindexPlugin_facebook("facebook", __FILE__, "9.7.1", "Widgets for Social Reviews & Recommendations", "Facebook");
$trustindex_pm_facebook->uninstall();
?>