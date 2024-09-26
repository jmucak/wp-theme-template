<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\providers\ServiceProvider;
use jmucak\wpImagePack\providers\ImageProvider;
use wsytesTheme\hooks\CPTControllerHook;

class ThemeServiceProvider {
	public function init(): void {
		// register theme scripts
		add_action( 'init', array( $this, 'register_providers' ) );

		add_action( 'rest_api_init', array( $this, 'register_rest_route' ) );
		$this->register_hooks();


		add_filter( 'query_vars', array( $this, 'register_query_vars' ) );
	}

	public function register_providers(): void {
		ServiceProvider::register_assets( ConfigProvider::get_assets_config() );
		ServiceProvider::register_post_types( ConfigProvider::get_post_types_config() );
		ServiceProvider::register_taxonomies( ConfigProvider::get_taxonomies_config() );
		ServiceProvider::register_blocks( ConfigProvider::get_blocks_config() );

		// Image pack config
		( new ImageProvider( array(
			'image_sizes'            => array(
				'image_200'  => array( 200, 0 ),
				'image_600'  => array( 600, 0 ),
				'image_800'  => array( 800, 0 ),
				'image_1000' => array( 1000, 0 ),
			),
			'deregister_image_sizes' => array( '1536x1536', '2048x2048' ),
		) ) );
	}

	private function register_hooks(): void {
		// Register hooks
		( new CPTControllerHook() )->init();
	}

	public function register_rest_route(): void {
		ServiceProvider::register_rest_routes( ConfigProvider::get_rest_routes_config() );
	}

	public function register_query_vars( array $query_vars ): array {
		$query_vars[] = 'search';
		$query_vars[] = 'relation';

		return $query_vars;
	}
}