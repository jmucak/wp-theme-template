<?php

namespace wsytesTheme\repositories;

use WP_Query;

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
}