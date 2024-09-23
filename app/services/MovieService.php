<?php

namespace wsytesTheme\services;

use WP_Post;
use wsytesTheme\providers\CPTProvider;
use wsytesTheme\repositories\TaxonomyRepository;

class MovieService {
	public function get_genres( ?string $genre_slug = null ): array {
		if ( empty( $genre_slug ) ) {
			return array();
		}

		$repository = new TaxonomyRepository();

		if ( ! str_contains( $genre_slug, ',' ) ) {
			$genre_object = $repository->get_term( $genre_slug, CPTProvider::TAXONOMY_GENRE );

			return ! empty( $genre_object ) && CPTProvider::TAXONOMY_GENRE === $genre_object->taxonomy ? array( $genre_object->term_id ) : array();
		}

		$genre_explode = explode( ',', $genre_slug );

		// Return only terms that exists
		return array_filter( $genre_explode, function ( $genre ) use ( $repository ) {
			$genre_object = $repository->get_term( $genre, CPTProvider::TAXONOMY_GENRE );

			if ( ! empty( $genre_object ) && CPTProvider::TAXONOMY_GENRE === $genre_object->taxonomy ) {
				return $genre_object->term_id;
			}
		} );
	}

	public function create_movie( array $post_data, array $genres ): array {
		$post_id = wp_insert_post( $post_data );

		if ( ! empty( $post_id ) ) {
			$term_ids = wp_set_object_terms( $post_id, $genres, CPTProvider::TAXONOMY_GENRE );
		}

		return array(
			'post_id'  => $post_id,
			'term_ids' => $term_ids ?? null,
			'genres'   => $genres,
		);
	}

	public function update_movie( int $post_id, array $data ): array {
		if ( ! empty( $data['genre'] ) ) {
			$term_ids = wp_set_object_terms( $post_id, $data['genre'], CPTProvider::TAXONOMY_GENRE );
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

	public function delete_movie( int $post_id ): false|null|WP_Post {
		return wp_delete_post( $post_id );
	}
}