<?php
/**
 *
 * @var array $items
 * @var array $genres
 * @var array $current
 * @var int $paged
 * @var int $max_pages
 * @var string $relation
 * @var string $query
 * @var string $permalink
 *
 */

use wsytesTheme\providers\TaxonomyProvider;

?>
<div>
	<?php
	if ( ! empty( $genres ) ) { ?>
        <div>
            <select name="" id="" data-type="<?php
			echo esc_attr( TaxonomyProvider::TAXONOMY_GENRE ); ?>" class="js-cpt-filter">
				<?php
				foreach ( $genres as $genre ) { ?>
                    <option value="<?php
					echo esc_attr( $genre->slug ); ?>" <?php
					echo ! empty( $current ) && ! empty( $current[0] ) && $current[0] === $genre->slug ? 'selected' : ''; ?>><?php
						echo esc_html( $genre->name ); ?></option>
					<?php
				} ?>
            </select>
        </div>

        <div>
			<?php
			foreach ( $genres as $genre ) { ?>
                <label>
                    <input type="checkbox" class="js-cpt-filter" data-type="<?php
					echo esc_attr( TaxonomyProvider::TAXONOMY_GENRE ); ?>" value="<?php
					echo esc_attr( $genre->slug ); ?>" name="<?php
					echo esc_attr( $genre->slug ); ?>" <?php
					echo ! empty( $current ) && in_array( $genre->slug, $current ) ? 'checked' : ''; ?>>
					<?php
					echo esc_html( $genre->name ); ?>
                </label>
				<?php
			} ?>
        </div>

        <div>
			<?php
			foreach ( $genres as $genre ) { ?>
                <a href="<?php
				echo add_query_arg( TaxonomyProvider::TAXONOMY_GENRE, $genre->slug, $permalink ); ?>" <?php
				echo ! empty( $current ) && ! empty( $current[0] ) && $current[0] === $genre->slug ? 'style="color:red;"' : ''; ?>><?php
					echo esc_html( $genre->name ); ?></a>
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

                <p>Movie description</p>
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
