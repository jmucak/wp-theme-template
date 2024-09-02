<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage angelo
 */

get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); ?>
        <div>
			<?php
			if ( ! empty( get_post_thumbnail_id() ) ) { ?>
                <img src="<?php
				echo wp_get_attachment_image_url( get_post_thumbnail_id() ) ?>" alt="">
				<?php
			} ?>
            <h1><?php
				echo get_the_title(); ?></h1>

			<?php
			if ( has_excerpt() ) { ?>
                <p><?php
					echo get_the_excerpt(); ?></p>
				<?php
			} ?>
        </div>
		<?php
	}
}
get_footer();