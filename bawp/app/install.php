<?php

register_activation_hook(dirname(__DIR__).'/bawp.php', 'bawp_install');

function bawp_install() {
  global $wpdb;
   	
  $table_name = $wpdb->prefix . 'bawp_tables';
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE `" . $wpdb->prefix . "bawp_products` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`parent_id` varchar(11) NOT NULL,
			`name` varchar(255) NOT NULL,
			`url` varchar(600) NOT NULL,
			`photo` varchar(600) NOT NULL,
			`stars` int(10) DEFAULT NULL,
			`rating` varchar(30) DEFAULT NULL,
			`score` varchar(30) DEFAULT NULL,
			`reviews` varchar(30) NOT NULL,
			`description` varchar(500) NOT NULL,
			`rows` text,
			`sort` int(11) DEFAULT NULL,
			`featured_color` varchar(30) DEFAULT NULL,
			`featured_label` varchar(100) DEFAULT NULL,
			`date_update` datetime DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		CREATE TABLE `" . $wpdb->prefix . "bawp_tables` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) NOT NULL,
  		`rows` text,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
 
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

	}
 
}