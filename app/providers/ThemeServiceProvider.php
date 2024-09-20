<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\providers\BlockProvider;
use jmucak\wpHelpersPack\providers\CPTProvider;
use wsytesTheme\services\BlockService;
use wsytesTheme\services\CPTSettingsService;

class ThemeServiceProvider {
	public function init(): void {
		// register theme scripts
		add_action( 'wp_enqueue_scripts', array( 'wsytesTheme\providers\AssetProvider', 'register' ) );

		$this->register_wp_helpers_pack_providers();
	}

	private function register_wp_helpers_pack_providers() : void {
		( new BlockProvider() )->register( new BlockService() );
		( new CPTProvider() )->register( new CPTSettingsService() );
	}
}