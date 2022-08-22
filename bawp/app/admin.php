<?php


add_action('admin_menu', 'bawp_register_options_page');
add_action('admin_footer', 'bawp_load_jsvars');
add_action('wp_ajax_bawp_item_add', 'bawp_item_add');
add_action('wp_ajax_bawp_item_delete', 'bawp_item_delete');
add_action('wp_ajax_bawp_search', 'bawp_search');
add_action('wp_ajax_bawp_table_save', 'bawp_table_save');
  


function bawp_register_options_page() {

  if( bawp_license_is_active() ){

    add_menu_page('BAWP', 'BAWP', 'manage_options', 'bawp_tables');
    add_submenu_page( 'bawp_tables', __('Tables', 'bawp'), __('Tables', 'bawp'), 'manage_options', 'bawp_tables', 'bawp_tables');
    add_submenu_page( 'bawp_tables', __('Settings', 'bawp'), __('Settings', 'bawp'), 'manage_options', 'bawp_config', 'bawp_config');
    add_submenu_page( 'bawp_tables', __('Cache', 'bawp' ), __('Cache', 'bawp' ), 'manage_options', 'bawp_cache', 'bawp_cache');
    add_submenu_page( 'bawp_tables', __("Themes", 'bawp'), __("Themes", 'bawp'), 'manage_options', 'bawp_themes', 'bawp_themes');
    add_submenu_page( 'bawp_tables', __('Support', 'bawp'), __('Support', 'bawp'), 'manage_options', 'bawp_support', 'bawp_support');
    add_submenu_page( 'bawp_tables', __('License', 'bawp'), __('License', 'bawp'), 'manage_options', 'bawp_license', 'bawp_license');

    add_submenu_page(NULL, __('Edit table', 'bawp'), NULL, 'manage_options', 'bawp_edit', 'bawp_edit');
    add_submenu_page(NULL, __('Delete table', 'bawp'), NULL, 'manage_options', 'bawp_delete', 'bawp_delete');
    add_submenu_page(NULL, __('Add item to table', 'bawp'), NULL, 'manage_options', 'bawp_search', 'bawp_search');
    add_submenu_page(NULL, __('Add item', 'bawp'), NULL, 'manage_options', 'bawp_products_add', 'bawp_products_add');
    add_submenu_page(NULL, __('Clone item', 'bawp'), NULL, 'manage_options', 'bawp_clone', 'bawp_clone');
    add_submenu_page(NULL, __('Clone item', 'bawp'), NULL, 'manage_options', 'bawp_clone_structure', 'bawp_clone_structure');
    add_submenu_page(NULL, __('Delete cache', 'bawp' ), NULL, 'manage_options', 'bawp_cache_delete', 'bawp_cache_delete');
    add_submenu_page(NULL, __('Deactivate license', 'bawp' ), NULL, 'manage_options', 'bawp_disable_license', 'bawp_disable_license');
    

  }else{
    add_menu_page('BAWP', 'BAWP', 'manage_options', 'bawp_license');
    add_submenu_page( 'bawp_tables', __('License', 'bawp'), __('License', 'bawp'), 'manage_options', 'bawp_license', 'bawp_license');

  }
}




function bawp_tables(){
  global $wpdb;

  require_once BAWP_PATH . '/lib/functions.php';

  if( count($_POST) ){
    $name = $_POST['name'];

    if( $name ){

      $rows = array();
      $rows[] = array('title'=>__('Name', 'bawp'), 'type'=>'name');
      $rows[] = array('title'=>__('Photo', 'bawp'), 'type'=>'photo');
      $rows[] = array('title'=>__('Score', 'bawp'), 'type'=>'score');
      $rows[] = array('title'=>__('Reviews', 'bawp'), 'type'=>'reviews');
      $rows[] = array('title'=>__('Price', 'bawp'), 'type'=>'button_price');


      $rows_json = json_encode($rows, JSON_UNESCAPED_UNICODE);

      $wpdb->insert( 
        $wpdb->prefix . 'bawp_tables', 
        array( 
          'name' => $name,
          'rows' => $rows_json
        ), 
        array( 
          '%s'
        ) 
      );

    }

  }

 
  $items = $wpdb->get_results("SELECT s.*, (SELECT COUNT(*) FROM {$wpdb->prefix}bawp_products p WHERE s.id=p.parent_id) AS total_products FROM {$wpdb->prefix}bawp_tables s ORDER BY s.id ASC");


  require BAWP_PATH . '/templates/tables.php';

}





function bawp_edit(){
  global $wpdb;

  $item = FALSE;
  $id = (int)$_GET['id'];
  if( $id ){
    $item = $wpdb->get_row( $wpdb->prepare(
      "
      SELECT      *
      FROM        {$wpdb->prefix}bawp_tables
      WHERE       id = %d
      ", 
      $id
    ) );
  }

  if( !$item ){
    echo "<script>document.location='" . BAWP_DEFAULT_URL . "';</script>";
    exit();
  }


  $items = $wpdb->get_results( $wpdb->prepare(
      "
      SELECT      *
      FROM        {$wpdb->prefix}bawp_products
      WHERE       parent_id = %d 
      ORDER BY    sort ASC
      ", 
      $id
    ) );


  bawp_load_jsvars();

  wp_enqueue_script('jquery');

  wp_enqueue_script('jquery-ui', '//code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'), NULL);

  wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', FALSE, NULL);

  wp_enqueue_script('bawp-admin', WP_PLUGIN_URL . '/bawp/static/jquery.drawrpalette.js', array(), BAWP_VERSION, TRUE);

  require_once BAWP_PATH . '/templates/table_edit.php';

}

function bawp_delete(){
  global $wpdb;

  $id = (int)$_GET['id'];
  if( $id ){
    $wpdb->delete("{$wpdb->prefix}bawp_tables", array('id' => $id) );
    $wpdb->delete("{$wpdb->prefix}bawp_products", array('parent_id' => $id) );
  }

  echo "<script>document.location='" . BAWP_DEFAULT_URL . "';</script>";
  exit();

}

function bawp_products_add(){
  global $wpdb;

  $item = FALSE;
  $id = (int)$_GET['id'];
  if( $id ){
    $item = $wpdb->get_row( $wpdb->prepare(
      "
      SELECT      *
      FROM        {$wpdb->prefix}bawp_tables
      WHERE       id = %d
      ", 
      $id
    ) );
  }

  if( !$item ){
    echo "<script>document.location='" . BAWP_DEFAULT_URL . "';</script>";
    exit();
  }

  bawp_load_jsvars();

  require_once BAWP_PATH . '/templates/products_add.php';

}




function bawp_load_jsvars(){

    $css_version = filemtime(BAWP_PATH . '/static/admin.css');
    wp_enqueue_style( 'bawp-admin-css', WP_PLUGIN_URL . '/bawp/static/admin.css', array(), $css_version);

    $js_version = filemtime(BAWP_PATH . '/static/admin.js');
    wp_enqueue_script('bawp-admin-js', WP_PLUGIN_URL . '/bawp/static/admin.js', array(), $js_version, TRUE);




    wp_enqueue_style('bawp-sortable-css', '//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css', array(), BAWP_VERSION);
    wp_enqueue_script('bawp-sortable-js', '//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js', array(), BAWP_VERSION, TRUE);
  
    

    $content = "<script>\n";
    $content .= "var BAWP_DOMAIN = '" . get_site_url() . "';\n";
    $content .= "var BAWP_PATH = '" . WP_PLUGIN_URL . '/bawp/' . "';\n";
    $content .= "var BAWP_LANG_SURE = '" . addslashes(__('Are you sure?', 'bawp')) . "';";
    $content .= "</script>";
    echo $content;
}

function bawp_clone(){
  global $wpdb;

  $id = (int)$_GET['id'];
  if( $id ){
    $item = $wpdb->get_row( $wpdb->prepare(
      "
      SELECT      *
      FROM        {$wpdb->prefix}bawp_tables
      WHERE       id = %d
      ", 
      $id
    ) );
  }

  if( $item ){
    $wpdb->insert( 
      $wpdb->prefix . 'bawp_tables', 
      array( 
        'name' => $item->name . ' ' . __('Copy', 'bawp'),
        'rows' => $item->rows,
      ), 
      array(
        '%s',
        '%s'
      ) 
    );

    $new_parent_id = $wpdb->insert_id;

    $items = $wpdb->get_results( $wpdb->prepare(
      "
      SELECT      *
      FROM        {$wpdb->prefix}bawp_products
      WHERE       parent_id = %d
      ", 
      $id
    ) );

    foreach( $items as $item ){
      $wpdb->insert( 
        $wpdb->prefix . 'bawp_products', 
        array( 
          'parent_id' => $new_parent_id,
          'name' => $item->name,
          'url' => $item->url,
          'photo' => $item->photo,
          'stars' => $item->stars,
          'rating' => $item->rating,
          'score' => $item->score,
          'reviews' => $item->reviews,
          'description' => $item->description,
          'rows' => $item->rows,
          'sort' => $item->sort,
          'featured_color' => $item->featured_color,
          'featured_label' => $item->featured_label,
          'date_update' => $item->date_update,
        ), 
        array( 
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
        ) 
      );
    }
  }

  echo "<script>document.location='" . BAWP_DEFAULT_URL . "';</script>";
  exit();

}

function bawp_clone_structure(){
  global $wpdb;

  $id = (int)$_GET['id'];
  if( $id ){
    $item = $wpdb->get_row( $wpdb->prepare(
      "
      SELECT      *
      FROM        {$wpdb->prefix}bawp_tables
      WHERE       id = %d
      ", 
      $id
    ) );
  }

  if( $item ){
    $wpdb->insert( 
      $wpdb->prefix . 'bawp_tables', 
      array( 
        'name' => $item->name . ' ' . __('Copy', 'bawp'),
        'rows' => $item->rows,
      ), 
      array(
        '%s',
        '%s'
      ) 
    );

    $new_parent_id = $wpdb->insert_id;
  }

  echo "<script>document.location='" . BAWP_DEFAULT_URL . "';</script>";
  exit();

}


function bawp_item_delete(){
  global $wpdb;

  if( !is_user_logged_in() ) exit();

  extract( $_POST );

  $wpdb->delete(
    $wpdb->prefix . 'bawp_products', 
    array('id' => $id),
    array('%d')
  );

  die('ok');
}


function bawp_item_add(){
  global $wpdb;

  if( !is_user_logged_in() ) exit();

  extract( $_POST );

  if( $parent_id && $name && $url && $photo && $rating && $score && $reviews && $description ){

    $sort = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'bawp_products' . ' WHERE parent_id = ' . $parent_id );
    $sort++;

    $wpdb->insert( 
      $wpdb->prefix . 'bawp_products', 
      array( 
        'parent_id' => $parent_id,
        'name' => $name,
        'url' => $url,
        'photo' => $photo,
        'stars' => $stars,
        'rating' => $rating,
        'score' => $score,
        'reviews' => $reviews,
        'description' => $description,
        'sort' => $sort,
        'date_update' => date('Y-m-d H:i:s'),
      ), 
      array( 
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
      ) 
    );

  }

  die('ok');
}


function bawp_search(){
  require_once BAWP_PATH . '/lib/functions.php';
  require_once BAWP_PATH . '/lib/' . bawp_php_version() . '/simple_html_dom.php';

  $items = array();

  extract( $_POST );

  if( isset( $search ) ){
    $base_url = BAWP_WEB_URL;

    $search = str_replace('#hotelTmpl', '', $search);
    
    if( strstr($base_url, 'searchresults') ) $search .= '&sr_ajax=1';

    $result = bawp_curl( $search );
    $html = $result['content'];
    
    if( strstr($html, 'sr_item') || strstr($html, 'sr__card') ) require BAWP_PATH . '/scrapping/list.php';
    else if( strstr($html, 'hp_hotel_name') ) require BAWP_PATH . '/scrapping/single.php';
    
  }


  require_once BAWP_PATH . '/templates/search.php';
  exit();
}

function bawp_table_save(){
  global $wpdb;

  if( !is_user_logged_in() ) exit();


  extract( $_POST );

  $wpdb->update( 
    $wpdb->prefix . 'bawp_tables', 
    array( 
      'name' => $name,
      'rows' => $rows
    ), 
    array( 
      'id' => $id
    ), 
    array(
      '%s',
      '%s'
    ), 
    array( 
      '%s'
    ) 
  );

  if( isset($_POST['products']) ){

    $products = json_decode( stripslashes( $products ) );

    foreach( $products as $product ){

      

      $wpdb->update( 
        $wpdb->prefix . 'bawp_products', 
        array( 
          'rows' => json_encode( $product->rows, JSON_UNESCAPED_UNICODE ),
          'sort' => $product->sort,
          'featured_color' => $product->featured_color,
          'featured_label' => $product->featured_label,
          
        ), 
        array( 
          'id' => $product->id
        ), 
        array(
          '%s',
          '%d',
          '%s',
          '%s',
        ), 
        array( 
          '%d'
        ) 
      );
    }

  }

  die('ok');
}


function bawp_support(){
  require_once BAWP_PATH . '/templates/support.php';
}

function bawp_cache(){
  $path = BAWP_CACHE_PATH;
  $files  = scandir( $path );
  $total_files = count( $files ) - 2;
  $path = str_replace('\\', '/', $path);
  require_once BAWP_PATH . '/templates/cache.php';
}

function bawp_cache_delete(){
  $path = BAWP_CACHE_PATH;
  $files  = scandir( $path );
  foreach( $files as $file ){
    if( !in_array($file, array('.','..') ) ){
      @unlink($path . $file);
    }
  }
  $url = get_site_url() . '/wp-admin/admin.php?page=bawp_cache';
  echo "<script>document.location='" . $url . "';</script>";
  exit();
}

function bawp_themes(){
  $items = array();
  $info_sources = array();
  $path = BAWP_PATH . '/themes/';
  $files  = scandir( $path );
  foreach( $files as $file ){
    if( !in_array($file, array('.','..') ) ){
      $items[] = $file;

      $credits = json_decode( file_get_contents(BAWP_PATH . '/themes/' . $file . '/credits.json') );
      $info[$file] = (object)array(
        'version' => $credits->version,
        'authors' => $credits->authors
      );

    }
  }

  require BAWP_PATH . '/templates/themes.php';
}