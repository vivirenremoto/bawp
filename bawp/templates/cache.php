<h1 class="wp-heading-inline"><?=__('Cache', 'bawp' )?></h1>

<?php if( $total_files ): ?>

	<?=sprintf(__('There are %d total cache files in folder:', 'bawp'), $total_files )?>

	<br>

	<?=$path?>

	<br><br>

	<a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_cache_delete" class="button button-primary"><?=__('Delete cache', 'bawp' )?></a>

<?php else: ?>
	<?=__('No cache files found', 'bawp')?>
<?php endif ?>