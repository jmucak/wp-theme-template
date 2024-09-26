<?php

namespace wsytesTheme\controllers;

use WP_REST_Request;
use WP_REST_Response;
use wsytesTheme\factories\CPTFactory;
use wsytesTheme\repositories\PostRepository;

class CPTController {
	/**
	 *
	 * GET
	 * @url wp-json/wsytes/v1/cpt
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 * @example ?post_type=movie&view=html&genre=action,comedy&paged=1&posts_per_page=2&relation=and
	 *
	 */
	public function get_items( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_query_params();

		if ( empty( $params['post_type'] ) ) {
			return rest_ensure_response( array() );
		}

		$service = CPTFactory::get_instance()->get_service( $params['post_type'] );

		if ( empty( $service ) ) {
			return rest_ensure_response( array() );
		}

		$repository = new PostRepository();
		$args = $repository->parse_args( $params );

		if ( empty( $args['view'] ) || $args['view'] !== 'html' ) {
			$posts = $repository->query($args);
			return rest_ensure_response( $posts );
		}

		$response = array(
			'html' => $service->get_output( $args ),
			'url'  => $service->get_url( $args ),
		);

		return rest_ensure_response( $response );
	}
}