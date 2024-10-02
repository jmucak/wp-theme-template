<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\providers\CPTFilterProvider;
use WP_REST_Server;
use wsytesTheme\controllers\MovieController;

class RESTProvider {
	public const ROUTE_MOVIE = 'movie';

	public static function get_api_namespace(): string {
		return 'wsytes/v1/';
	}

	public static function get_config(): array {
		$cpt_filter = new CPTFilterProvider();


		return array(
			array(
				'namespace' => self::get_api_namespace(),
				'route'     => RESTProvider::ROUTE_MOVIE,
				'args'      => self::get_movies_route_args()['items'],
			),
			array(
				'namespace' => self::get_api_namespace(),
				'route'     => RESTProvider::ROUTE_MOVIE . '/(?P<id>[\d]+)',
				'args'      => self::get_movies_route_args()['item'],
			),
			array(
				'namespace' => self::get_api_namespace(),
				'route'     => CPTFilterProvider::ROUTE_CPT,
				'args'      => $cpt_filter->get_route_args(),
			)
		);
	}

	private static function get_movies_route_args(): array {
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