<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../wp-load.php';
require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/' . bawp_php_version() . '/simple_html_dom.php';
require_once __DIR__ . '/../lib/cache.php';
require_once __DIR__ . '/../app/vars.php';

$items = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}bawp_products WHERE date_update < NOW() ORDER BY date_update ASC LIMIT " . BAWP_CRON_LIMIT );


if( $items ){
  foreach( $items as $item ){

    $url = $item->url;

    $cache_file = md5( $url ) . '.html';
    $url .= '&sr_ajax=1';


    $result = bawp_curl( $url );

    if( $result['status'] == 200 ){

      $html = $result['content'];
      
      require BAWP_PATH . '/scrapping/single.php';

      $res = $wpdb->update( 
        "{$wpdb->prefix}bawp_products", 
        array(
          'rating' => $rating,
          'score' => $score,
          'reviews' => $reviews,
          'date_update' => date('Y-m-d H:i:s'),
        ), 
        array(
          'url' => $item->url
        ), 
        array( 
          '%s',
          '%s',
          '%s',
          '%s',
        ),
        array(
          '%s',
        )
      );

    }


  }
}

echo "ok";