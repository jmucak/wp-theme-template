<?php

namespace wsytesTheme\providers;

use jmucak\wpImagePack\providers\ImageProvider;
use jmucak\wpServiceManagerPack\ServiceManager;
use wsytesTheme\helpers\MenuHelper;
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
		// Register WP services

		$service_manager = new ServiceManager();
		$service_manager->register_assets( AssetsProvider::get_config() );
		$service_manager->register_post_types( CPTProvider::get_config()['post_types'] );
		$service_manager->register_taxonomies( CPTProvider::get_config()['taxonomies'] );
		$service_manager->register_blocks( BlockProvider::get_config() );
		$service_manager->register_rest( RESTProvider::get_config() );
		$service_manager->register_menus( array(
			MenuHelper::HEADER_MENU_LOCATION => 'Header Menu',
			MenuHelper::FOOTER_MENU_LOCATION => 'Footer Menu',
		) );
		$service_manager->register_theme_supports( array( 'title-tag', 'align-wide', 'post-thumbnails', 'editor-styles' ) );

		// Deactivate WP Core services
		$service_manager->deactivate_comments();
		$service_manager->deactivate_wp_embeds();
		$service_manager->deactivate_wp_emoji();
		$service_manager->deactivate_comments();
		$service_manager->deactivate_default_posts();
		$service_manager->deactivate_wp_scripts();
		$service_manager->deactivate_short_links();

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
	}

	private function register_hooks(): void {
		// Register hooks
		( new CPTControllerHook() )->init();
	}
}