<?php

namespace wsytesTheme\services;

use WP_Post;
use WP_Query;
use wsytesTheme\interfaces\CPTFilterServiceInterface;
use wsytesTheme\providers\TaxonomyProvider;
use wsytesTheme\repositories\TaxonomyRepository;

class MovieService implements CPTFilterServiceInterface {
	/**
	 * Get genre objects by string (string can be separated with ",")
	 * @param string|null $genre_slug
	 * @param TaxonomyRepository $repository
	 * @return array
	 */
	public function get_genres( ?string $genre_slug, TaxonomyRepository $repository ): array {
		if ( empty( $genre_slug ) ) {
			return array();
		}

		if ( ! str_contains( $genre_slug, ',' ) ) {
			$genre_object = $repository->get_term( $genre_slug, TaxonomyProvider::TAXONOMY_GENRE );

			return ! empty( $genre_object ) && TaxonomyProvider::TAXONOMY_GENRE === $genre_object->taxonomy ? array( $genre_object->term_id ) : array();
		}

		$genre_explode = explode( ',', $genre_slug );

		// Return only terms that exists
		return array_filter( $genre_explode, function ( $genre ) use ( $repository ) {
			$genre_object = $repository->get_term( $genre, TaxonomyProvider::TAXONOMY_GENRE );

			if ( ! empty( $genre_object ) && TaxonomyProvider::TAXONOMY_GENRE === $genre_object->taxonomy ) {
				return $genre_object->term_id;
			}
		} );
	}

	/**
	 * Add movie to database
	 *
	 * @param array $post_data
	 * @param array $genres
	 * @return array
	 */
	public function create_movie( array $post_data, array $genres ): array {
		$post_id = wp_insert_post( $post_data );

		if ( ! empty( $post_id ) ) {
			$term_ids = wp_set_object_terms( $post_id, $genres, TaxonomyProvider::TAXONOMY_GENRE );
		}

		return array(
			'post_id'  => $post_id,
			'term_ids' => $term_ids ?? null,
			'genres'   => $genres,
		);
	}

	/**
	 *
	 * Update movie in database
	 *
	 * @param int $post_id
	 * @param array $data
	 * @return array
	 */
	public function update_movie( int $post_id, array $data ): array {
		if ( ! empty( $data['genre'] ) ) {
			$term_ids = wp_set_object_terms( $post_id, $data['genre'], TaxonomyProvider::TAXONOMY_GENRE );
		}

		if ( ! empty( $data['title'] ) ) {
			$post_update = wp_update_post( array(
				'ID'         => $post_id,
				'post_title' => $data['title']
			) );
		}

		return array(
			'terms_ids'   => $term_ids ?? false,
			'post_update' => $post_update ?? false,
			'post_id'     => $post_id,
		);
	}

	/**
	 * Delete movie from db
	 *
	 * @param int $post_id
	 * @return false|WP_Post|null
	 *
	 */
	public function delete_movie( int $post_id ): false|null|WP_Post {
		return wp_delete_post( $post_id );
	}

	public function get_output( array $posts, array $args, WP_Query $query ): string|array {
		$taxonomy_repository = new TaxonomyRepository();

		$args['genres'] = $taxonomy_repository->get_terms( TaxonomyProvider::TAXONOMY_GENRE );

		return array(
			'html' => get_partial( 'components/movie-list', $args, true ),
			'url'  => sprintf( '%spage/%s/%s', $args['permalink'], $args['paged'], $args['query'] )
		);
	}
}