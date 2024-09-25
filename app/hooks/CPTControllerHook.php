<?php

namespace wsytesTheme\hooks;

use wsytesTheme\repositories\PostRepository;

class CPTControllerHook {
	public function init(): void {
		add_filter( 'wsytes_cpt_controller_args', array( $this, 'get_cpt_controller_args' ), 10, 1 );
		add_filter( 'wsytes_cpt_controller_output', array( $this, 'get_cpt_controller_output' ), 10, 1 );
	}

	public function get_cpt_controller_args( array $args ): array {
		if ( ! empty( $args['paged'] ) ) {
			$args['posts_per_page'] = 1;
		}

		return $args;
	}

	public function get_cpt_controller_output( array $args ): string|array {
		$view       = $args['view'] ?? 'list';
		$repository = new PostRepository( $args );

		if ( 'html' === $view ) {
			return get_partial( 'components/movie-list', array(
				'movies' => $repository->posts,
			), true );
		}


		return array(
			'items' => $repository->posts,
			'pages' => $repository->max_num_pages,
		);
	}
}