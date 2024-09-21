<?php

namespace wsytesTheme\providers;

use wsytesTheme\services\BlockService;

class ConfigProvider {
	public static function get_assets_config(): array {
		return array(
			'js'        => array(
				'wsytesThemeVendor' => array(
					'path'           => 'dist/vendor.js',
					'version'        => '1.0.0',
					'localize'       => array(
						'object' => 'frontend_rest_object',
						'data'   => array(),
					),
					'timestamp_bust' => true,
				),
				'wsytesThemeBundle' => array(
					'path'           => 'dist/bundle.js',
					'version'        => '1.0.0',
					'timestamp_bust' => true,
				),
			),
			'css'       => array(
				'wsytesThemeMainCSS' => array(
					'path'           => 'dist/style.css',
					'in_footer'      => false,
					'version'        => '1.0.0',
					'timestamp_bust' => true,
				),
			),
			'base_url'  => TEMPLATE_URI . '/static/',
			'base_path' => get_theme_file_path( '/static/' ),
		);
	}

	public static function get_blocks_config( BlockService $block_service ): array {
		return array(
			'blocks'         => array(
				$block_service->get_test_block(),
			),
			'default_blocks' => array(
				'core/column',
				'core/columns',
				'core/block',
				'core/paragraph',
				'core/heading',
				'core/image',
				'core/gallery',
				'core/shortcode',
			),
			'categories'     => array(
				array(
					'slug'  => $block_service->category,
					'title' => 'Wsytes Blocks'
				)
			),
		);
	}

	public static function get_post_types_config(): array {
		return array(
			CPTProvider::CPT_MOVIE => CPTProvider::get_movie_args(),
		);
	}

	public static function get_taxonomies_config(): array {
		return array(
			CPTProvider::TAXONOMY_GENRE => CPTProvider::get_genre_args(),
		);
	}
}