<?php

namespace wsytesTheme\providers;

class ThemeServiceProvider {
	public function init(): void {
		// register theme scripts
		add_action( 'wp_enqueue_scripts', array( 'wsytesTheme\providers\AssetProvider', 'register' ) );

		// Register CPT and custom taxonomies
		( new CPTProvider() )->init();
		( new TaxonomiesProvider() )->init();

		// Blocks
		( new BlockProvider() )->register();
	}
}