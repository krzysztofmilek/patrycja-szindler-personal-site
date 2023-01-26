<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$ti_success = "";
if(isset($_COOKIE['ti-success']))
{
$ti_success = sanitize_text_field($_COOKIE['ti-success']);
setcookie('ti-success', '', time() - 60, "/");
}
$ti_error = null;
$ti_command = isset($_POST['command']) ? sanitize_text_field($_POST['command']) : null;
if (!in_array($ti_command, array("connect", "disconnect"))) { $ti_command = null; }
if ($ti_command == "connect")
{
check_admin_referer( 'connect-reg_'.$trustindex_pm_facebook->get_plugin_slug());
$sanitized_email = sanitize_email($_POST['email']);
$sanitized_password = stripslashes(sanitize_text_field(htmlentities($_POST['password'], ENT_QUOTES)));
if (
$sanitized_email
&& $sanitized_password
)
{
$server_output = $trustindex_pm_facebook->connect_trustindex_api(
array(
"signin" => array(
"username" => $sanitized_email,
"password" => html_entity_decode($sanitized_password),
),
"callback" => bin2hex(openssl_random_pseudo_bytes(10))
),
"connect"
);
if ($server_output['success'])
{
setcookie('ti-success', 'connected', time() + 60, "/");
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=' . sanitize_text_field($_GET['tab']));
exit;
}
else
{
$ti_error = TrustindexPlugin_facebook::___('Wrong e-mail or password!');
}
}
else
{
$ti_error = TrustindexPlugin_facebook::___('You must provide a password and a valid e-mail!');
}
}
elseif ($ti_command == "disconnect")
{
check_admin_referer( 'disconnect-reg_'.$trustindex_pm_facebook->get_plugin_slug());
delete_option($trustindex_pm_facebook->get_option_name("subscription-id"));
setcookie('ti-success', 'disconnected', time() + 60, "/");
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=' . sanitize_text_field($_GET['tab']));
exit;
}
$trustindex_subscription_id = $trustindex_pm_facebook->is_trustindex_connected();
$widget_number = $trustindex_pm_facebook->get_trustindex_widget_number();
?>
<?php if ($ti_success == "connected"): ?>
<?php echo TrustindexPlugin_facebook::get_noticebox("success", TrustindexPlugin_facebook::___('Trustindex account successfully connected!')); ?>
<?php elseif ($ti_success == "disconnected"): ?>
<?php echo TrustindexPlugin_facebook::get_noticebox("success", TrustindexPlugin_facebook::___('Trustindex account successfully disconnected!')); ?>
<?php endif; ?>
<?php if ($ti_error): ?>
<?php echo TrustindexPlugin_facebook::get_noticebox("error", $ti_error); ?>
<?php endif; ?>
<div class="ti-box">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___('Connect your Trustindex account'); ?></div>
<p><strong><?php echo TrustindexPlugin_facebook::___('You can connect your %s with your Trustindex account, and can display your widgets easier.', [ 'Widgets for Social Reviews & Recommendations' ]); ?></strong></p>
<?php if ($trustindex_subscription_id): ?>
<?php
$ti_widgets = $trustindex_pm_facebook->get_trustindex_widgets();
$ti_package = is_array($ti_widgets) && $ti_widgets && isset($ti_widgets[0]['package']) ? $ti_widgets[0]['package'] : null;
?>
<p>
<?php echo TrustindexPlugin_facebook::___("Your %s is connected.", [ TrustindexPlugin_facebook::___('Trustindex account') ]); ?><br />
- <?php echo TrustindexPlugin_facebook::___('Your subscription ID:'); ?> <strong><?php echo esc_html($trustindex_subscription_id); ?></strong><br />
<?php if ($ti_package): ?>
- <?php echo TrustindexPlugin_facebook::___('Your package:'); ?> <strong><?php echo esc_html(TrustindexPlugin_facebook::___($ti_package)); ?></strong>
<?php endif; ?>
</p>
<?php if ($ti_package == "free"): ?>
<?php echo TrustindexPlugin_facebook::get_noticebox("error", TrustindexPlugin_facebook::___('Once the trial period has expired, the widgets will not appear. You can subscribe or switch back the the "%s" tab', [ TrustindexPlugin_facebook::___('Free Widget Configurator') ])); ?>
<?php elseif ($ti_package == "trial"): ?>
<?php echo TrustindexPlugin_facebook::get_noticebox("warning", TrustindexPlugin_facebook::___('Once the trial period has expired, the widgets will not appear. You can subscribe or switch back the the "%s" tab', [ TrustindexPlugin_facebook::___('Free Widget Configurator') ])); ?>
<?php endif; ?>
<form method="post" action="">
<input type="hidden" name="command" value="disconnect" />
<?php wp_nonce_field( 'disconnect-reg_'.$trustindex_pm_facebook->get_plugin_slug() ); ?>
<div class="text-center">
<button class="btn btn-text" type="submit" style="margin-top: 20px; margin-bottom: 0"><?php echo TrustindexPlugin_facebook::___("Disconnect"); ?></button>
</div>
</form>
<?php else: ?>
<div class="ti-row">
<form id="form-connect" class="box-content ti-col-6" method="post" action="">
<input type="hidden" name="command" value="connect" />
<?php wp_nonce_field( 'connect-reg_'.$trustindex_pm_facebook->get_plugin_slug() ); ?>
<div class="form-group">
<label for="ti-reg-email2">E-mail</label>
<input type="email"
placeholder="E-mail"
name="email"
class="form-control"
required="required"
id="ti-reg-email2"
value="<?php echo esc_attr($current_user->user_email); ?>"
/>
</div>
<div class="form-group">
<label for="ti-reg-password2"><?php echo TrustindexPlugin_facebook::___('Password'); ?></label>
<input type="password"
placeholder="<?php echo TrustindexPlugin_facebook::___('Password'); ?>"
name="password"
class="form-control"
required="required"
id="ti-reg-password2"
/>
<span class="dashicons dashicons-visibility ti-toggle-password"></span>
</div>
<button type="submit" class="btn btn-primary" data-loading-text="<?php echo TrustindexPlugin_facebook::___("Loading") ;?>"><?php echo TrustindexPlugin_facebook::___('CONNECT ACCOUNT');?></button>
<br />
<p class="text-center">
<a class="btn-text" href="<?php echo 'https://admin.trustindex.io/'; ?>forgot-password" target="_blank"><?php echo TrustindexPlugin_facebook::___('Have you forgotten your password?'); ?></a>
<a class="btn-text" href="https://www.trustindex.io/ti-redirect.php?a=sys&c=wp-facebook-4" target="_blank"><?php echo TrustindexPlugin_facebook::___('Create a new Trustindex account');?></a>
</p>
</form>
<div class="ti-col-6"></div>
</div>
<?php endif; ?>
</div>
<?php if($trustindex_subscription_id): ?>
<div class="ti-box disabled">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___("Manage your Trustindex account"); ?></div>
<a class="btn-text" href="<?php echo 'https://admin.trustindex.io/'; ?>widget" target="_blank" <?php if ($ti_success == "connected"): ?>data-autoclick="true"<?php endif; ?>><?php echo TrustindexPlugin_facebook::___("Go to Trustindex's admin!"); ?></a>
<?php if ($ti_success == "connected"): ?>
<?php echo TrustindexPlugin_facebook::get_noticebox("success", TrustindexPlugin_facebook::___('We will redirect you to the admin panel automatically in some seconds...')); ?>
<?php endif; ?>
</div>
<div class="ti-box">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___("Insert your widget into your wordpress site using shortcode"); ?></div>
<?php if($trustindex_subscription_id): ?>
<?php if($widget_number): ?>
<p>
<?php echo TrustindexPlugin_facebook::___('You have got %d widgets saved in Trustindex admin.', array($widget_number)); ?>
</p>
<?php foreach ($ti_widgets as $wc_i => $wc): ?>
<p><strong><?php echo esc_html($wc['name']); ?>:</strong></p>
<?php if ($wc['widgets']): ?>
<ul>
<?php foreach ($wc['widgets'] as $wi_num => $w): ?>
<li>
<?php echo esc_html($wi_num+1); ?>.
<a href=".ti-w-<?php echo esc_attr($wc_i .'-'. $wi_num); ?>" class="btn-toggle" data-ti-id="<?php echo esc_attr($w['id']); ?>">
<?php echo esc_html($w['name']); ?>
</a>
<div style="display: none;" class="ti-w-<?php echo esc_attr($wc_i .'-'. $wi_num); ?>">
<code class="code-ti-w-<?php echo esc_attr($wc_i .'-'. $wi_num); ?>">[<?php echo $trustindex_pm_facebook->get_shortcode_name(); ?> data-widget-id="<?php echo esc_attr($w['id']); ?>"]</code>
<a href=".code-ti-w-<?php echo esc_attr($wc_i .'-'. $wi_num); ?>" class="btn-text btn-copy2clipboard"><?php echo TrustindexPlugin_facebook::___("Copy to clipboard") ;?></a>
<br />
<br />
</div>
</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
-
<?php endif; ?>
<?php endforeach; ?>
<?php else: ?>
<div style="margin: 0 -15px">
<?php echo TrustindexPlugin_facebook::get_noticebox("warning", "You have no widgets saved!"); ?>
</div>
<?php endif; ?>
<p>
<a class="btn-text" href="<?php echo 'https://admin.trustindex.io/'; ?>widget" target="_blank"><?php echo TrustindexPlugin_facebook::___("Create more!"); ?></a>
</p>
<?php endif; ?>
</div>
<?php endif; ?>