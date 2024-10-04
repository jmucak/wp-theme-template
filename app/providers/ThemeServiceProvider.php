<?php

namespace wsytesTheme\providers;

use jmucak\wpImagePack\providers\ImageProvider;
use jmucak\wpServiceDeregisterPack\DeregisterServiceProvider;
use wsytesTheme\hooks\CPTControllerHook;

class ThemeServiceProvider {
	public function init(): void {
		// register theme scripts
		$this->register_providers();
		$this->register_hooks();

		// Hide wordpress version from the head
		remove_action( 'wp_head', 'wp_generator' );
	}

	public function register_providers(): void {
		add_action( 'rest_api_init', array( new RESTProvider(), 'register' ) );

		( new AssetProvider() )->register();
		( new BlockProvider() )->register();
		( new PostTypeProvider() )->register();
		( new TaxonomyProvider() )->register();
		( new MenuProvider() )->register();

		add_theme_support( 'title-tag' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );

		// Deactivate WP Core services
		$deregister_service_provider = new DeregisterServiceProvider();
		$deregister_service_provider->deactivate_comments();
		$deregister_service_provider->deactivate_wp_embeds();
		$deregister_service_provider->deactivate_wp_emoji();
//		$deregister_service_provider->deactivate_default_posts();
		$deregister_service_provider->deactivate_wp_scripts();
		$deregister_service_provider->deactivate_short_links();

		// Image pack config
		( new ImageProvider( array(
			'image_sizes'            => array(
				'image_200'  => array( 200, 0 ),
				'image_600'  => array( 600, 0 ),
				'image_800'  => array( 800, 0 ),
				'image_1000' => array( 1000, 0 ),
			),
			'deregister_image_sizes' => array( '1536x1536', '2048x2048' ),
		) ) )->register();
	}

	private function register_hooks(): void {
		// Register hooks
		( new CPTControllerHook() )->init();
	}
}