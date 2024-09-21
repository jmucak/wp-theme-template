<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\providers\AssetProvider;
use jmucak\wpHelpersPack\providers\BlockProvider;
use jmucak\wpHelpersPack\providers\CPTProvider;
use jmucak\wpImagePack\providers\ImageProvider;
use wsytesTheme\services\AssetService;
use wsytesTheme\services\BlockService;
use wsytesTheme\services\CPTSettingsService;

class ThemeServiceProvider {
	public function init(): void {
		$this->register_providers();
	}

	private function register_providers(): void {
		// register theme scripts
		add_action( 'wp_enqueue_scripts', array( new AssetProvider( new AssetService() ), 'register' ) );

		( new BlockProvider() )->register( new BlockService() );
		( new CPTProvider() )->register( new CPTSettingsService() );

		// Image pack config
		( new ImageProvider( array(
			'image_sizes'            => array(
				'image_200'  => array( 200, 0 ),
				'image_800'  => array( 800, 0 ),
				'image_1000' => array( 1000, 0 ),
			),
			'deregister_image_sizes' => array('1536x1536', '2048x2048'),
		) ) );
	}
}