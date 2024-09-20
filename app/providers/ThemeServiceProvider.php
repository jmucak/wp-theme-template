<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\providers\AssetProvider;
use jmucak\wpHelpersPack\providers\BlockProvider;
use jmucak\wpHelpersPack\providers\CPTProvider;
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
	}
}