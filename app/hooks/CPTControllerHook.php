<?php

namespace wsytesTheme\hooks;

use wsytesTheme\factories\CPTFactory;
use wsytesTheme\repositories\PostRepository;

class CPTControllerHook {
	public function init(): void {
		add_filter( 'wsytes_cpt_controller_args', array( $this, 'get_cpt_controller_args' ), 10, 1 );
		add_filter( 'wsytes_cpt_controller_output', array( $this, 'get_cpt_controller_output' ), 10, 3 );
	}

	public function get_cpt_controller_args( array $args ): array {
		$service = CPTFactory::get_instance()->get_service( $args['post_type'] );

		if ( $service ) {
			return $service->parse_args( $args );
		}

		return $args;
	}

	public function get_cpt_controller_output( array $posts, array $args, PostRepository $repository ): string|array {
		$service = CPTFactory::get_instance()->get_service( $args['post_type'] );

		if ( $service ) {
			return $service->get_output( $repository, $args['view'] );
		}

		return $posts;
	}
}