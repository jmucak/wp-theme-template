<?php

namespace wpThemeTemplate\core;

use wpThemeTemplate\providers\CPTProvider;
use wpThemeTemplate\providers\TaxonomiesProvider;

class Core {
	public function init(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );

		$this->register_providers();
	}

	public function add_scripts(): void {
		$url = INCLUDE_URL . 'static/dist/style.css';

		wp_enqueue_style( 'theme-css', trailingslashit( INCLUDE_URL ) . 'static/dist/style.css', null, '1.0.0', false );
		wp_enqueue_script( 'theme-js', trailingslashit( INCLUDE_URL ) . 'static/dist/bundle.js', null, '1.0.0', true );
	}

	private function register_providers(): void {
		( new CPTProvider() )->init();
		( new TaxonomiesProvider() )->init();
	}
}