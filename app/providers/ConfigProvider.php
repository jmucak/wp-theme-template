<?php

namespace wsytesTheme\providers;

class ConfigProvider {
	public static function get_assets_config(): array {
		return array(
			'assets'    => array(
				'wp_enqueue_scripts'          => array(
					'js'  => array(
						'wsytesThemeVendor' => array(
							'path'           => 'dist/vendor.js',
							'version'        => '1.0.0',
							'localize'       => array(
								'object' => 'frontend_rest_object',
								'data'   => array(
									'rest_url'  => get_rest_url( null, RESTProvider::get_api_namespace() ),
									'route_cpt' => RESTProvider::ROUTE_CPT
								),
							),
							'timestamp_bust' => true,
						),
						'wsytesThemeBundle' => array(
							'path'           => 'dist/bundle.js',
							'version'        => '1.0.0',
							'timestamp_bust' => true,
						),
					),
					'css' => array(
						'wsytesThemeMainCSS' => array(
							'path'           => 'dist/style.css',
							'in_footer'      => false,
							'version'        => '1.0.0',
							'timestamp_bust' => true,
						),
					),
				),
				'admin_enqueue_scripts'       => array(
//					'js'  => array(
//						'wsytesThemeAdminBundle' => array(
//							'path'           => 'dist/admin.js',
//							'version'        => '1.0.0',
//							'timestamp_bust' => true,
//						),
//					),
//					'css' => array(
//						'wsytesThemeAdminCSS' => array(
//							'path'           => 'dist/style.css',
//							'in_footer'      => false,
//							'version'        => '1.0.0',
//							'timestamp_bust' => true,
//						),
//					),
				),
				'enqueue_block_editor_assets' => array(
//					'js'  => array(
//						'wsytesThemeEditorBundle' => array(
//							'path'           => 'dist/editor.js',
//							'version'        => '1.0.0',
//							'timestamp_bust' => true,
//						),
//					),
//					'css' => array(
//						'wsytesThemeEditorCSS' => array(
//							'path'           => 'dist/style.css',
//							'in_footer'      => false,
//							'version'        => '1.0.0',
//							'timestamp_bust' => true,
//						),
//					),
				),
			),
			'base_url'  => TEMPLATE_URI . '/static/',
			'base_path' => get_theme_file_path( '/static/' ),
		);
	}

	public static function get_blocks_config(): array {
		$block_provider = new BlockProvider();

		return array(
			'blocks'         => $block_provider->get_blocks(),
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

	public static function get_post_types_config(): array {
		return array(
			CPTProvider::CPT_MOVIE   => CPTProvider::get_movie_args(),
			CPTProvider::CPT_ARTICLE => CPTProvider::get_article_args(),
		);
	}

	public static function get_taxonomies_config(): array {
		return array(
			CPTProvider::TAXONOMY_GENRE       => CPTProvider::get_genre_args(),
			CPTProvider::TAXONOMY_ARTICLE_CAT => CPTProvider::get_article_category_args(),
		);
	}

	public static function get_rest_routes_config(): array {
		$rest_provider = new RESTProvider();
		$cpt_filter_provider = new CPTFilterProvider();

		return array(
			array(
				'namespace' => $rest_provider->get_api_namespace(),
				'route'     => RESTProvider::ROUTE_MOVIE,
				'args'      => $rest_provider->get_movies_route_args()['items'],
			),
			array(
				'namespace' => $rest_provider->get_api_namespace(),
				'route'     => RESTProvider::ROUTE_MOVIE . '/(?P<id>[\d]+)',
				'args'      => $rest_provider->get_movies_route_args()['item'],
			),
			array(
				'namespace' => $rest_provider->get_api_namespace(),
				'route'     => RESTProvider::ROUTE_CPT,
				'args'      => $cpt_filter_provider->get_route_args(),
			),
		);
	}
}