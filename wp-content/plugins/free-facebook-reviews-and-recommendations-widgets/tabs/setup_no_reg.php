<?php include( plugin_dir_path(__FILE__ ) . "setup_no_reg_header.php" ); ?>
<ul class="ti-free-steps">
<li class="<?php echo !$trustindex_pm_facebook->is_noreg_linked() ? "active" : "done"; ?><?php if($current_step == 1): ?> current<?php endif; ?>" href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=1">
<span>1</span>
<?php echo TrustindexPlugin_facebook::___('Connect %s platform', [ 'Facebook' ]); ?>
</li>
<span class="ti-free-arrow"></span>
<li class="<?php echo $style_id ? "done" : ($trustindex_pm_facebook->is_noreg_linked() ? "active" : ""); ?><?php if($current_step == 2): ?> current<?php endif; ?>" href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=2">
<span>2</span>
<?php echo TrustindexPlugin_facebook::___('Select Layout'); ?>
</li>
<span class="ti-free-arrow"></span>
<li class="<?php echo $scss_set ? "done" : ($style_id ? "active" : ""); ?><?php if($current_step == 3): ?> current<?php endif; ?>" href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=3">
<span>3</span>
<?php echo TrustindexPlugin_facebook::___('Select Style'); ?>
</li>
<span class="ti-free-arrow"></span>
<li class="<?php echo $widget_setted_up ? "done" : ($scss_set ? "active" : ""); ?><?php if($current_step == 4): ?> current<?php endif; ?>" href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=4">
<span>4</span>
<?php echo TrustindexPlugin_facebook::___('Set up widget'); ?>
</li>
<span class="ti-free-arrow"></span>
<li class="<?php echo $widget_setted_up ? "active" : ""; ?><?php if($current_step == 5): ?> current<?php endif; ?>" href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=5">
<span>5</span>
<?php echo TrustindexPlugin_facebook::___('Insert code'); ?>
</li>
</ul>
<?php if($trustindex_pm_facebook->is_trustindex_connected() && in_array($selected_tab, [ 'setup_no_reg', 'my_reviews' ])): ?>
<div class="ti-notice notice-warning" style="margin: 0 0 15px 0">
<p>
<?php echo TrustindexPlugin_facebook::___("You have connected your Trustindex account, so you can find premium functionality under the \"%s\" tab. You no longer need this tab unless you choose the limited but forever free mode.", ["Trustindex admin"]); ?>
</p>
</div>
<?php endif; ?>
<?php if($is_review_download_in_progress === 'error'): ?>
<div class="ti-notice notice-error" style="margin: 0 0 15px 0">
<p>
<?php echo TrustindexPlugin_facebook::___('While downloading the reviews, we noticed that your connected page is not found.<br />If it really exists, please contact us to resolve the issue or try connect it again.'); ?><br />
</p>
</div>
<?php elseif($is_review_download_in_progress && ($trustindex_pm_facebook->is_review_manual_download() || !in_array('facebook', [ 'facebook', 'google' ]))): ?>
<div class="ti-notice notice-warning" style="margin: 0 0 15px 0">
<p>
<?php echo TrustindexPlugin_facebook::___('Your reviews are downloading in the background.'); ?>
<?php if(!in_array('facebook', [ 'facebook', 'google' ])): ?>
<?php echo TrustindexPlugin_facebook::___('This can take up to a few hours depending on the load and platform.'); ?>
<?php endif; ?>
<?php if(!count($reviews)): ?>
<br />
<?php echo TrustindexPlugin_facebook::___('In the meantime, you can setup your widget with a few example reviews.'); ?>
<?php endif; ?>
<?php if($trustindex_pm_facebook->is_review_manual_download()): ?>
<br />
<a href="#" id="review-manual-download" class="button button-primary ti-tooltip" style="margin-top: 10px" data-loading-text="<?php echo TrustindexPlugin_facebook::___("Loading") ;?>">
<?php echo TrustindexPlugin_facebook::___("Manual download") ;?>
<span class="ti-tooltip-message">
<?php echo TrustindexPlugin_facebook::___('Your reviews are downloading in the background.'); ?>
<?php if(!in_array('facebook', [ 'facebook', 'google' ])): ?>
<?php echo TrustindexPlugin_facebook::___('This can take up to a few hours depending on the load and platform.'); ?>
<?php endif; ?>
</span>
</a>
<?php endif; ?>
</p>
</div>
<?php endif; ?>
<?php if(TrustindexPlugin_facebook::is_amp_active() && !get_option($trustindex_pm_facebook->get_option_name('amp-hidden-notification'), 0)): ?>
<div class="ti-notice notice-warning is-dismissible" style="margin: 0 0 15px 0">
<p>
<?php echo TrustindexPlugin_facebook::___("Free plugin features are unavailable with AMP plugin."); ?>
<?php if($trustindex_pm_facebook->is_trustindex_connected()): ?>
 <a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_trustindex_join">Trustindex admin</a>
<?php else: ?>
 <a href="https://www.trustindex.io/ti-redirect.php?a=sys&c=wp-amp" target="_blank"><?php echo TrustindexPlugin_facebook::___("Try premium features (like AMP) for free"); ?></a>
<?php endif; ?>
</p>
<button type="button" class="notice-dismiss" data-command="save-amp-notice-hide"></button>
</div>
<?php endif; ?>
<?php if($current_step == 1 || !$trustindex_pm_facebook->is_noreg_linked()): ?>
<h1 class="ti-free-title">
1. <?php echo TrustindexPlugin_facebook::___('Connect %s platform', [ 'Facebook' ]); ?>
</h1>
<?php if($trustindex_pm_facebook->is_noreg_linked()): ?>
<?php $page_details = get_option($trustindex_pm_facebook->get_option_name('page-details')); ?>
<div class="ti-source-box">
<?php if(isset($page_details['avatar_url'])): ?>
<img src="<?php echo esc_url($page_details['avatar_url']); ?>" />
<?php endif; ?>
<div class="ti-source-info">
<?php if(isset($page_details['name'])): ?>
<strong><?php echo esc_html($page_details['name']); ?></strong><br />
<?php endif; ?>
<?php if(isset($page_details['address']) && $page_details['address']): ?>
<?php echo esc_html($page_details['address']); ?><br />
<?php endif; ?>
<a href="<?php echo esc_url($trustindex_pm_facebook->getPageUrl()); ?>" target="_blank"><?php echo esc_url($trustindex_pm_facebook->getPageUrl()); ?></a>
</div>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&command=delete-page"><button class="btn btn-text"><?php echo TrustindexPlugin_facebook::___("Disconnect") ;?></button></a>
<div class="clear"></div>
</div>
<?php else: ?>
<div class="ti-box">
<form method="post" action="" data-platform="facebook" id="submit-form">
<input type="hidden" name="command" value="save-page" />
<?php wp_nonce_field( 'save-noreg_'.$trustindex_pm_facebook->get_plugin_slug(), '_wpnonce_save' ); ?>
<input type="hidden"
name="page_details"
class="form-control"
required="required"
id="ti-noreg-page_details"
value=""
/>
<?php
$review_download_token = get_option($trustindex_pm_facebook->get_option_name('review-download-token'));
if(!$review_download_token)
{
$review_download_token = wp_create_nonce('ti-noreg-connect-token');
update_option($trustindex_pm_facebook->get_option_name('review-download-token'), $review_download_token, false);
}
?>
<input type="hidden" id="ti-noreg-connect-token" name="ti-noreg-connect-token" value="<?php echo $review_download_token; ?>" />
<input type="hidden" id="ti-noreg-webhook-url" value="<?php echo $trustindex_pm_facebook->get_webhook_url(); ?>" />
<input type="hidden" id="ti-noreg-email" value="<?php echo get_option('admin_email'); ?>" />
<input type="hidden" id="ti-noreg-version" value="9.7.1" />
<input type="hidden" id="ti-noreg-review-download" name="review_download" value="0" />
<input type="hidden" id="ti-noreg-review-request-id" name="review_request_id" value="" />
<input type="hidden" id="ti-noreg-manual-download" name="manual_download" value=0 />
<input type="hidden" id="ti-noreg-page-id" value="" />
<div class="autocomplete">
<?php include( plugin_dir_path(__FILE__ ) . "setup_no_reg_platform.php" ); ?>
</div>
<div class="ti-selected-source">
<label class="ti-left-label"><?php echo TrustindexPlugin_facebook::___("Source"); ?>:</label>
<div class="ti-source-box ti-original-source-box">
<img />
<div class="ti-source-info"></div>
<button class="btn btn-text btn-connect" data-loading-text="<?php echo TrustindexPlugin_facebook::___("Loading") ;?>"><?php echo TrustindexPlugin_facebook::___("Connect") ;?></button>
</div>
<div class="clear"></div>
</div>
<div class="ti-notice notice-warning" style="margin: 20px 0; margin-bottom: 0; display: none" id="ti-connect-info">
<p><?php echo TrustindexPlugin_facebook::___("A popup window should be appear! Please, go to there and continue the steps! (If there is no popup window, you can check the the browser's popup blocker)"); ?></p>
</div>
</form>
</div>
<?php endif; ?>
<h1 class="ti-free-subtitle"><?php echo TrustindexPlugin_facebook::___('Check some %s Widget layouts and styles', [ 'Facebook reviews and recommendations' ]); ?></h1>
<?php include( plugin_dir_path(__FILE__ ) . "demo_widgets.php" ); ?>
<?php elseif($current_step == 2 || !$style_id): ?>
<h1 class="ti-free-title">
2. <?php echo TrustindexPlugin_facebook::___('Select Layout'); ?>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=1" class="ti-back-icon"><?php echo TrustindexPlugin_facebook::___('Back'); ?></a>
</h1>
<?php if(!count($reviews) && !$is_review_download_in_progress): ?>
<div class="ti-notice notice-warning" style="margin: 0 0 15px 0">
<p>
<?php echo TrustindexPlugin_facebook::___('There are no reviews on your %s platform.', [ 'Facebook' ]); ?>
</p>
</div>
<?php endif; ?>
<div class="ti-filter-row">
<label><?php echo TrustindexPlugin_facebook::___('Layout'); ?>:</label>
<span class="ti-checkbox">
<input type="radio" name="layout-select" value="" data-ids="" checked>
<label><?php echo TrustindexPlugin_facebook::___('All'); ?></label>
</span>
<?php foreach(TrustindexPlugin_facebook::$widget_templates['categories'] as $category => $ids): ?>
<span class="ti-checkbox">
<input type="radio" name="layout-select" value="<?php echo esc_attr($category); ?>" data-ids="<?php echo esc_attr($ids); ?>">
<label><?php echo esc_html(TrustindexPlugin_facebook::___(ucfirst($category))); ?></label>
</span>
<?php endforeach; ?>
</div>
<div class="ti-preview-boxes-container">
<?php foreach(TrustindexPlugin_facebook::$widget_templates['templates'] as $id => $template): ?>
<?php
$class_name = 'ti-full-width';
if($id != 54 && in_array($template['type'], [ 'badge', 'button', 'floating', 'popup', 'sidebar' ]))
{
$class_name = 'ti-half-width';
}
$set = 'light-background';
if(in_array($template['type'], [ 'badge', 'button' ]))
{
$set = 'drop-shadow';
}
?>
<div class="<?php echo esc_attr($class_name); ?>">
<div class="ti-box ti-preview-boxes" data-layout-id="<?php echo esc_attr($id); ?>" data-set-id="<?php echo $set; ?>">
<div class="ti-header">
<span class="ti-header-layout-text">
<?php echo TrustindexPlugin_facebook::___('Layout'); ?>:
<strong><?php echo esc_html(TrustindexPlugin_facebook::___($template['name'])); ?></strong>
</span>
<a href="?page=<?php echo $_GET['page']; ?>&tab=setup_no_reg&command=save-style&style_id=<?php echo esc_attr(urlencode($id)); ?>" class="btn-text btn-refresh ti-pull-right" data-loading-text="<?php echo TrustindexPlugin_facebook::___("Loading") ;?>"><?php echo TrustindexPlugin_facebook::___("Select") ;?></a>
<div class="clear"></div>
</div>
<div class="preview">
<?php echo str_replace('ti-widget ti-disabled', 'ti-widget', $trustindex_pm_facebook->get_noreg_list_reviews(null, true, $id, $set, true, true)); ?>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
<?php elseif($current_step == 3 || !$scss_set): ?>
<h1 class="ti-free-title">
3. <?php echo TrustindexPlugin_facebook::___('Select Style'); ?>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=2" class="ti-back-icon"><?php echo TrustindexPlugin_facebook::___('Back'); ?></a>
</h1>
<?php if(!count($reviews) && !$is_review_download_in_progress): ?>
<div class="ti-notice notice-warning" style="margin: 0 0 15px 0">
<p>
<?php echo TrustindexPlugin_facebook::___('There are no reviews on your %s platform.', [ 'Facebook' ]); ?>
</p>
</div>
<?php endif; ?>
<?php
$class_name = 'ti-full-width';
if(in_array(TrustindexPlugin_facebook::$widget_templates['templates'][$style_id]['type'], [ 'badge', 'button', 'floating', 'popup', 'sidebar' ]))
{
$class_name = 'ti-half-width';
}
?>
<div class="ti-preview-boxes-container">
<?php foreach(TrustindexPlugin_facebook::$widget_styles as $id => $style): ?>
<div class="<?php echo esc_attr($class_name); ?>">
<div class="ti-box ti-preview-boxes" data-layout-id="<?php echo esc_attr($style_id); ?>" data-set-id="<?php echo esc_attr($id); ?>">
<div class="ti-header">
<span class="ti-header-layout-text">
<?php echo TrustindexPlugin_facebook::___('Style'); ?>:
<strong><?php echo TrustindexPlugin_facebook::___($style['name']); ?></strong>
</span>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&command=save-set&set_id=<?php echo esc_attr(urlencode($id)); ?>" class="btn-text btn-refresh ti-pull-right" data-loading-text="<?php echo TrustindexPlugin_facebook::___("Loading") ;?>"><?php echo TrustindexPlugin_facebook::___("Select") ;?></a>
<div class="clear"></div>
</div>
<div class="preview">
<?php echo $trustindex_pm_facebook->get_noreg_list_reviews(null, true, $style_id, $id, true, true); ?>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
<?php elseif($current_step == 4 || !$widget_setted_up): ?>
<?php
$widget_type = TrustindexPlugin_facebook::$widget_templates[ 'templates' ][ $style_id ]['type'];
$widget_has_reviews = !in_array($widget_type, [ 'button', 'badge' ]) || in_array($style_id, [ 23, 30, 32 ]);
?>
<h1 class="ti-free-title">
4. <?php echo TrustindexPlugin_facebook::___('Set up widget'); ?>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=3" class="ti-back-icon"><?php echo TrustindexPlugin_facebook::___('Back'); ?></a>
</h1>
<?php if(!count($reviews) && !$is_review_download_in_progress): ?>
<div class="ti-notice notice-warning" style="margin: 0 0 15px 0">
<p>
<?php echo TrustindexPlugin_facebook::___('There are no reviews on your %s platform.', [ 'Facebook' ]); ?>
</p>
</div>
<?php endif; ?>
<div class="ti-box ti-preview-boxes" data-layout-id="<?php echo esc_attr($style_id); ?>" data-set-id="<?php echo esc_attr($scss_set); ?>">
<div class="ti-header">
<?php echo TrustindexPlugin_facebook::___('Widget Preview'); ?>
<?php if(!in_array($style_id, [ 17, 21, 52, 53 ])): ?>
<span class="ti-header-layout-text ti-pull-right">
<?php echo TrustindexPlugin_facebook::___('Style'); ?>:
<strong><?php echo esc_html(TrustindexPlugin_facebook::___(TrustindexPlugin_facebook::$widget_styles[$scss_set]['name'])); ?></strong>
</span>
<?php endif; ?>
<span class="ti-header-layout-text ti-pull-right">
<?php echo TrustindexPlugin_facebook::___('Layout'); ?>:
<strong><?php echo esc_html(TrustindexPlugin_facebook::___(TrustindexPlugin_facebook::$widget_templates['templates'][$style_id]['name'])); ?></strong>
</span>
</div>
<div class="preview">
<div id="ti-review-list"><?php echo $trustindex_pm_facebook->get_noreg_list_reviews(null, true, null, null, false, true); ?></div>
<div style="display: none; text-align: center">
<?php echo TrustindexPlugin_facebook::___("You do not have reviews with the current filters. <br />Change your filters if you would like to display reviews on your page!"); ?>
</div>
</div>
</div>
<div class="ti-box">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___('Widget Settings'); ?></div>
<div class="ti-left-block">
<?php if($widget_has_reviews): ?>
<div id="ti-filter" class="ti-input-row">
<label><?php echo TrustindexPlugin_facebook::___('Filter your ratings'); ?></label>
<div class="ti-select" id="show-star" data-platform="facebook">
<font></font>
<ul>
<li data-value="1,2,3,4,5" <?php echo count($filter['stars']) > 2 ? 'class="selected"' : ''; ?>><?php echo TrustindexPlugin_facebook::___('Show all'); ?></li>
<li data-value="4,5" <?php echo count($filter['stars']) == 2 ? 'class="selected"' : ''; ?>>

&starf;&starf;&starf;&starf; - &starf;&starf;&starf;&starf;&starf;
</li>
<li data-value="5" <?php echo count($filter['stars']) == 1 ? 'class="selected"' : ''; ?>>
<?php echo TrustindexPlugin_facebook::___('only'); ?> &starf;&starf;&starf;&starf;&starf;
</li>
</ul>
</div>
</div>
<?php endif; ?>
<div class="ti-input-row">
<label><?php echo TrustindexPlugin_facebook::___('Select language'); ?></label>
<form method="post" action="">
<input type="hidden" name="command" value="save-language" />
<?php wp_nonce_field( 'save-language_'.$trustindex_pm_facebook->get_plugin_slug(), '_wpnonce_language' ); ?>
<select class="form-control" name="lang" id="ti-lang-id">
<?php foreach(TrustindexPlugin_facebook::$widget_languages as $id => $name): ?>
<option value="<?php echo esc_attr($id); ?>" <?php echo $lang == $id ? 'selected' : ''; ?>><?php echo esc_html($name); ?></option>
<?php endforeach; ?>
</select>
</form>
</div>
<?php if($widget_has_reviews): ?>
<div class="ti-input-row">
<label><?php echo TrustindexPlugin_facebook::___('Select date format'); ?></label>
<form method="post" action="">
<input type="hidden" name="command" value="save-dateformat" />
<?php wp_nonce_field( 'save-dateformat_'.$trustindex_pm_facebook->get_plugin_slug(), '_wpnonce_dateformat' ); ?>
<select class="form-control" name="dateformat" id="ti-dateformat-id">
<?php foreach(TrustindexPlugin_facebook::$widget_dateformats as $format): ?>
<option value="<?php echo esc_attr($format); ?>" <?php echo $dateformat == $format ? 'selected' : ''; ?>><?php
switch($format)
{
case 'modern':
$lang = substr(get_locale(), 0, 2);
if(!in_array($lang, array_keys(TrustindexPlugin_facebook::$widget_date_format_locales)))
{
$lang = 'en';
}
$tmp = explode('|', TrustindexPlugin_facebook::$widget_date_format_locales[ $lang ]);
echo str_replace([ '%d', '%s' ], [ 2, $tmp[3] ], $tmp[0]);
break;
case 'hide':
echo TrustindexPlugin_facebook::___('Hide');
break;
default:
echo date($format);
break;
}
?></option>
<?php endforeach; ?>
</select>
</form>
</div>
<?php if(!in_array($style_id, [ 17, 21, 52, 53 ])): ?>
<div class="ti-input-row">
<label><?php echo TrustindexPlugin_facebook::___('Align'); ?></label>
<form method="post" action="">
<input type="hidden" name="command" value="save-align" />
<?php wp_nonce_field( 'save-align_'.$trustindex_pm_facebook->get_plugin_slug(), '_wpnonce_align' ); ?>
<select class="form-control" name="align" id="ti-align-id">
<?php foreach([ 'left', 'center', 'right', 'justify' ] as $align_type): ?>
<option value="<?php echo esc_attr($align_type); ?>" <?php echo $align_type == $align ? 'selected' : ''; ?>><?php echo TrustindexPlugin_facebook::___($align_type); ?></option>
<?php endforeach; ?>
</select>
</form>
</div>
<?php endif; ?>
<?php endif; ?>
</div>
<div class="ti-right-block">
<form method="post" action="" id="ti-widget-options">
<input type="hidden" name="command" value="save-options" />
<?php wp_nonce_field( 'save-options_'.$trustindex_pm_facebook->get_plugin_slug(), '_wpnonce_options' ); ?>
<?php if($widget_has_reviews): ?>
<span class="ti-checkbox row">
<input type="checkbox" id="ti-filter-only-ratings" class="no-form-update" name="only-ratings" value="1" <?php if($filter['only-ratings']): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Hide reviews without comments"); ?></label>
</span>
<?php endif; ?>
<?php if(!in_array($style_id, [ 11, 12, 17, 18, 20, 21, 22, 24, 25, 26, 27, 28, 29, 30, 35, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62 ]) && TrustindexPlugin_facebook::$widget_styles[$scss_set]['_vars']['dots'] !== 'true'): ?>
<span class="ti-checkbox row">
<input type="checkbox" name="no-rating-text" value="1" <?php if($no_rating_text): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Hide rating text"); ?></label>
</span>
<?php endif; ?>
<?php if($widget_has_reviews && in_array(ucfirst($trustindex_pm_facebook->shortname), TrustindexPlugin_facebook::$verified_platforms)): ?>
<span class="ti-checkbox row">
<input type="checkbox" name="verified-icon" value="1" <?php if($verified_icon): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Show verified review icon"); ?></label>
</span>
<?php endif; ?>
<?php if(in_array($widget_type, [ 'slider', 'sidebar' ]) && !in_array($style_id, [ 8, 9, 10, 18, 19, 37, 54 ])): ?>
<span class="ti-checkbox row">
<input type="checkbox" name="show-arrows" value="1" <?php if($show_arrows): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Show navigation arrows"); ?></label>
</span>
<?php endif; ?>
<?php if($widget_has_reviews && $style_id != 52): ?>
<span class="ti-checkbox row">
<input type="checkbox" name="show-reviewers-photo" value="1" <?php if($show_reviewers_photo): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Show reviewers' photo"); ?></label>
</span>
<span class="ti-checkbox row disabled">
<input type="checkbox" value="1" disabled>
<label class="ti-tooltip">
<?php echo TrustindexPlugin_facebook::___("Show reviewers' photos locally, from a single image (less requests)"); ?>
<span class="ti-tooltip-message"><?php echo TrustindexPlugin_facebook::___("Paid package feature"); ?></span>
</label>
</span>
<?php endif; ?>
<?php if(!in_array($widget_type, [ 'floating' ])): ?>
<span class="ti-checkbox row">
<input type="checkbox" name="enable-animation" value="1" <?php if($enable_animation): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Enable mouseover animation"); ?></label>
</span>
<?php endif; ?>
<span class="ti-checkbox row">
<input type="checkbox" name="disable-font" value="1" <?php if($disable_font): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Use site's font"); ?></label>
</span>
<?php if($widget_has_reviews): ?>
<span class="ti-checkbox row">
<input type="checkbox" name="show-logos" value="1" <?php if($show_logos): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Show platform logos"); ?></label>
</span>
<?php if(!$trustindex_pm_facebook->is_ten_scale_rating_platform()): ?>
<span class="ti-checkbox row">
<input type="checkbox" name="show-stars" value="1" <?php if($show_stars): ?>checked<?php endif;?>>
<label><?php echo TrustindexPlugin_facebook::___("Show platform stars"); ?></label>
</span>
<?php endif; ?>
<?php endif; ?>
</form>
</div>
<div class="clear"></div>
<div class="ti-footer">
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&setup_widget" class="btn-text btn-refresh ti-pull-right" data-loading-text="<?php echo TrustindexPlugin_facebook::___("Loading") ;?>"><?php echo TrustindexPlugin_facebook::___("Save and get code") ;?></a>
<div class="clear"></div>
</div>
</div>
<?php else: ?>
<h1 class="ti-free-title">
5. <?php echo TrustindexPlugin_facebook::___('Insert code'); ?>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&step=4" class="ti-back-icon"><?php echo TrustindexPlugin_facebook::___('Back'); ?></a>
</h1>
<?php if(!count($reviews) && !$is_review_download_in_progress): ?>
<div class="ti-notice notice-warning" style="margin: 0 0 15px 0">
<p>
<?php echo TrustindexPlugin_facebook::___('There are no reviews on your %s platform.', [ 'Facebook' ]); ?>
</p>
</div>
<?php endif; ?>
<div class="ti-box">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___('Insert this shortcode into your website'); ?></div>
<div class="ti-input-row" style="margin-bottom: 2px">
<label>Shortcode</label>
<code class="code-shortcode">[<?php echo $trustindex_pm_facebook->get_shortcode_name(); ?> no-registration=facebook]</code>
<a href=".code-shortcode" class="btn-text btn-copy2clipboard ti-tooltip toggle-tooltip ti-tooltip-left">
<?php echo TrustindexPlugin_facebook::___("Copy to clipboard") ;?>
<span class="ti-tooltip-message">
<span style="color: #00ff00; margin-right: 2px">✓</span>
<?php echo TrustindexPlugin_facebook::___("Copied"); ?>
</span>
</a>
</div>
<?php echo TrustindexPlugin_facebook::___('Copy and paste this shortcode into post, page or widget.'); ?>
</div>
<?php if(!$rate_us_feedback): ?>
<div class="ti-box ti-rate-us-box">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___("How's experience with Trustindex?"); ?></div>
<p><?php echo TrustindexPlugin_facebook::___('Rate us clicking on the stars'); ?></p>
<div class="ti-quick-rating">
<?php for($i = 5; $i >= 1; $i--): ?><div class="ti-star-check <?php if($i == 5): ?>active<?php endif; ?>" data-value="<?php echo $i; ?>"></div><?php endfor; ?>
</div>
</div>
<?php endif; ?>
<h1 class="ti-free-title"><?php echo TrustindexPlugin_facebook::___("Want to get more customers?"); ?></h1>
<div class="ti-box">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___('Increase SEO, trust and sales using customer reviews.'); ?></div>
<a class="btn-text" href="https://www.trustindex.io/ti-redirect.php?a=sys&c=wp-facebook-1" target="_blank"><?php echo TrustindexPlugin_facebook::___('Create a Free Account for More Features'); ?></a>
<ul class="ti-seo-list">
<li>
<strong><?php echo TrustindexPlugin_facebook::___("Display unlimited number of reviews"); ?></strong><br />
<?php echo TrustindexPlugin_facebook::___("You can test Trustindex with 10 reviews in the free version. Upgrade to Business to display ALL the reviews received. Be the undisputed customer choice in your industry!"); ?>
</li>
<li>
<strong><?php echo TrustindexPlugin_facebook::___("Create unlimited number of widgets"); ?></strong><br />
<?php echo TrustindexPlugin_facebook::___("Use the widgets matching your page the best to build trust."); ?>
</li>
<li>
<strong><?php echo TrustindexPlugin_facebook::___("%d review platforms", [ 58 ]); ?></strong><br />
<?php echo TrustindexPlugin_facebook::___("Add more reviews to your widget from %s, etc. to enjoy more trust, and to keep customers on your site.", [ 'Google, Facebook, Yelp, Amazon, Tripadvisor, Booking.com, Airbnb, Hotels.com, Capterra, Foursquare, Opentable' ]); ?><br />
<img src="<?php echo $trustindex_pm_facebook->get_plugin_file_url('static/img/platforms.png'); ?>" alt="" style="margin-top: 5px" />
</li>
<li>
<strong><?php echo TrustindexPlugin_facebook::___("Mix Reviews"); ?></strong><br />
<?php echo TrustindexPlugin_facebook::___("You can mix your reviews from different platforms and display them in 1 review widget."); ?>
</li>
<li>
<strong><?php echo TrustindexPlugin_facebook::___("Get more reviews"); ?></strong><br />
<?php echo TrustindexPlugin_facebook::___("Use our Review Invitation System to collect hundreds of new reviews. Become impossible to resist!"); ?>
</li>
<li>
<strong><?php echo TrustindexPlugin_facebook::___("Manage all reviews in one place"); ?></strong><br />
<?php echo TrustindexPlugin_facebook::___("Turn on email alert to ALL new reviews, so that you can manage them quickly."); ?>
</li>
<li>
<strong><?php echo TrustindexPlugin_facebook::___("Automatically update with NEW reviews"); ?></strong><br />
<?php echo TrustindexPlugin_facebook::___("Wordpress cannot update reviews, but Trustindex can! As soon as you get a new review, Trustindex Business can automatically add it to your website. Customers love fresh reviews!"); ?>
</li>
</ul>
<a class="btn-text" href="https://www.trustindex.io/ti-redirect.php?a=sys&c=wp-facebook-2" target="_blank"><?php echo TrustindexPlugin_facebook::___('Create a Free Account for More Features'); ?></a>
<div class="ti-notice notice-success ti-special-offer">
<img src="<?php echo $trustindex_pm_facebook->get_plugin_file_url('static/img/special_30.jpg'); ?>">
<p><?php echo TrustindexPlugin_facebook::___('Now we offer you a 30%% discount off your subscription! Create your free account and benefit from the onboarding discount now!'); ?></p>
<div class="clear"></div>
</div>
</div>
<?php if(!$rate_us_feedback): ?>
<div class="ti-modal ti-rateus-modal" id="ti-rateus-modal-feedback">
<div class="ti-modal-dialog">
<div class="ti-modal-content">
<span class="ti-close-icon btn-modal-close"></span>
<div class="ti-modal-body">
<div class="ti-rating-textbox">
<div class="ti-quick-rating">
<?php for($i = 5; $i >= 1; $i--): ?><div class="ti-star-check" data-value="<?php echo $i; ?>"></div><?php endfor; ?>
<div class="clear"></div>
</div>
</div>
<div class="ti-rateus-title"><?php echo TrustindexPlugin_facebook::___('Thanks for your feedback!<br />Let us know how we can improve.') ;?></div>
<input type="text" class="form-control" placeholder="<?php echo TrustindexPlugin_facebook::___('Contact e-mail') ;?>" value="<?php echo $current_user->user_email; ?>" />
<textarea class="form-control" placeholder="<?php echo TrustindexPlugin_facebook::___('Describe your experience') ;?>"></textarea>
</div>
<div class="ti-modal-footer">
<a href="#" class="btn-text btn-modal-close"><?php echo TrustindexPlugin_facebook::___('Cancel') ;?></a>
<a href="#" class="btn-text btn-rateus-support" data-loading-text="<?php echo TrustindexPlugin_facebook::___('Loading') ;?>"><?php echo TrustindexPlugin_facebook::___('Contact our support') ;?></a>
</div>
</div>
</div>
</div>
<?php endif; ?>
<?php endif; ?>