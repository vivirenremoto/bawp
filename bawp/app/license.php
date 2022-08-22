<?php

add_action('wp_ajax_bawp_check_license', 'bawp_check_license');

function bawp_license_is_active(){
    $date = date("Y-m-d", strtotime("+1 year"));
    update_option('bawp_activation', $date);
    return $date;
    
    //if( strstr($_SERVER['SERVER_NAME'], '.test') || strstr($_SERVER['SERVER_NAME'], '.local') || $_SERVER['SERVER_NAME'] == 'localhost' ) return TRUE;
    //return get_option('bawp_activation');
}

function bawp_check_license(){
    require_once BAWP_PATH . '/lib/functions.php';
    $lang = get_bloginfo('language');
    $license = trim($_POST['license']);
    $domain = $_POST['domain'];

    $url = 'https://vivirenremoto.com/license/check.php?id=' . BAWP_PRODUCT_ID . '&license=' . $license . '&domain=' . $domain . '&lang=' . $lang;
    $result = bawp_curl( $url );
    $data = json_decode( $result['content'] );
    if( $data->valid ){
        update_option('bawp_activation', $data->date_end );
    }
    echo $result['content'];
    exit();
}
  
function bawp_license(){
    $license = bawp_license_is_active();
    require_once BAWP_PATH . '/templates/license.php';
}

function bawp_disable_license(){
    delete_option('bawp_activation');
    echo "<script>document.location='" . get_site_url() . "/wp-admin/admin.php?page=bawp_license';</script>";
    exit();
}