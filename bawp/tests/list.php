<?php

$date_start = time();
$date_end = strtotime('+1 week');

$url = 'https://www.booking.com/searchresults.es.html?tmpl=searchresults&checkin_month=' . date('n', $date_start) . '&checkin_monthday=' . date('j', $date_start) . '&checkin_year=' . date('Y', $date_start) . '&checkout_month=' . date('n', $date_end) . '&checkout_monthday=' . date('j', $date_end) . '&checkout_year=' . date('Y', $date_end) . '&class_interval=1&dest_id=-390625&dest_type=city&from_sf=1&group_adults=2&group_children=0&label_click=undef&no_rooms=1&raw_dest_type=city&room1=A%2CA&sb_price_type=total&shw_aparth=1&slp_r_match=0&src=index&srpvid=fc458280824b012b&ss=Madrid&ssb=empty&ssne=Madrid&ssne_untouched=Madrid&top_ufis=1&nflt=accessible_room_facilities%3D148%3B&rsf=';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../wp-load.php';
require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/' . bawp_php_version() . '/simple_html_dom.php';
require_once __DIR__ . '/../app/vars.php';

$result = bawp_curl( $url );

$html = $result['content'];
      
require BAWP_PATH . '/scrapping/list.php';

echo '<b>Scrapping list</b>';
echo '<br>';

if( !empty($items[0]->name) ){
    echo 'OK - scrapping works';
}else{
    echo 'ERROR - scraping doesnt work';
}

if( !isset($general_test) ){
    echo '<pre>';
    print_r( $items );
}