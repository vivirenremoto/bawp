<div class="bawp_minimal">
<div class="bawp_single">

	<div class="bawp_info">

		<a href="<?=$aff_url?>" target="_blank" rel="nofollow" class="bawp_name"><?=$name?></a> &nbsp; 

		<?php if( $stars ): ?>
			<span class="bawp_stars">
				<?php for($i=0;$i<$stars; $i++): ?>★<?php endfor ?>
			</span>
		<?php endif ?>

		<a href="<?=$aff_url?>" target="_blank" rel="nofollow" class="bawp_photo"><img src="<?=$photo?>" alt="<?=$name?>"></a>

		<div class="bawp_description">
			<?=$description?>
		</div>

		<br class="bawp_clear">

	</div>

</div>
</div>