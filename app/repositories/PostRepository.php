<?php

namespace wsytesTheme\repositories;

use WP_Query;
use wsytesTheme\providers\CPTProvider;

class PostRepository extends WP_Query {
	private array $args = array();

	public function __construct( array $args = array() ) {
		$this->args = $args;
		parent::__construct( $args );
	}

	/**
	 *
	 * @return array (WP_POST[])
	 *
	 */
	public function get_recent_posts( int $posts_per_page ): array {
		$this->query( array_merge( $this->args, array(
			'posts_per_page' => $posts_per_page,
			'order'          => 'DESC',
			'orderby'        => 'date',
		) ) );

		return $this->posts;
	}

	/**
	 * @param string $start_date
	 * @param string $end_date
	 * @return array(WP_POST[])
	 *
	 */
	public function get_posts_by_date_range( string $start_date, string $end_date ): array {
		$this->query( array_merge( $this->args, array(
			'date_query' => array(
				array(
					'after'     => $start_date,
					'before'    => $end_date,
					'inclusive' => true,
				)
			)
		) ) );

		return $this->posts;
	}

	/**
	 *
	 * @param array $terms (taxonomy, field, terms)
	 * @return array
	 */
	// Example:
	//		array(
	//			'relation' => 'AND',
	//			array(
	//				'taxonomy' => 'genre',
	//				'field'    => 'slug',
	//				'terms'    => 'horror'
	//			),
	//			array(
	//				'taxonomy' => 'genre',
	//				'field'    => 'slug',
	//				'terms'    => 'comedy'
	//			)
	//		)
	public function get_posts_by_taxonomy( array $terms ): array {
		$this->query( array_merge( $this->args, array(
			'tax_query' => array(
				$terms
			)
		) ) );

		return $this->posts;
	}

	public function parse_args( array $args = array() ): array {
		if ( empty( $args['post_type'] ) ) {
			return array();
		}

		$post_type = $args['post_type'];
		$relation  = '';

		switch ( $post_type ) {
			case 'article':
				$taxonomy = 'article_cat';
				$relation = CPTProvider::RELATION_ARTICLE;
				break;
			case 'movie':
				$taxonomy = 'genre';
				$relation = CPTProvider::RELATION_MOVIE;
				break;
		}


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