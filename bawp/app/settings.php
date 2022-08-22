<?php

add_action( 'admin_init', 'bawp_register_settings' );

function bawp_config(){
  require_once BAWP_PATH . '/templates/settings.php';
}

function bawp_register_settings() {
   add_option( 'bawp_option_id', '');
   add_option( 'bawp_option_cache_days', '');
   add_option( 'bawp_option_ajax_url', '');
   add_option( 'bawp_option_ajax', '');
   add_option( 'bawp_option_proxies', '');

   register_setting( 'bawp_options_group', 'bawp_option_id', 'bawp_callback' );
   register_setting( 'bawp_options_group', 'bawp_option_cache_days', 'bawp_callback' );
   register_setting( 'bawp_options_group', 'bawp_option_ajax_url', 'bawp_callback' );
   register_setting( 'bawp_options_group', 'bawp_option_ajax', 'bawp_callback' );
   register_setting( 'bawp_options_group', 'bawp_option_proxies', 'bawp_callback' );
}