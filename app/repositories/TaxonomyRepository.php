<?php

namespace wsytesTheme\repositories;

use WP_Post;
use WP_Term;

class TaxonomyRepository {
	public function get_term( int|WP_Term|string $term, string $taxonomy ): ?WP_Term {
		$_term = is_string( $term ) ? get_term_by( 'slug', $term, $taxonomy ) : get_term( $term, $taxonomy );

		if ( empty( $_term ) || is_wp_error( $_term ) ) {
			return null;
		}

		return $_term;
	}

	public function get_terms( string $taxonomy, bool $hide_empty = false ): array {
		$_terms = get_terms( array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => $hide_empty,
		) );

		return ! empty( $_terms ) && !is_wp_error($_terms) ? $_terms : array();
	}

	public function get_terms_by_post( int|WP_Post $post, string $taxonomy ): array {
		$_terms = get_the_terms( $post, $taxonomy );

		return ! empty( $_terms ) ? $_terms : array();
	}
}