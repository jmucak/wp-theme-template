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
?>
<main>
    <div class="o-page">
		<?php
		get_partial( 'layout/navigation' );
		?>
        <div class="o-page__inner">
			<?php
			echo get_filtered_content();
			?>
        </div>
		<?php
		get_partial( 'layout/footer' );
		get_footer();
		?>
    </div>
</main>