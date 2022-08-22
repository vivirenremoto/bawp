<?php

if( isset( $_GET['test'] ) ){
    $static_version = time();
}else{
    $static_version = '1.91';
}

$static_version = time();

define('BAWP_VERSION', $static_version);
define('BAWP_DEFAULT_URL', get_site_url() . '/wp-admin/admin.php?page=bawp_tables' );
define('BAWP_PATH', dirname(__DIR__));
define('BAWP_CACHE_PATH', BAWP_PATH . '/cache/');
define('BAWP_CRON_LIMIT', 5);
define('BAWP_WEB_URL', 'https://www.booking.com' );
define('BAWP_WEB_AFF_PARAM', 'aid');
define('BAWP_PRODUCT_ID', 3031);