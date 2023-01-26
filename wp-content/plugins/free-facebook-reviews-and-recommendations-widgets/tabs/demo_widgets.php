<div class="ti-preview-boxes-container">
<div class="ti-full-width">
<div class="ti-box ti-preview-boxes">
<div class="ti-header">
<span class="ti-header-layout-text">
<?php echo TrustindexPlugin_facebook::___('Example Widget'); ?>:
<strong><?php echo esc_html(TrustindexPlugin_facebook::___(TrustindexPlugin_facebook::$widget_templates['templates'][4]['name'])); ?></strong>
 (<?php echo esc_html(TrustindexPlugin_facebook::___(TrustindexPlugin_facebook::$widget_styles['light-background']['name'])); ?>)
</span>
</div>
<div class="preview"><?php echo $trustindex_pm_facebook->get_trustindex_widget('a1e754a36568236614dccc191'); ?></div>
</div>
</div>
<?php
$demo_list = [
36 => 'drop-shadow',
15 => 'light-background-large',
39 => 'ligth-border-3d-large',
5 => 'light-minimal',
34 => 'ligth-border',
13 => 'dark-background',
19 => 'light-square',
37 => 'drop-shadow-large',
44 => 'dark-contrast',
33 => 'light-minimal',
16 => 'drop-shadow-large',
38 => 'dark-background',
31 => 'soft',
6 => 'light-background-large',
7 => 'light-minimal',
8 => 'light-background-large',
9 => 'ligth-border-3d-large',
24 => 'light-background',
25 => 'light-background-large',
26 => 'ligth-border',
27 => 'ligth-border-3d-large',
28 => 'drop-shadow',
29 => 'drop-shadow',
35 => 'light-contrast',
30 => 'dark-background',
32 => 'dark-border',
22 => 'light-background-large',
23 => 'ligth-border',
11 => 'drop-shadow-large',
12 => 'light-minimal',
55 => 'light-minimal'
];
foreach($demo_list as $layout => $style): ?>
<?php
$template = TrustindexPlugin_facebook::$widget_templates['templates'][ $layout ];
$class_name = 'ti-full-width';
if(in_array($template['type'], [ 'badge', 'button', 'floating', 'popup', 'sidebar' ]))
{
$class_name = 'ti-half-width';
}
?>
<div class="<?php echo esc_attr($class_name); ?>">
<div class="ti-box ti-preview-boxes" data-layout-id="<?php echo esc_attr($layout); ?>" data-set-id="<?php echo esc_attr($style); ?>">
<div class="ti-header">
<span class="ti-header-layout-text">
<?php echo TrustindexPlugin_facebook::___('Example Widget'); ?>:
<strong><?php echo esc_html(TrustindexPlugin_facebook::___($template['name'])); ?></strong>
 (<?php echo esc_html(TrustindexPlugin_facebook::___(TrustindexPlugin_facebook::$widget_styles[$style]['name'])); ?>)
</span>
</div>
<div class="preview">
<?php echo $trustindex_pm_facebook->get_noreg_list_reviews(null, true, $layout, $style, true, true, true); ?>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
