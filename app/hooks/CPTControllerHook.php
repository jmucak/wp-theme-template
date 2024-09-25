<?php

namespace wsytesTheme\hooks;

use wsytesTheme\repositories\PostRepository;

class CPTControllerHook {
	public function init(): void {
		add_filter( 'wsytes_cpt_controller_args', array( $this, 'get_cpt_controller_args' ), 10, 1 );
		add_filter( 'wsytes_cpt_controller_output', array( $this, 'get_cpt_controller_output' ), 10, 3 );
	}

	public function get_cpt_controller_args( array $args ): array {
		if ( ! empty( $args['relation'] ) && 'and' === strtolower( $args['relation'] ) && ! empty( $args['genre'] ) && str_contains( $args['genre'],
				'' ) ) {
			$genres = explode( ',', $args['genre'] );
			$tax    = array();
			foreach ( $genres as $genre ) {
				$tax[] = array(
					'taxonomy' => 'genre',
					'field'    => 'slug',
					'terms'    => array( $genre ),
				);
			}

			$args['tax_query'] = array(
				'relation' => 'AND',
				$tax
			);

			unset( $args['genre'] );
		}

		return $args;
	}

	public function get_cpt_controller_output( array $posts, array $args, PostRepository $repository ): string|array {
		if ( 'html' === $args['view'] ) {
			return get_partial( 'components/movie-list', array(
				'movies' => $posts,
			), true );
		}


		return $posts;
	}
}