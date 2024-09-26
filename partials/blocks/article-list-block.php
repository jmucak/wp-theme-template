<?php
/**
 *
 * @var string $output
 *
 */

use wsytesTheme\providers\CPTProvider;

?>

<div class="js-cpt-filter-container"
     data-post-type="<?php echo esc_attr(CPTProvider::CPT_ARTICLE); ?>"
     data-relation="<?php echo esc_attr( CPTProvider::RELATION_ARTICLE ); ?>"
     data-permalink="<?php echo get_permalink(); ?>">
	<?php echo $output; ?>
</div>
