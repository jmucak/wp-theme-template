<?php

namespace wpThemeTemplate\core;

use wpThemeTemplate\providers\CPTProvider;
use wpThemeTemplate\providers\TaxonomiesProvider;

class Core {
	public function init(): void {
		add_action( 'wp_enqueue_scripts', array( 'wpThemeTemplate\core\AssetBundle', 'register' ) );

		$this->register_providers();
	}

	private function register_providers(): void {
		( new CPTProvider() )->init();
		( new TaxonomiesProvider() )->init();
	}
}