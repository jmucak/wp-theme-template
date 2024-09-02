<?php

namespace wpThemeTemplate\core;

class Core {
	public function init() : void {

		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
	}

	public function add_scripts() : void {
		$url = INCLUDE_URL . 'static/dist/style.css';

		wp_enqueue_style( 'theme-css', trailingslashit(INCLUDE_URL) . 'static/dist/style.css', null, '1.0.0', false );
		wp_enqueue_script( 'theme-js', trailingslashit(INCLUDE_URL) . 'static/dist/bundle.js', null, '1.0.0', true );
	}
}