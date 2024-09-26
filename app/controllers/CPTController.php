<?php

namespace wsytesTheme\controllers;

use WP_REST_Request;
use WP_REST_Response;
use wsytesTheme\repositories\PostRepository;

class CPTController {
	/**
	 *
	 * GET
	 * @url wp-json/wsytes/v1/cpt
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 * @example ?post_type=article&view=html&article_cat=blog,news&paged=1&posts_per_page=2
	 *
	 */
	public function get_items( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_query_params();

		if ( empty( $params['post_type'] ) ) {
			return rest_ensure_response( array() );
		}

		$repository = new PostRepository();
		$args       = apply_filters( 'wsytes_cpt_controller_args', $params, $repository );

		$output = apply_filters( 'wsytes_cpt_controller_output', $repository->query($args), $args, $repository );

		return rest_ensure_response( $output );
	}
}