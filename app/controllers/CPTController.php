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
	 * @example ?post_type=movie$view=html&genre=action,comedy&paged=1&posts_per_page=2&relation=and
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function get_items( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_query_params();

		if(empty($params['post_type'])) {
			return rest_ensure_response(array());
		}

		$args = apply_filters('wsytes_cpt_controller_args', $params);


		$repository = new PostRepository($args);
		$output = apply_filters('wsytes_cpt_controller_output', $repository->posts, $args, $repository);


		return rest_ensure_response( $output );
	}
}