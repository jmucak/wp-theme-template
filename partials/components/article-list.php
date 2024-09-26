<?php
/**
 *
 * @var array $movies
 * @var array $categories
 * @var array $current
 * @var int $paged
 * @var int $max_pages
 * @var string $relation
 * @var string $query
 * @var string $permalink
 *
 */

use wsytesTheme\providers\CPTProvider;

?>
<div>
	<?php
	if ( ! empty( $categories ) ) { ?>
		<div>
			<select name="" id="" data-type="<?php
			echo esc_attr( CPTProvider::TAXONOMY_ARTICLE_CAT ); ?>" class="js-cpt-filter">
				<?php
				foreach ( $categories as $category ) { ?>
					<option value="<?php
					echo esc_attr( $category->slug ); ?>" <?php
					echo ! empty( $current ) && ! empty( $current[0] ) && $current[0] === $category->slug ? 'selected' : ''; ?>><?php
						echo esc_html( $category->name ); ?></option>
					<?php
				} ?>
			</select>
		</div>

		<div>
			<?php
			foreach ( $categories as $category ) { ?>
				<label>
					<input type="checkbox" class="js-cpt-filter" data-type="<?php
					echo esc_attr( CPTProvider::TAXONOMY_ARTICLE_CAT ); ?>" value="<?php
					echo esc_attr( $category->slug ); ?>" name="<?php
					echo esc_attr( $category->slug ); ?>" <?php
					echo ! empty( $current ) && in_array( $category->slug, $current ) ? 'checked' : ''; ?>>
					<?php
					echo esc_html( $category->name ); ?>
				</label>
				<?php
			} ?>
		</div>

		<div>
			<?php
			foreach ( $categories as $category ) { ?>
				<a href="<?php
				echo add_query_arg( CPTProvider::TAXONOMY_ARTICLE_CAT, $category->slug, $permalink ); ?>" <?php
				echo ! empty( $current ) && ! empty( $current[0] ) && $current[0] === $category->slug ? 'style="color:red;"' : ''; ?>><?php
					echo esc_html( $category->name ); ?></a>
				<?php
			} ?>
		</div>
		<?php
	} ?>

	<form action="">
		<label for="search"></label><input type="search" name="search" id="search" class="js-search">
	</form>

	<?php
	if ( ! empty( $items ) ) {
		foreach ( $items as $item ) { ?>
			<a href="<?php
			echo get_permalink( $item ); ?>">
				<h2><?php
					echo $item->post_title; ?></h2>

				<p>Article description</p>
			</a>
			<?php
		}
	} else { ?>
		<div>
			<p>No results found</p>
		</div>
		<?php
	} ?>


	<?php
	get_partial( 'components/pagination', array(
		'current_page' => $paged,
		'max_pages'    => $max_pages,
		'query'        => $query,
		'url'          => $permalink,
	) );
	?>
</div>
