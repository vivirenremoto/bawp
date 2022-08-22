<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../wp-load.php';
require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/' . bawp_php_version() . '/simple_html_dom.php';
require_once __DIR__ . '/../app/vars.php';

$url = 'https://www.booking.com/hotel/ec/nautilus-vacation-rentals.es.html';

$result = bawp_curl( $url );

$html = $result['content'];
      
require BAWP_PATH . '/scrapping/single.php';

echo '<b>Scrapping single</b>';
echo '<br>';

if( $items[0]['name'] == 'Nautilus Lodge' ){
    echo 'OK - scrapping works';
}else{
    echo 'ERROR - scraping doesnt work';
}

if( !isset($general_test) ){
    echo '<pre>';
    print_r( $items );
}