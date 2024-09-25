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
 * @var string $url
 *
 */

if ( ! empty( $movies ) ) { ?>
    <div>
		<?php
		if ( ! empty( $genres ) ) { ?>
            <div>
                <select name="" id="" data-taxonomy="genre">
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
                        <input type="checkbox" value="<?php
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
					echo add_query_arg( 'genre', $genre->slug, get_permalink() ); ?>" <?php
					echo ! empty( $current_genres ) && ! empty( $current_genres[0] ) && $current_genres[0] === $genre->slug ? 'style="color:red;"' : ''; ?>><?php
						echo esc_html( $genre->name ); ?></a>
					<?php
				} ?>
            </div>
			<?php
		} ?>

        <form action="">
            <label for="search"></label><input type="search" name="search" id="search">
        </form>

		<?php
		foreach ( $movies as $movie ) { ?>
            <a href="<?php
			echo get_permalink( $movie ); ?>">
                <h2><?php
					echo $movie->post_title; ?></h2>

                <p>Movie description</p>
            </a>
			<?php
		} ?>


		<?php
		get_partial( 'components/pagination', array(
			'current_page' => $paged,
			'max_pages'    => $max_pages,
			'query'        => $query,
			'url'          => $url,
		) );
		?>
    </div>
	<?php
}