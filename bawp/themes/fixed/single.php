<div class="bawp_fixed">
<div class="bawp_single">

	<div class="bawp_info">

		<a href="<?=$aff_url?>" target="_blank" rel="nofollow" class="bawp_name"><?=$name?></a> &nbsp; 

		<?php if( $stars ): ?>
			<span class="bawp_stars">
				<?php for($i=0;$i<$stars; $i++): ?>★<?php endfor ?>
			</span>
		<?php endif ?>

		<a href="<?=$aff_url?>" target="_blank" rel="nofollow" class="bawp_photo"><img src="<?=$photo?>" alt="<?=$name?>"></a>

	</div>

	<?php if( $score ): ?>
		<div class="bawp_rating">		
			<span class="bawp_score"><?=$score?></span>
			<b><?=$rating?></b>
			<span class="bawp_comments"><?=$reviews?> <?=__('reviews', 'bawp')?></span>
		</div>
	<?php endif ?>

	<a href="<?=$aff_url?>" target="_blank" rel="nofollow" class="bawp_button"><?=$button?></a>

	<br class="bawp_clear">

</div>
</div>