<?php

namespace wsytesTheme\hooks;

use wsytesTheme\factories\CPTFactory;
use wsytesTheme\providers\CPTProvider;
use wsytesTheme\repositories\PostRepository;

class CPTControllerHook {
	public function init(): void {
		add_filter( 'wsytes_cpt_controller_args', array( $this, 'get_cpt_controller_args' ), 10, 2 );
		add_filter( 'wsytes_cpt_controller_output', array( $this, 'get_cpt_controller_output' ), 10, 3 );
	}

	public function get_cpt_controller_args( array $args, PostRepository $repository ): array {
		return match ( $args['post_type'] ) {
			CPTProvider::CPT_MOVIE => $repository->parse_args( array_merge( $args, array(
				'taxonomy' => CPTProvider::TAXONOMY_GENRE,
				'relation' => CPTProvider::RELATION_MOVIE
			) ) ),
			CPTProvider::CPT_ARTICLE => $repository->parse_args( array_merge( $args, array(
				'taxonomy' => CPTProvider::TAXONOMY_ARTICLE_CAT,
				'relation' => CPTProvider::RELATION_ARTICLE
			) ) ),
			default => $args,
		};
	}

	public function get_cpt_controller_output( ?array $posts, array $args, PostRepository $repository ): string|array {
		$service = CPTFactory::get_service( $args['post_type'] );

		if ( $service ) {
			return $service->get_output( $posts, $args, $repository );
		}

		return $posts ?? array();
	}
}