<?php


function bawp_affiliate_link( $url, $affiliate_id=FALSE ){
	if( !$affiliate_id ) $affiliate_id = get_option('bawp_option_id');

    if( !strstr($url, BAWP_WEB_URL) ) $url = BAWP_WEB_URL . $url;

	$url .= strstr($url, '?') ? '&' : '?';
    $url .= BAWP_WEB_AFF_PARAM . '=' . $affiliate_id;
    
    $date_start = time();
    $date_end = strtotime('+1 week');

    return $url;
}

/////////////////


function bawp_pre_scrape_html($url){
    require_once BAWP_PATH . '/lib/cache.php';

    $url = str_replace('&amp;', '&', $url);


    $cache_file = md5( $url ) . '.json';

    
    $bots = bawp_bots_list();
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $is_bot = in_array($user_agent, $bots);


    $cache = new BAWP_Cache( BAWP_CACHE_PATH );
    $cache_file_path = BAWP_CACHE_PATH . $cache_file;
    $cache_exists = $cache->cache_exists( $cache_file_path );
    $cache_expired = $cache->cache_expired( $cache_file_path );


    $cache_reload = TRUE;


    if( $is_bot ){
        if( $cache_exists ){
            $cache_reload = FALSE;
        }
    }else{
        if( $cache_exists && !$cache_expired ){
            $cache_reload = FALSE;
        }
    }

    return array(
        'cache' => $cache,
        'cache_file' => $cache_file,
        'cache_file_path' => $cache_file_path,
        'cache_exists' => $cache_exists,
        'cache_expired' => $cache_expired,
        'cache_reload' => $cache_reload,
    );
}

function bawp_scrape_html( $url, $type ){

    $items = array();



    extract( bawp_pre_scrape_html($url) );


    

    if( $cache_reload ){

        $date_start = strtotime('+1 day');
        $date_end = strtotime('+1 week');

        $t_url = explode('?', $url);
        $url = $t_url[0];

        if( strstr($url, 'searchresults') ){

            parse_str($t_url[1], $t_query);

            unset($t_query['order']);
            
            $t_query['sr_ajax'] = 1;

            $t_query['checkin_year'] = date('Y', $date_start);
            $t_query['checkin_month'] = date('n', $date_start);
            $t_query['checkin_monthday'] = date('j', $date_start);

            $t_query['checkout_year'] = date('Y', $date_end);
            $t_query['checkout_month'] = date('n', $date_end);
            $t_query['checkout_monthday'] = date('j', $date_end);

            $i = 0;
            foreach( $t_query as $key => $value ){
                $url .= $i ? '&' : '?';
                $url .= $key . '=' . str_replace(' ', '%20', $value);
                $i++;
            }
        }

        
   
        $result = bawp_curl( $url );



        if( $result['status'] == 200 ){
            $html = $result['content'];

            if( $html ){

                // verificar que se puede parsear el html
                if( $type == 'list' ){
                    require BAWP_PATH . '/scrapping/list.php';
                }else if( $type == 'single' ){
                    require BAWP_PATH . '/scrapping/single.php';
                }


                // si la web de booking ha cambiado cargar última cache
                if( !$items ){
                    if( $cache_exists ){
                        $items = $cache->loadJSON( $cache_file_path );
                    }else{
                        $items = array();
                    }
                }


                $json = json_encode($items);

                $cache->id = $cache_file;
                $cache->content = $json;
                $cache->save();


            }
        }else{
            
            if( $cache_exists ){
                $items = $cache->loadJSON( $cache_file_path );
            }else{
                $items = array();
            }

            $log_path = BAWP_CACHE_PATH . '/log.txt';
            $log_content = date('Y-m-d H:i:s') . ' - ' . $result['status'] . ' - ' . $result['error'] . "\r\n";
            $handler = fopen( $log_path, 'a' );
            fwrite( $handler, $log_content );
            fclose( $handler );
        }

    }else{
        
        $items = $cache->loadJSON( $cache_file_path );
    }

    return $items;
}


function bawp_curl($url){

    $bots = bawp_bots_list();

    shuffle( $bots );
    shuffle( $bots );
    $random_bot = trim(current($bots));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLINFO_REDIRECT_URL, 1);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_USERAGENT, $random_bot );

    $proxies = get_option('bawp_option_proxies');


    if( $proxies ){
        $proxies = explode("\r\n", $proxies);
        shuffle($proxies);
        shuffle($proxies);
        $current_proxy = trim(current($proxies));
        list($proxy, $port, $user, $pass) = explode(':', $current_proxy);

        curl_setopt($ch, CURLOPT_PROXY, $proxy . ':'. $port );
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $user . ':' . $pass );
    }

    

    $response = curl_exec($ch);


    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = FALSE;

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        if( stristr($error, 'Operation timed out after') ) $httpCode = 0;
    }

    curl_close($ch);

    return array('status' => $status, 'content' => $response, 'error' => $error);
}


function bawp_bots_list(){
    $bots_path = __DIR__ . '/../scrapping/bots.txt';
    return explode("\n", file_get_contents($bots_path));
}

function bawp_php_version(){
    $php_version = phpversion();
    
    if( strstr($php_version, '7.4') ) {
        $lib_version = '7.4';
    }else{
        $lib_version = '7.3';
    }
    return $lib_version;
}


function bawp_single_content($atts){
    require_once BAWP_PATH . '/lib/' . bawp_php_version() . '/simple_html_dom.php';
    

    extract($atts);


    $items = bawp_scrape_html( $url, $atts['type'] );

    if( $items ){

        extract($items[0]);

        $aff_url = bawp_affiliate_link( $url, $affiliate_id );

        ob_start();
        require BAWP_PATH . '/themes/' . $theme . '/single.php';
        $box = ob_get_contents();
        ob_end_clean();

    }else{
        $box = 'error';
    }

    return $box;
}


function bawp_list_content($atts){
    require_once BAWP_PATH . '/lib/' . bawp_php_version() . '/simple_html_dom.php';
    

    extract($atts);


    if( isset( $url ) ){
        $cache_file = md5( $url ) . '.json';
        $url .= '&sr_ajax=1';
    }

    $items = bawp_scrape_html( $url, $atts['type'] );


    if( $items ){

        if( isset($limit) ) $items = array_splice($items, 0, $limit);


        ob_start();
        require BAWP_PATH . '/themes/' . $theme . '/list.php';
        $box = ob_get_contents();
        ob_end_clean();

    }else{
        $box = 'error';
    }

    return $box;
}




function bawp_ajax_url(){
    $url = get_option('bawp_option_ajax_url');
    if( !$url ) $url = WP_PLUGIN_URL . '/bawp/app/ajax.php';
    return $url;
}




