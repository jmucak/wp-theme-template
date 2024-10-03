<?php

namespace wsytesTheme\providers;

use jmucak\wpImagePack\providers\ImageProvider;
use jmucak\wpServiceDeregisterPack\DeregisterServiceProvider;
use jmucak\wpServiceRegisterPack\RegisterServiceProvider;
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
		$register_service_provider = new RegisterServiceProvider();
		$register_service_provider->register_assets( AssetsProvider::get_config() );
		$register_service_provider->register_post_types( CPTProvider::get_config()['post_types'] );
		$register_service_provider->register_taxonomies( CPTProvider::get_config()['taxonomies'] );
		$register_service_provider->register_blocks( BlockProvider::get_config() );
		$register_service_provider->register_rest( RESTProvider::get_config() );
		$register_service_provider->register_menus( array(
			MenuHelper::HEADER_MENU_LOCATION => 'Header Menu',
			MenuHelper::FOOTER_MENU_LOCATION => 'Footer Menu',
		) );
		$register_service_provider->register_theme_supports( array( 'title-tag', 'align-wide', 'post-thumbnails', 'editor-styles' ) );

		// Deactivate WP Core services
		$deregister_service_provider = new DeregisterServiceProvider();
		$deregister_service_provider->deactivate_comments();
		$deregister_service_provider->deactivate_wp_embeds();
		$deregister_service_provider->deactivate_wp_emoji();
		$deregister_service_provider->deactivate_comments();
		$deregister_service_provider->deactivate_default_posts();
		$deregister_service_provider->deactivate_wp_scripts();
		$deregister_service_provider->deactivate_short_links();

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