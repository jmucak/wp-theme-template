<?php

namespace wsytesTheme\hooks;

use WP_Query;
use wsytesTheme\factories\CPTFactory;
use wsytesTheme\providers\CPTProvider;

class CPTControllerHook {
	public function init(): void {
		add_filter( 'wsytes_cpt_controller_args', array( $this, 'get_cpt_controller_args' ), 10, 1 );
		add_filter( 'wsytes_cpt_controller_output', array( $this, 'get_cpt_controller_output' ), 10, 1 );
	}

	public function get_cpt_controller_args( array $args ): array {
		return match ( $args['post_type'] ) {
			CPTProvider::CPT_MOVIE => $this->parse_args( array_merge( $args, array(
				'taxonomy' => CPTProvider::TAXONOMY_GENRE,
				'relation' => CPTProvider::RELATION_MOVIE
			) ) ),
			default => $args,
		};
	}

	public function get_cpt_controller_output( array $args ): string|array {
		$service           = CPTFactory::get_service( $args['post_type'] );
		$query             = new WP_Query( $args );
		$args['items']     = $query->posts;
		$args['max_pages'] = $query->max_num_pages;

		if ( $service ) {
			return $service->get_output( $query->posts, $args, $query );
		}

		return $query->posts;
	}

	public function parse_args( array $args = array() ): array {
		if ( empty( $args['post_type'] ) ) {
			return array();
		}

		$post_type = $args['post_type'];
		$relation  = ! empty( $args['relation'] ) ? $args['relation'] : '';
		$taxonomy  = ! empty( $args['taxonomy'] ) ? $args['taxonomy'] : null;

		$page         = ! empty( $args['paged'] ) ? $args['paged'] : get_query_var( 'paged' );
		$default_args = array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => 2,
			'paged'          => ! empty( $page ) ? $page : 1,
			'view'           => 'html',
			's'              => get_query_var( 'search', '' ),
			'relation'       => $relation,
			'permalink'      => get_permalink(),
		);

		if ( ! empty( $taxonomy ) ) {
			$default_args[ $taxonomy ] = get_query_var( $taxonomy, '' );
		}

		$args = array_merge( $default_args, $args );

		$has_genre    = ! empty( $args[ $taxonomy ] ) && str_contains( $args[ $taxonomy ], '' );
		$has_relation = ! empty( $args['relation'] ) && 'and' === strtolower( $args['relation'] );

		// If there is genre and has "AND" relation do custom taq_query
		if ( $has_genre && $has_relation ) {
			$terms = explode( ',', $args[ $taxonomy ] );
			$tax   = array();
			foreach ( $terms as $term ) {
				$tax[] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => array( $term ),
				);
			}

			$args['tax_query'] = array(
				'relation' => 'AND',
				$tax
			);

			unset( $args[ $taxonomy ] );
		}

		// get current terms
		$current = array();
		if ( ! empty( $args['tax_query'] ) && ! empty( $args['tax_query'][0] ) ) {
			foreach ( $args['tax_query'][0] as $term ) {
				$current[] = $term['terms'][0];
			}
		} elseif ( ! empty( $args[ $taxonomy ] ) ) {
			$terms = str_contains( $args[ $taxonomy ], ',' ) ? explode( ',', $args[ $taxonomy ] ) : $args[ $taxonomy ];

			if ( is_string( $terms ) ) {
				$current[] = $terms;
			} else {
				$current = $terms;
			}
		}

		if ( ! empty( $current ) ) {
			$query = http_build_query( array(
				$taxonomy => implode( ',', $current ),
			) );
		}

		$args['current'] = $current;
		$args['query']   = ! empty( $query ) ? '?' . $query : '';

		return $args;
	}
}