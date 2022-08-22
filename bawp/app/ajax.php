<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../wp-load.php';
require_once __DIR__ . '/../lib/functions.php';


$type = $_GET['type'];

if( $type == 'single' ){
	$box = bawp_single_content($_GET);
}else if( $type == 'list' ){
	$box = bawp_list_content($_GET);
}else{
	$box = 'error';
}

echo $box;