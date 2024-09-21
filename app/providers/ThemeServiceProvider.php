<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\providers\AssetProvider;
use jmucak\wpHelpersPack\providers\BlockProvider;
use jmucak\wpHelpersPack\providers\CPTProvider;
use jmucak\wpOnDemandImages\services\ImageService;
use wsytesTheme\services\AssetService;
use wsytesTheme\services\BlockService;
use wsytesTheme\services\CPTSettingsService;

class ThemeServiceProvider {
	public function init(): void {
		$this->register_wp_helpers_pack_providers();
	}

	private function register_wp_helpers_pack_providers(): void {
		// register theme scripts
		add_action( 'wp_enqueue_scripts', array( new AssetProvider( new AssetService() ), 'register' ) );


		( new BlockProvider() )->register( new BlockService() );
		( new CPTProvider() )->register( new CPTSettingsService() );

		// Register image on demand sizes
		ImageService::get_instance()->register_image_sizes( array(
			'image_200'  => array( 200, 0 ),
			'image_500'  => array( 500, 0 ),
			'image_800'  => array( 800, 0 ),
			'image_1200' => array( 1200, 0 ),
		) );
	}
}