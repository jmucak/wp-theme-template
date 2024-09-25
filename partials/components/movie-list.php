<?php
/**
 *
 * @var array $movies
 * @var array $genres
 * @var array $current_genres
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
	if ( ! empty( $genres ) ) { ?>
        <div>
            <select name="" id="" data-type="<?php
			echo esc_attr( CPTProvider::TAXONOMY_GENRE ); ?>" class="js-cpt-filter">
				<?php
				foreach ( $genres as $genre ) { ?>
                    <option value="<?php
					echo esc_attr( $genre->slug ); ?>" <?php
					echo ! empty( $current_genres ) && ! empty( $current_genres[0] ) && $current_genres[0] === $genre->slug ? 'selected' : ''; ?>><?php
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
					echo esc_attr( CPTProvider::TAXONOMY_GENRE ); ?>" value="<?php
					echo esc_attr( $genre->slug ); ?>" name="<?php
					echo esc_attr( $genre->slug ); ?>" <?php
					echo ! empty( $current_genres ) && in_array( $genre->slug, $current_genres ) ? 'checked' : ''; ?>>
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
				echo add_query_arg( 'genre', $genre->slug, $permalink ); ?>" <?php
				echo ! empty( $current_genres ) && ! empty( $current_genres[0] ) && $current_genres[0] === $genre->slug ? 'style="color:red;"' : ''; ?>><?php
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
	if ( ! empty( $movies ) ) {
		foreach ( $movies as $movie ) { ?>
            <a href="<?php
			echo get_permalink( $movie ); ?>">
                <h2><?php
					echo $movie->post_title; ?></h2>

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
