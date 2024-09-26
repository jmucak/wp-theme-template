<?php
/**
 *
 * @var string $html
 *
 */

use wsytesTheme\providers\CPTProvider;

?>

<div class="js-cpt-filter-container"
     data-post-type="<?php echo esc_attr(CPTProvider::CPT_ARTICLE); ?>"
     data-permalink="<?php echo get_permalink(); ?>">
	<?php echo $html; ?>
</div>
