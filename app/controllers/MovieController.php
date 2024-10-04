<?php

namespace wsytesTheme\controllers;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use wsytesTheme\providers\PostTypeProvider;
use wsytesTheme\repositories\PostRepository;
use wsytesTheme\repositories\TaxonomyRepository;
use wsytesTheme\services\MovieService;

class MovieController {

	/**
	 *
	 * GET
	 * @url wp-json/wsytes/v1/movie
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function get_items( WP_REST_Request $request ): WP_REST_Response {
		$repository = new PostRepository( array(
			'post_type'      => PostTypeProvider::CPT_MOVIE,
			'post_status'    => 'publish',
			'posts_per_page' => - 1
		) );

		$response = array(
			'items' => $repository->posts,
			'pages' => $repository->max_num_pages
		);

		return rest_ensure_response( $response );
	}

	/**
	 * POST
	 * @url wp-json/wsytes/v1/movie
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public function create_item( WP_REST_Request $request ): WP_Error|WP_REST_Response {
		$body_params = $request->get_body_params();

		if ( empty( $body_params['title'] ) ) {
			return new WP_Error( 400, 'Movie title is missing' );
		}

		if ( empty( $body_params['genre'] ) ) {
			return new WP_Error( 400, 'Movie genre is missing', array(
				'examples' => array( 'horror', 'comedy', 'drama' )
			) );
		}

		$movie_service = new MovieService();
		$genres        = $movie_service->get_genres( $body_params['genre'], new TaxonomyRepository() );
		$response      = $movie_service->create_movie( array(
			'post_type'   => PostTypeProvider::CPT_MOVIE,
			'post_status' => 'publish',
			'post_title'  => sanitize_text_field( $body_params['title'] )
		), $genres );

		return rest_ensure_response( $response );
	}

	/**
	 *
	 * GET
	 * @url wp-json/wsytes/v1/movie/{id}
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item( WP_REST_Request $request ): WP_Error|WP_REST_Response {
		$post_id = $request->get_param( 'id' );

		if ( empty( $post_id ) ) {
			return new WP_Error( 400, 'Movie id is missing' );
		}

		return rest_ensure_response( get_post( $post_id ) );
	}

	/**
	 *
	 * @url wp-json/wsytes/v1/movie/{id}
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( WP_REST_Request $request ): WP_Error|WP_REST_Response {
		$post_id = $request->get_param( 'id' );

		if ( empty( $post_id ) ) {
			return new WP_Error( 400, 'Movie id is missing' );
		}

		$movie = get_post( $post_id );

		// check if post exits and if post is movie
		if ( empty( $movie ) || is_wp_error( $movie ) || PostTypeProvider::CPT_MOVIE !== $movie->post_type ) {
			return new WP_Error( 400, 'Movie does not exists' );
		}

		$body_params   = $request->get_body_params();
		$movie_service = new MovieService();

		$response = $movie_service->update_movie( $post_id, array(
			'genre' => $movie_service->get_genres( $body_params['genre'], new TaxonomyRepository() ),
			'title' => sanitize_text_field( $body_params['title'] )
		) );

		return rest_ensure_response( $response );
	}


	/**
	 *
	 * @url wp-json/wsytes/v1/movie/{id}
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public function delete_item( WP_REST_Request $request ): WP_Error|WP_REST_Response {
		$post_id = $request->get_param( 'id' );

		if ( empty( $post_id ) ) {
			return new WP_Error( 400, 'Movie id is missing' );
		}

		$movie = get_post( $post_id );

		// check if post exits and if post is movie
		if ( empty( $movie ) || is_wp_error( $movie ) || PostTypeProvider::CPT_MOVIE !== $movie->post_type ) {
			return new WP_Error( 400, 'Movie does not exists' );
		}

		$movie_service = new MovieService();

		return rest_ensure_response( $movie_service->delete_movie( $post_id ) );
	}
}