<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\providers\ServiceProvider;
use jmucak\wpImagePack\providers\ImageProvider;

class ThemeServiceProvider {
	public function init(): void {
		// register theme scripts
		add_action( 'init', array( $this, 'register_providers' ) );
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
}