<?php

$path = __DIR__ . '/../cache';


echo '<b>Cache</b>';
echo '<br>';

if( is_writable( $path ) ){
    echo 'OK - cache folder has write permissions';
}else{
    echo 'ERROR - cache folder doesnt have write permissions';
}