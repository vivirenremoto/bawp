<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../wp-load.php';
require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/' . bawp_php_version() . '/simple_html_dom.php';
require_once __DIR__ . '/../app/vars.php';

$general_test = TRUE;
$base_url = BAWP_WEB_URL;

// cache

require_once __DIR__ . '/cache.php';

echo '<br><br>';

// tables

require_once __DIR__ . '/tables.php';

echo '<br><br>';

// scrapping single

require_once __DIR__ . '/single.php';

echo '<br><br>';

// scrapping list

require_once __DIR__ . '/list.php';
