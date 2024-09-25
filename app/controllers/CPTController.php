<?php

namespace wsytesTheme\controllers;

use WP_REST_Request;
use WP_REST_Response;

class CPTController {
	/**
	 *
	 * GET
	 * @url wp-json/wsytes/v1/cpt
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


		$output = apply_filters('wsytes_cpt_controller_output', $args);


		return rest_ensure_response( $output );
	}
}