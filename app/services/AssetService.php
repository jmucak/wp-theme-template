<?php

namespace wsytesTheme\services;

use jmucak\wpHelpersPack\interfaces\AssetServiceInterface;

class AssetService implements AssetServiceInterface {

	public function get_base_url(): string {
		return TEMPLATE_URI . '/static/';
	}

	public function get_base_path(): string {
		return get_theme_file_path( '/static/' );
	}

	public function get_js_settings(): array {
		return array(
			'wsytesThemeVendor' => array(
				'path'           => 'dist/vendor.js',
				'version'        => '1.0.0',
				'localize'       => array(
					'object' => 'frontend_rest_object',
					'data'   => $this->get_localize_data(),
				),
				'timestamp_bust' => true,
			),
			'wsytesThemeBundle' => array(
				'path'           => 'dist/bundle.js',
				'version'        => '1.0.0',
				'timestamp_bust' => true,
			),
		);
	}

	public function get_css_settings(): array {
		return array(
			'wsytesThemeMainCSS' => array(
				'path'           => 'dist/style.css',
				'in_footer'      => false,
				'version'        => '1.0.0',
				'timestamp_bust' => true,
			),
		);
	}

	public function get_localize_data(): array {
		return array();
	}
}