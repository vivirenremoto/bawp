<?php

add_action('plugins_loaded', 'bawp_init');

function bawp_init() {
    $plugin_rel_path = basename(dirname(__DIR__)) . '/languages';
    load_plugin_textdomain('bawp', FALSE, $plugin_rel_path);
}