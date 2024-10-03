<?php

namespace wsytesTheme\providers;

use wsytesTheme\services\blocks\MovieListBlockService;
use wsytesTheme\services\BlockService;

class BlockProvider {
	public const CATEGORY = 'wsytes-blocks';
	private const MODE = 'mode';

	public static function get_config(): array {
		return array(
			'type'           => 'acf',
			'blocks'         => array(
				self::get_test_block(),
				self::get_movie_list_block(),
			),
			'default_blocks' => array(
				'core/column',
				'core/columns',
				'core/block',
				'core/paragraph',
				'core/heading',
				'core/image',
				'core/gallery',
			),
			'categories'     => array(
				array(
					'slug'  => BlockProvider::CATEGORY,
					'title' => 'Wsytes Blocks'
				)
			),
		);
	}

	// Add new block
	private static function get_test_block(): array {
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

	private static function get_movie_list_block(): array {
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
}