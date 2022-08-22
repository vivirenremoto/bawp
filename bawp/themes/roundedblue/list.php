<?php

if( $items ){
	echo '<div class="bawp_roundedblue">';
	echo '<div class="bawp_list">';

	foreach( $items as $item ){
		extract( (array)$item );

		$aff_url = bawp_affiliate_link( $url, $affiliate_id );
		
		require BAWP_PATH . '/themes/' . $theme . '/single.php';
	}
	
	echo '</div>';
	echo '</div>';
}

?>