<?php

$photo = str_replace('/square200/', '/max1024x768/', $photo);

?>
<div class="bawp_shadow">

	<div class="bawp_single" style="background-image: url('<?=$photo?>');">

		<div class="bawp_content">

			<b class="bawp_name"><?=$name?></b>

			<div class="bawp_description"><?=$description?></div>

			<?php if( $score ): ?>
				<div class="bawp_rating">		
					<span class="bawp_score"><?=$score?></span>
					<b><?=$rating?></b> 
					<span class="bawp_divisor"> &nbsp;-&nbsp; </span>
					<span class="bawp_comments"><?=$reviews?> <?=__('reviews', 'bawp')?></span>
				</div>
				<br class="bawp_clear">
			<?php endif ?>

			<a href="<?=$aff_url?>" target="_blank" rel="nofollow" class="bawp_button"><?=$button?></a>

		</div>

	</div>

</div>