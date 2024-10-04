<?php
/**
 *
 * @var string $html
 *
 */

use wsytesTheme\providers\PostTypeProvider;

?>

<div class="js-cpt-filter-container"
     data-post-type="<?php echo esc_attr(PostTypeProvider::CPT_MOVIE); ?>"
     data-permalink="<?php echo get_permalink(); ?>">
	<?php echo $html; ?>
</div>
