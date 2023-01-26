<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if (!current_user_can('edit_pages'))
{
die('The account you\'re logged in to doesn\'t have permission to access this page.');
}
if(isset($_GET['rate_us']))
{
switch(sanitize_text_field($_GET['rate_us']))
{
case 'open':
update_option($trustindex_pm_facebook->get_option_name('rate-us'), 'hide', false);
$url = 'https://wordpress.org/support/plugin/'. $trustindex_pm_facebook->get_plugin_slug() . '/reviews/?rate=5#new-post';
header('Location: '. $url);
die;
case 'later':
$time = time() + (30 * 86400);
update_option($trustindex_pm_facebook->get_option_name('rate-us'), $time, false);
break;
case 'hide':
update_option($trustindex_pm_facebook->get_option_name('rate-us'), 'hide', false);
break;
}
echo "<script type='text/javascript'>self.close();</script>";
die;
}
if(isset($_GET['wc_notification']))
{
switch(sanitize_text_field($_GET['wc_notification']))
{
case 'open':
update_option('trustindex-wc-notification', 'hide', false);
$url = 'https://wordpress.org/plugins/customer-reviews-collector-for-woocommerce/';
header('Location: '. $url);
die;
case 'hide':
update_option('trustindex-wc-notification', 'hide', false);
break;
}
echo "<script type='text/javascript'>self.close();</script>";
die;
}
if(isset($_GET['test_proxy']))
{
delete_option($trustindex_pm_facebook->get_option_name('proxy-check'));
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) .'&tab=' . sanitize_text_field($_GET['tab']));
exit;
}
if(isset($_GET['review_download_notification']))
{
delete_option($trustindex_pm_facebook->get_option_name('review-download-notification'));
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) .'&tab=setup_no_reg');
exit;
}
$tabs = [];
if($trustindex_pm_facebook->is_trustindex_connected())
{
$default_tab = 'setup_trustindex_join';
$tabs[ 'Trustindex admin' ] = "setup_trustindex_join";
$tabs[ TrustindexPlugin_facebook::___("Free Widget Configurator") ] = "setup_no_reg";
}
else
{
$default_tab = 'setup_no_reg';
$tabs[ TrustindexPlugin_facebook::___("Free Widget Configurator") ] = "setup_no_reg";
}
if($trustindex_pm_facebook->is_noreg_linked())
{
$tabs[ TrustindexPlugin_facebook::___("My Reviews") ] = "my_reviews";
}
$tabs[ TrustindexPlugin_facebook::___('Get Reviews') ] = "get_reviews";
$tabs[ TrustindexPlugin_facebook::___('Rate Us') ] = "rate";
if(!$trustindex_pm_facebook->is_trustindex_connected())
{
$tabs[ TrustindexPlugin_facebook::___('Get more Features') ] = "setup_trustindex";
$tabs[ TrustindexPlugin_facebook::___('Log In') ] = "setup_trustindex_join";
}
$tabs[ TrustindexPlugin_facebook::___('Troubleshooting') ] = "troubleshooting";
$selected_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : null;
$subtabs = null;
$found = false;
foreach($tabs as $tab)
{
if(is_array($tab))
{
if(array_search($selected_tab, $tab) !== FALSE)
{
$found = true;
break;
}
}
else
{
if($selected_tab == $tab)
{
$found = true;
break;
}
}
}
if(!$found)
{
$selected_tab = $default_tab;
}
$http_blocked = false;
if(defined('WP_HTTP_BLOCK_EXTERNAL') && WP_HTTP_BLOCK_EXTERNAL)
{
if(!defined('WP_ACCESSIBLE_HOSTS') || strpos(WP_ACCESSIBLE_HOSTS, '*.trustindex.io') === FALSE)
{
$http_blocked = true;
}
}
$proxy = new WP_HTTP_Proxy();
$proxy_check = true;
if($proxy->is_enabled())
{
$opt_name = $trustindex_pm_facebook->get_option_name('proxy-check');
$db_data = get_option($opt_name, "");
if(!$db_data)
{
$response = wp_remote_post("https://admin.trustindex.io/" . "api/userCheckLoggedIn", [
'timeout' => '30',
'redirection' => '5',
'blocking' => true
]);
if(is_wp_error($response))
{
$proxy_check = $response->get_error_message();
update_option($opt_name, $response->get_error_message(), false);
}
else
{
update_option($opt_name, 1, false);
}
}
else
{
if($db_data !== '1')
{
$proxy_check = $db_data;
}
}
}
?>
<div id="ti-assets-error" class="notice notice-warning" style="display: none; margin-left: 0; margin-right: 0; padding-bottom: 9px">
<p>
<?php echo TrustindexPlugin_facebook::___('For some reason, the <strong>CSS</strong> file required to run the plugin was not loaded.<br />One of your plugins is probably causing the problem.'); ?>
</p>
</div>
<script type="text/javascript">
window.onload = function() {
let not_loaded = [];
let loaded_count = 0;
let js_files = [
{
url: '<?php echo $trustindex_pm_facebook->get_plugin_file_url('static/js/admin-page-settings-connect.js'); ?>',
id: 'connect'
},
{
url: '<?php echo $trustindex_pm_facebook->get_plugin_file_url('static/js/admin-page-settings-common.js'); ?>',
id: 'common'
},
<?php if(in_array($trustindex_pm_facebook->shortname, [ 'google', 'facebook' ])): ?>
{
url: '<?php echo $trustindex_pm_facebook->get_plugin_file_url('static/js/admin-page-settings.js'); ?>',
id: 'unique'
}
<?php endif; ?>
];
let addElement = function(type, url, callback) {
let element = document.createElement(type);
if(type == 'script')
{
element.type = 'text/javascript';
element.src = url;
}
else
{
element.type = 'text/css';
element.rel = 'stylesheet';
element.href = url;
element.id = 'trustindex_settings_style_facebook-css';
}
document.head.appendChild(element);
element.addEventListener('load', function() { callback(true); });
element.addEventListener('error', function() { callback(false); });
};
let isCSSExists = function() {
let link = document.getElementById('trustindex_settings_style_facebook-css');
return link && Boolean(link.sheet);
};
let isJSExists = function(id) {
return typeof Trustindex_JS_loaded != 'undefined' && typeof Trustindex_JS_loaded[ id ] != 'undefined';
};
let process = function() {
if(loaded_count < js_files.length + 1)
{
return false;
}
if(not_loaded.length)
{
document.getElementById('trustindex-plugin-settings-page').remove();
let warning_box = document.getElementById('ti-assets-error');
if(warning_box)
{
warning_box.style.display = 'block';
warning_box.querySelector('p strong').innerHTML = not_loaded.join(', ');
}
}
}
if(!isCSSExists())
{
addElement('link', '<?php echo $trustindex_pm_facebook->get_plugin_file_url('static/css/admin-page-settings.css'); ?>', function(success) {
loaded_count++;
if(!success)
{
not_loaded.push('CSS');
}
process();
});
}
else
{
loaded_count++;
}
js_files.forEach(function(js) {
if(!isJSExists(js.id))
{
addElement('script', js.url, function(success) {
loaded_count++;
if(!success)
{
if(not_loaded.indexOf('JS') == -1)
{
not_loaded.push('JS');
}
}
process();
});
}
else
{
loaded_count++;
}
});
};
</script>
<div id="trustindex-plugin-settings-page" class="ti-toggle-opacity">
<h1 class="ti-free-title">
<?php echo TrustindexPlugin_facebook::___("Widgets for Social Reviews & Recommendations"); ?>
<a href="https://www.trustindex.io/ti-redirect.php?a=sys&c=wp-facebook-l" target="_blank" title="Trustindex" class="ti-pull-right">
<img src="<?php echo $trustindex_pm_facebook->get_plugin_file_url('static/img/trustindex.svg'); ?>" />
</a>
</h1>
<div class="container_wrapper">
<div class="container_cell" id="container-main">
<?php if($http_blocked): ?>
<div class="ti-box ti-notice-error">
<p>
<?php echo TrustindexPlugin_facebook::___("Your site cannot download our widget templates, because of your server settings not allowing that:"); ?><br /><a href="https://wordpress.org/support/article/editing-wp-config-php/#block-external-url-requests" target="_blank">https://wordpress.org/support/article/editing-wp-config-php/#block-external-url-requests</a><br /><br />
<strong><?php echo TrustindexPlugin_facebook::___("Solution"); ?></strong><br />
<?php echo TrustindexPlugin_facebook::___("a) You should define <strong>WP_HTTP_BLOCK_EXTERNAL</strong> as false"); ?><br />
<?php echo TrustindexPlugin_facebook::___("b) or you should add Trustindex as an <strong>WP_ACCESSIBLE_HOSTS</strong>: \"*.trustindex.io\""); ?><br />
</p>
</div>
<?php endif; ?>
<?php if($proxy_check !== TRUE): ?>
<div class="ti-box ti-notice-error">
<p>
<?php echo TrustindexPlugin_facebook::___("It seems you are using a proxy for HTTP requests but after a test request it returned a following error:"); ?><br />
<strong><?php echo $proxy_check; ?></strong><br /><br />
<?php echo TrustindexPlugin_facebook::___("Therefore, our plugin might not work properly. Please, contact your hosting support, they can resolve this easily."); ?>
</p>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=<?php echo esc_attr($_GET['tab']); ?>&test_proxy" class="btn-text btn-refresh" data-loading-text="<?php echo TrustindexPlugin_facebook::___("Loading") ;?>"><?php echo TrustindexPlugin_facebook::___("Test again") ;?></a>
</div>
<?php endif; ?>
<div class="nav-tab-wrapper">
<?php foreach($tabs as $tab_name => $tab): ?>
<?php
$is_active = $selected_tab == $tab;
$action = $tab;
if(is_array($tab))
{
$is_active = array_search($selected_tab, $tab) !== FALSE;
$action = array_shift(array_values($tab));
if($is_active)
{
$subtabs = $tab;
}
}
?>
<a
id="link-tab-<?php echo esc_attr($action); ?>"
class="nav-tab<?php if($is_active): ?> nav-tab-active<?php endif; ?><?php if($tab == 'troubleshooting'): ?> nav-tab-right<?php endif; ?>"
href="<?php echo admin_url('admin.php?page='.$trustindex_pm_facebook->get_plugin_slug().'/settings.php&tab='. esc_attr($action)); ?>"
><?php echo esc_html($tab_name); ?></a>
<?php endforeach; ?>
</div>
<?php if($subtabs): ?>
<div class="nav-tab-wrapper sub-nav">
<?php foreach($subtabs as $tab_name => $tab): ?>
<a
id="link-tab-<?php echo esc_attr($tab); ?>"
class="nav-tab<?php if($selected_tab == $tab): ?> nav-tab-active<?php endif; ?>"
href="<?php echo admin_url('admin.php?page='.$trustindex_pm_facebook->get_plugin_slug().'/settings.php&tab='. esc_attr($tab)); ?>"
><?php echo esc_html($tab_name); ?></a>
<?php endforeach; ?>
</div>
<?php endif; ?>
<div id="tab-<?php echo esc_attr($selected_tab); ?>">
<?php include(plugin_dir_path(__FILE__ ) . 'tabs' . DIRECTORY_SEPARATOR . $selected_tab . '.php'); ?>
</div>
</div>

</div>
</div>
<div id="ti-loading">
<div class="ti-loading-effect"><div></div><div></div><div></div></div>
</div>