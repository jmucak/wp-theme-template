<?php

namespace wsytesTheme\providers;

use WP_REST_Server;
use wsytesTheme\controllers\CPTController;
use wsytesTheme\controllers\MovieController;

class RESTProvider {
	public const ROUTE_MOVIE = '/movie';
	public const ROUTE_CPT = '/cpt';

	public static function get_api_namespace(): string {
		return 'wsytes/v1';
	}

	public function register(): void {
		register_rest_route( self::get_api_namespace(), self::ROUTE_MOVIE, $this->get_movies_route_args()['items'] );
		register_rest_route( self::get_api_namespace(), self::ROUTE_MOVIE . '/(?P<id>[\d]+)', $this->get_movies_route_args()['item'] );
		register_rest_route( self::get_api_namespace(), self::ROUTE_CPT, array(
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => '__return_true',
			'callback'            => array( new CPTController(), 'get_items' ),
		) );
	}

	private function get_movies_route_args(): array {
		$movie_controller = new MovieController();

		return array(
			'items' => array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'permission_callback' => '__return_true',
					'callback'            => array( $movie_controller, 'get_items' ),
				),
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'permission_callback' => '__return_true',
					'callback'            => array( $movie_controller, 'create_item' ),
					'args'                => array(
						'title' => array(
							'description' => 'Movie title',
							'type'        => 'string'
						),
						'genre' => array(
							'description' => 'Slugs of movie genres',
							'type'        => 'string'
						)
					),
				),
			),
			'item'  => array(
				'args' => array(
					'id' => array(
						'description' => __( 'Unique identifier for the user.' ),
						'type'        => 'integer',
					),
				),
				array(
					'methods'             => WP_REST_Server::READABLE,
					'permission_callback' => '__return_true',
					'callback'            => array( $movie_controller, 'get_item' ),
				),
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'permission_callback' => '__return_true',
					'callback'            => array( $movie_controller, 'update_item' ),
				),
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'permission_callback' => '__return_true',
					'callback'            => array( $movie_controller, 'delete_item' ),
				)
			)
		);
	}
}