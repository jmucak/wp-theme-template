<?php

get_header();
?>
<main>
	<div class="o-page">
		<?php
		get_partial( 'layout/navigation' );
		?>
		<div class="o-page__inner">
			<?php
			//$fields = get_fields();

			echo get_filtered_content();
			?>
		</div>
		<?php
		get_partial( 'layout/footer' );
		get_footer();
		?>
	</div>
</main>
