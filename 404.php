<?php
/**
 * The template for displaying 404 pages (not found)
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
            <h1>
                Page not found
            </h1>
        </div>
		<?php
		get_partial( 'layout/footer' );
		get_footer();
		?>
    </div>
</main>

