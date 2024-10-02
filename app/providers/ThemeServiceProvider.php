<?php

namespace wsytesTheme\providers;

use jmucak\wpCoreManagerPack\providers\OptimizationProvider;
use jmucak\wpImagePack\providers\ImageProvider;
use jmucak\wpServiceProviderPack\ServiceProvider;
use wsytesTheme\helpers\MenuHelper;
use wsytesTheme\hooks\CPTControllerHook;

class ThemeServiceProvider {
	public function init(): void {
		// register theme scripts
		$this->register_providers();
		$this->register_hooks();
		$this->add_theme_supports();
	}

	public function register_providers(): void {
		$service_provider = new ServiceProvider(array(
			'assets'               => AssetsProvider::get_config(),
			'post_types'           => CPTProvider::get_config()['post_types'],
			'taxonomies'           => CPTProvider::get_config()['taxonomies'],
			'blocks'               => BlockProvider::get_config(),
			'rest_routes'          => RESTProvider::get_config(),
			'menus'                => array(
				MenuHelper::HEADER_MENU_LOCATION => 'Header Menu',
				MenuHelper::FOOTER_MENU_LOCATION => 'Footer Menu',
			),
			'query_vars'           => array( 'relation' ),
			'register_cpt_filter'  => true,
			'rest_route_namespace' => RESTProvider::get_api_namespace(),
		) );
		$service_provider->register_services();

		// Image pack config
		$image_provider = new ImageProvider( array(
			'image_sizes'            => array(
				'image_200'  => array( 200, 0 ),
				'image_600'  => array( 600, 0 ),
				'image_800'  => array( 800, 0 ),
				'image_1000' => array( 1000, 0 ),
			),
			'deregister_image_sizes' => array( '1536x1536', '2048x2048' ),
		) );
		$image_provider->register();

		OptimizationProvider::register( array(
			'deactivate_comments'    => true,
			'deactivate_wp_embeds'   => true,
			'deactivate_wp_emoji'    => true,
			'deactivate_posts'       => true,
			'deactivate_scripts'     => true,
			'deactivate_short_links' => true,
		) );
	}

	private function register_hooks(): void {
		// Register hooks
		( new CPTControllerHook() )->init();
	}

	/**
	 * @url https://developer.wordpress.org/reference/functions/add_theme_support/
	 * @return void
	 */
	private function add_theme_supports(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );

		// Hide wordpress version from the head
		remove_action( 'wp_head', 'wp_generator' );
	}
}