<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
wp_enqueue_script('trustindex-js', 'https://cdn.trustindex.io/loader.js', [], false, true);
?>
<div class="ti-box rate-us en">
<div class="ti-box-head">
<div class="ti-row">
<div class="ti-col">
<h1><?php echo TrustindexPlugin_facebook::___('Please help us by reviewing our Plugin.'); ?></h1>
<p><?php echo TrustindexPlugin_facebook::___("We've spent a lot of time developing this software. If you use the free version, you can still support us by leaving a review!"); ?></p>
<p><?php echo TrustindexPlugin_facebook::___('Thank you in advance!'); ?></p>
</div>
<div class="ti-col-auto rate-us-wrapper">
<a class="btn-text btn-lg" href="https://wordpress.org/support/plugin/<?php echo $trustindex_pm_facebook->get_plugin_slug(); ?>/reviews/?rate=5#new-post" target="_blank"><?php echo TrustindexPlugin_facebook::___('Click here to rate us!'); ?></a>
</div>
</div>
</div>
<hr>
<div class="ti-row">
<div class="ti-col-12">
<div src='https://cdn.trustindex.io/loader.js?<?php echo '4939a17882283826ec54f11c97'; ?>'></div>
</div>
</div>
</div>