<?php

namespace wsytesTheme\core;

use wsytesTheme\providers\CPTProvider;
use wsytesTheme\providers\TaxonomiesProvider;

class Core {
	public function init(): void {
		add_action( 'wp_enqueue_scripts', array( 'wsytesTheme\core\AssetBundle', 'register' ) );
		$this->register_providers();
	}

	private function register_providers(): void {
		( new CPTProvider() )->init();
		( new TaxonomiesProvider() )->init();
	}
}