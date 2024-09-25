<?php
/**
 *
 * @var array $movies
 * @var int $pages
 *
 */

if ( ! empty( $movies ) ) { ?>
    <div>
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
    </div>
<?php
}