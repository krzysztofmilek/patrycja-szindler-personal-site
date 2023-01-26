<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>
<div class="ti-box">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___('Want more %s reviews?', [ 'Facebook' ]); ?></div>
<?php if($trustindex_pm_facebook->shortname == "google"): ?>
<p><?php echo TrustindexPlugin_facebook::___("Get 100+ REAL Google reviews, with only 3 minutes of work, without developer knowledge..."); ?></p>
<a href="https://wordpress.trustindex.io/collect-google-reviews/?source=wpcs-facebook" target="_blank" class="btn-text"><?php echo TrustindexPlugin_facebook::___("DOWNLOAD OUR FREE GUIDE"); ?></a>
<?php else: ?>
<p><?php echo TrustindexPlugin_facebook::___("Get 100+ REAL Customer reviews, with only 3 minutes of work, without developer knowledge..."); ?></p>
<a href="https://wordpress.trustindex.io/collect-reviews/?source=wpcs-facebook" target="_blank" class="btn-text"><?php echo TrustindexPlugin_facebook::___("DOWNLOAD OUR FREE GUIDE"); ?></a>
<?php endif; ?>
</div>
<?php if(class_exists('Woocommerce')): ?>
<div class="ti-box">
<div class="ti-header"><?php echo TrustindexPlugin_facebook::___('Collect reviews automatically for your WooCommerce shop'); ?></div>
<?php if(!class_exists('TrustindexCollectorPlugin')): ?>
<p><?php echo TrustindexPlugin_facebook::___("Download our new <a href='%s' target='_blank'>%s</a> plugin and get features for free!", [ 'https://wordpress.org/plugins/customer-reviews-collector-for-woocommerce/', TrustindexPlugin_facebook::___('Customer Reviews Collector for WooCommerce') ]); ?></p>
<?php endif; ?>
<ul class="ti-check" style="margin-bottom: 20px">
<li><?php echo TrustindexPlugin_facebook::___('Send unlimited review invitations for free'); ?></li>
<li><?php echo TrustindexPlugin_facebook::___('E-mail templates are fully customizable'); ?></li>
<li><?php echo TrustindexPlugin_facebook::___('Collect reviews on 100+ review platforms (Google, Facebook, Yelp, etc.)'); ?></li>
</ul>
<?php if(class_exists('TrustindexCollectorPlugin')): ?>
<a href="?page=customer-reviews-collector-for-woocommerce%2Fadmin.php&tab=settings" class="btn-text">
<?php echo TrustindexPlugin_facebook::___("Collect reviews automatically"); ?>
</a>
<?php else: ?>
<a href="https://wordpress.org/plugins/customer-reviews-collector-for-woocommerce/" target="_blank" class="btn-text">
<?php echo TrustindexPlugin_facebook::___("Download plugin"); ?>
</a>
<?php endif; ?>
</div>
<?php endif; ?>