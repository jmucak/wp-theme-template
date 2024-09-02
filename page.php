<?php
/**
 * The template for displaying default page templates
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
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