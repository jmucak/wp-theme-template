<?php

namespace wsytesTheme\providers;

use wsytesTheme\services\blocks\MovieListBlockService;
use wsytesTheme\services\BlockService;

class BlockProvider {
	public const CATEGORY = 'wsytes-blocks';
	private const MODE = 'edit';

	public function register(): void {
		add_action( 'acf/init', array( $this, 'register_blocks' ) );

		add_filter( 'allowed_block_types_all', array( $this, 'filter_allowed_blocks' ) );
//		add_filter( 'block_categories_all', array( $this, 'filter_block_categories' ) );
	}

	public function register_blocks(): void {
		acf_register_block_type( $this->get_test_block() );
		acf_register_block_type( $this->get_movie_list_block() );
	}

	// Add new block
	private function get_test_block(): array {
		return array(
			'name'            => 'test-block',
			'title'           => 'Test Block',
			'description'     => 'Test Block',
			'category'        => self::CATEGORY,
			'mode'            => self::MODE,
			'icon'            => null,
			'keywords'        => array( 'test' ),
			'post_types'      => array( 'post', 'page' ),
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'preview_image_help' => TEMPLATE_URI . 'static/blocks/test-block.png'
					)
				)
			),
			'enqueue_style'   => '',
			'enqueue_script'  => '',
			'enqueue_assets'  => '',
			'render_callback' => array( new BlockService(), 'get_view' )
		);
	}

	private function get_movie_list_block(): array {
		return array(
			'name'            => 'movie-list-block',
			'title'           => 'Movie List Block',
			'description'     => 'Movie List Block',
			'category'        => self::CATEGORY,
			'mode'            => self::MODE,
			'icon'            => null,
			'keywords'        => array( 'movie' ),
			'post_types'      => array( 'page' ),
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'preview_image_help' => TEMPLATE_URI . 'static/blocks/test-block.png'
					)
				)
			),
			'supports'        => array(
				'multiple' => false, // You can add only 1 block per page
			),
			'enqueue_style'   => '',
			'enqueue_script'  => '',
			'enqueue_assets'  => '',
			'render_callback' => array( new MovieListBlockService(), 'get_view' )
		);
	}
	// End Add new block


	// Filter default blocks
	public function filter_allowed_blocks( bool|array $allowed_block_types ): array {
		$filtered_acf_arrays = array_filter( get_dynamic_block_names(), fn( $block_name ) => str_contains( $block_name, 'acf' ) );

		return array_merge( $filtered_acf_arrays, array(
			'core/column',
			'core/columns',
			'core/block',
			'core/paragraph',
			'core/heading',
			'core/image',
			'core/gallery',
		) );
	}

	// add custom block categories
	public function filter_block_categories( array $categories ): array {
		return array_merge(  array(
			'slug'  => self::CATEGORY,
			'title' => 'Wsytes Blocks'
		) );
	}
}