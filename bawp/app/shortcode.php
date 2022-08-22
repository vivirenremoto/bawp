<?php



add_shortcode('bawp', 'bawp_shortcode');
add_action('wp_enqueue_scripts', 'bawp_load_static');


function bawp_shortcode($atts=FALSE, $content=FALSE){

  if( !bawp_license_is_active() ){
    $content = __('To be able to use the plugin you should to activate a license', 'bawp');
    return $content;
  }


  require_once BAWP_PATH . '/lib/functions.php';

  if( $atts ) extract($atts);

  if( isset($url) ){
    
    if( strstr($url, 'searchresults') ){
      $content = bawp_list_shortcode($atts, $content);
    }else{
      $content = bawp_single_shortcode($atts, $content);
    }

  }else if( isset($table) ){
    $content = bawp_table_shortcode($atts, $content);
  }
  return $content;
}



function bawp_single_shortcode($atts, $content){

  if( $atts ) extract($atts);

  if( !isset($theme) || !file_exists(BAWP_PATH . '/themes/' . $theme) ) $theme = 'blue';
  if( !isset($button) ) $button = __('Show price', 'bawp');
  if( !isset($affiliate_id) ) $affiliate_id = FALSE;
  if( !isset($ajax) ) $ajax = get_option('bawp_option_ajax');


  $css_version = filemtime(BAWP_PATH . '/themes/' . $theme . '/bawp.css');
  wp_enqueue_style('bawp-main-css-' . $theme, WP_PLUGIN_URL . '/bawp/themes/' . $theme . '/bawp.css', array(), $css_version );



  $atts['theme'] = $theme;
  $atts['button'] = $button;
  $atts['affiliate_id'] = $affiliate_id;
  $atts['type'] = 'single';

  if( isset($_GET['test']) ) $atts['test'] = 1;


  // si hay version cacheada
  if( $ajax ){
    $pre_cache = bawp_pre_scrape_html($url);

    if( !$pre_cache['cache_reload'] ){
      $ajax = FALSE;
    }
  }


  if( $ajax ){
    $box = '<div class="bawp_ajax" data-atts="' . http_build_query($atts) . '"></div>';
  }else{
    $box = bawp_single_content($atts);
  }

  return $box;
}

function bawp_list_shortcode($atts, $content){


  if( $atts ) extract( $atts );

  if( !isset($theme) || !file_exists(BAWP_PATH . '/themes/' . $theme) ) $theme = 'blue';
  if( !isset( $button ) ) $button = __('Show price', 'bawp');
  if( !isset( $affiliate_id ) ) $affiliate_id = FALSE;
  if( !isset($ajax) ) $ajax = get_option('bawp_option_ajax');
  

  $css_version = filemtime(BAWP_PATH . '/themes/' . $theme . '/bawp.css');
  wp_enqueue_style('bawp-main-css-' . $theme, WP_PLUGIN_URL . '/bawp/themes/' . $theme . '/bawp.css', array(), $css_version );



  $atts['theme'] = $theme;
  $atts['button'] = $button;
  $atts['affiliate_id'] = $affiliate_id;
  $atts['type'] = 'list';


  if( isset($_GET['test']) ) $atts['test'] = 1;




  // si hay version cacheada
  if( $ajax ){
    $pre_cache = bawp_pre_scrape_html($url);

    if( !$pre_cache['cache_reload'] ){
      $ajax = FALSE;
    }
  }


  if( $ajax ){
    $box = '<div class="bawp_ajax" data-atts="' . http_build_query($atts) . '"></div>';
  }else{
    $box = bawp_list_content($atts);
  }



  return $box;
}

function bawp_table_shortcode($atts, $content){
  global $wpdb;

  if( $atts ) extract($atts);

  if( !isset($theme) || !file_exists(BAWP_PATH . '/themes/' . $theme) ) $theme = 'blue';
  if( !isset($affiliate_id) ) $affiliate_id = FALSE;
  if( !isset($scroll) ) $scroll = 'horizontal';
  if( !isset($column_width) ) $column_width = 250;

  $css_version = filemtime(BAWP_PATH . '/themes/' . $theme . '/bawp.css');
  wp_enqueue_style('bawp-main-css-' . $theme, WP_PLUGIN_URL . '/bawp/themes/' . $theme . '/bawp.css', array(), $css_version );


  $box = '';

  $item = $wpdb->get_row( $wpdb->prepare(
      "
      SELECT      *
      FROM        {$wpdb->prefix}bawp_tables
      WHERE       id = %d
      ", 
      $atts['table']
    ) );

  if( $item ){

    $products = $wpdb->get_results( $wpdb->prepare(
      "
      SELECT      *
      FROM        {$wpdb->prefix}bawp_products
      WHERE       parent_id = %d
      ORDER BY    sort ASC
      ", 
      $atts['table']
    ) );

    $total_products = count($products);

    if( $total_products == 0 ) $total_products = 1;

    $products_rows = array();

    foreach( $products as $k => $product ){
      $products_rows[ $k ] = json_decode( stripslashes( $product->rows ) ); 
    }

    $rows = json_decode( stripslashes( $item->rows ) );

    require BAWP_PATH . '/themes/' . $theme . '/table.php';
  }

  return $box;
}


function bawp_load_static() {
  require_once BAWP_PATH . '/lib/functions.php';
  
  wp_enqueue_script('jquery');
  wp_enqueue_script('bawp-user-js', WP_PLUGIN_URL . '/bawp/static/general.js', array(), BAWP_VERSION, TRUE);
  
  

  $content = "<script>\n";
  $content .= "var BAWP_DOMAIN = '" . get_site_url() . "';\n";
  $content .= "var BAWP_PLUGIN_AJAX_URL = '" . bawp_ajax_url() . "';\n";
  $content .= "var BAWP_LANG_EDIT_TABLE = '" . addslashes( __('Edit table', 'bawp') ) . "';\n";
  $content .= "</script>";
  echo $content;
}