<?php

class BAWP_Cache{
   public $content;
   public $life;

   function __construct( $path ){
      $days = get_option('bawp_option_cache_days');
      if( !$days ) $days = 31;
      $this->life = 3600 * 24 * $days;
      $this->path = $path;
   }
   
   function get( $id ){
      $this->id = $id;
      $path = $this->getPath();
      if( $this->cache_exists( $path ) && $this->cache_expired(  $path ) ){
         return $this->load( $path );
      }
   }

   function load( $path ){
      return file_get_contents( $path );
   }

   function loadJSON( $path ){
      $items = array();
      $content = $this->load($path);
      if( $content ){
         $json = json_decode( $content, TRUE);
         if( $json[0]['name'] ){
            $items = $json;
         }
      }
      return $items;
   }

   function cache_exists( $path ){
      return file_exists( $path );
   }

   function cache_expired( $path ){
      return !isset($_GET['test']) && $this->cache_exists( $path ) && ( time() > ( filemtime( $path ) + $this->life ) );
   }
   
   function start(){
      ob_start();
   }
   
   function finish(){
      $this->content = ob_get_contents();
      ob_end_clean();
      return $this->content;
   }
   
   function save(){
      if( $this->id ){
         $path = $this->getPath();
         $handler = fopen( $path, 'w' );
         fwrite( $handler, $this->content );
         fclose( $handler );
      }
   }
   
   function getPath(){
      return $this->path . $this->id;
   }
}