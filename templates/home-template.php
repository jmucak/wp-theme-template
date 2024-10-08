<?php
/** Template Name: Home Template */

get_header();
?>
<main>
    <div class="o-page">
		<?php
		get_partial( 'layout/navigation' );
		?>
        <div class="o-page__inner">
            <h1>Home template</h1>
        </div>
		<?php
		get_partial( 'layout/footer' );
		get_footer();
		?>
    </div>
</main>

