<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\hooks\BlockSettingsEvent;
use jmucak\wpHelpersPack\providers\AssetProvider;
use jmucak\wpHelpersPack\providers\ServiceProvider;
use jmucak\wpImagePack\providers\ImageProvider;
use wsytesTheme\services\BlockService;

class ThemeServiceProvider {
	public function init(): void {
		// register theme scripts
		add_action( 'wp_enqueue_scripts', array( new AssetProvider( ConfigProvider::get_assets_config() ), 'register' ) );

		add_action( 'init', array( $this, 'register_providers' ) );
	}

	public function register_providers(): void {
		$service_provider = new ServiceProvider();
		$service_provider->register_post_types( ConfigProvider::get_post_types_config() );
		$service_provider->register_taxonomies( ConfigProvider::get_taxonomies_config() );

		$block_config = ConfigProvider::get_blocks_config( new BlockService() );
		$service_provider->register_blocks( $block_config['blocks'] );
		( new BlockSettingsEvent( $block_config ) );

		// Image pack config
		( new ImageProvider( array(
			'image_sizes'            => array(
				'image_200'  => array( 200, 0 ),
				'image_800'  => array( 800, 0 ),
				'image_1000' => array( 1000, 0 ),
			),
			'deregister_image_sizes' => array( '1536x1536', '2048x2048' ),
		) ) );
	}
}