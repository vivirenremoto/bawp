
<div>

<?php if( isset($_GET['settings-updated']) ): ?>
	<div class="notice notice-success" style="margin:30px 0 30px 0">
	  <p><?=__('Changes saved successfully', 'bawp')?></p>
	</div>
<?php endif ?>

<h1 class="wp-heading-inline">BAWP - <?=__('Settings', 'bawp')?></h1>

<br>

<form method="post" action="options.php">
<?php settings_fields('bawp_options_group') ?>


<b><?=__('Affiliate site ID (AID)', 'bawp')?></b><br>
<?=__('You can find it on: Booking Affiliates &gt; Yout account &gt; Other affiliates', 'bawp')?><br>
<br>
<input type="text" name="bawp_option_id" value="<?php echo esc_attr( get_option('bawp_option_id') ); ?>">






<br><br><br>
<label><input type="checkbox" name="bawp_option_ajax" value="1" <?php if( get_option('bawp_option_ajax') ): ?>checked="checked"<?php endif ?> > <b><?=__('Load content via AJAX', 'bawp')?></b></label>


<br><br><br>

<b><?=__("Days to expire the cache (By default 31 days)", 'bawp')?></b><br>
<input type="text" name="bawp_option_cache_days" value="<?php echo esc_attr( get_option('bawp_option_cache_days') ); ?>">


<br><br><br>

<b><?=__("AJAX URL", 'bawp')?></b><br>
<input type="text" size="52" name="bawp_option_ajax_url" value="<?php echo esc_attr( get_option('bawp_option_ajax_url') ); ?>">



<br><br><br>

<b><?=__('Proxies', 'bawp')?></b><br
><?=__('We recommend <a href="http://bit.ly/2Z6jxp5" target="_blank">proxy-hub.com</a>', 'bawp')?><br>

<textarea name="bawp_option_proxies" rows="5" cols="50"><?php echo esc_attr( get_option('bawp_option_proxies') ); ?></textarea>

<br><br>

<?=__('Format', 'bawp')?><br>
PROXY:PORT:USERNAME:PASSWORD<br>
PROXY:PORT:USERNAME:PASSWORD



<?php submit_button(); ?>
</form>
</div>