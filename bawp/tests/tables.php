<?php

require_once __DIR__ . '/../../../../wp-load.php';
   	
echo '<b>Tables</b>';
echo '<br>';
   	
$table_name = $wpdb->prefix . 'bawp_tables';
if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
    echo 'ERROR - ' . $table_name . ' database table doesnt exists';
}else{
    echo 'OK - ' . $table_name . ' database table exists';
}

echo '<br>';

$table_name = $wpdb->prefix . 'bawp_products';
if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
    echo 'ERROR - ' . $table_name . ' database table exists';
}else{
    echo 'OK - ' . $table_name . ' database table exists';
}
