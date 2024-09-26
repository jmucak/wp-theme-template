<?php

namespace wsytesTheme\services;

use WP_Post;
use wsytesTheme\interfaces\CPTFilterServiceInterface;
use wsytesTheme\providers\CPTProvider;
use wsytesTheme\repositories\PostRepository;
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
			$term_ids = wp_set_object_terms( $post_id, $genres, CPTProvider::TAXONOMY_GENRE );
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

	public function parse_args( array $args = array() ): array {
		$page         = ! empty( $args['paged'] ) ? $args['paged'] : get_query_var( 'paged' );
		$default_args = array(
			'post_type'      => CPTProvider::CPT_MOVIE,
			'post_status'    => 'publish',
			'posts_per_page' => 2,
			'paged'          => ! empty( $page ) ? $page : 1,
			'view'           => 'html',
			'genre'          => get_query_var( 'genre', '' ),
			's'              => get_query_var( 'search', '' ),
			'relation'       => CPTProvider::RELATION_MOVIE,
			'permalink'      => get_permalink(),
		);

		$args = array_merge( $default_args, $args );

		$has_genre    = ! empty( $args[ CPTProvider::TAXONOMY_GENRE ] ) && str_contains( $args[ CPTProvider::TAXONOMY_GENRE ], '' );
		$has_relation = ! empty( $args['relation'] ) && 'and' === strtolower( $args['relation'] );

		// If there is genre and has "AND" relation do custom taq_query
		if ( $has_genre && $has_relation ) {
			$genres = explode( ',', $args[ CPTProvider::TAXONOMY_GENRE ] );
			$tax    = array();
			foreach ( $genres as $genre ) {
				$tax[] = array(
					'taxonomy' => CPTProvider::TAXONOMY_GENRE,
					'field'    => 'slug',
					'terms'    => array( $genre ),
				);
			}

			$args['tax_query'] = array(
				'relation' => 'AND',
				$tax
			);

			unset( $args[ CPTProvider::TAXONOMY_GENRE ] );
		}

		// get current genre/s
		$current_genres = array();
		if ( ! empty( $args['tax_query'] ) && ! empty( $args['tax_query'][0] ) ) {
			foreach ( $args['tax_query'][0] as $tax_genre ) {
				$current_genres[] = $tax_genre['terms'][0];
			}
		} elseif ( ! empty( $args['genre'] ) ) {
			$tax_genres = str_contains( $args['genre'], ',' ) ? explode( ',', $args['genre'] ) : $args['genre'];

			if ( is_string( $tax_genres ) ) {
				$current_genres[] = $tax_genres;
			} else {
				$current_genres = $tax_genres;
			}
		}

		if ( ! empty( $current_genres ) ) {
			$query = http_build_query( array(
				'genre' => implode( ',', $current_genres ),
			) );
		}

		return array_merge( $args, array(
			'current_genres' => $current_genres,
			'query'          => ! empty( $query ) ? '?' . $query : '',
		) );
	}

	public function get_url( array $args ): string {
		return sprintf( '%spage/%s/%s', $args['permalink'], $args['paged'], $args['query'] );
	}

	public function get_output( array $args ): string {
		$repository = new PostRepository($args);
		$taxonomy_repository = new TaxonomyRepository();
		$genres              = $taxonomy_repository->get_terms( CPTProvider::TAXONOMY_GENRE );

		$args = array_merge( $args, array(
			'genres'    => $genres,
			'max_pages' => $repository->max_num_pages,
			'movies'    => $repository->posts,
		) );

		return get_partial( 'components/movie-list', $args, true );
	}
}