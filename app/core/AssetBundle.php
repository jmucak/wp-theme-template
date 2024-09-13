<?php

namespace wsytesTheme\core;

class AssetBundle {
	protected static string $include_base_path = '/static/';

	public array $js = array();
	public array $css = array();

	private function set_js_data(): void {
		$this->js = array(
			'wsytesThemeVendor' => array(
				'path'           => 'dist/vendor.js',
				'version'        => '1.0.0',
				'localize'       => array(
					'object' => 'frontend_rest_object',
					'data'   => array(),
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

	private function set_css_data(): void {
		$this->css = array(
			'wsytesThemeMainCSS' => array(
				'path'           => 'dist/style.css',
				'in_footer'      => false,
				'version'        => '1.0.0',
				'timestamp_bust' => true,
			),
		);
	}

	public function get_base_url(): string {
		return TEMPLATE_URI . self::$include_base_path;
	}

	public function get_base_path(): string {
		return get_theme_file_path( self::$include_base_path );
	}

	public static function register(): void {
		$bundle = new static();
		$bundle->set_js_data();
		$bundle->set_css_data();
		$bundle->enqueue_scripts();
		$bundle->enqueue_styles();
	}

	private function enqueue_scripts(): void {
		foreach ( $this->js as $handle => $data ) {
			if ( empty( $data['path'] ) ) {
				continue;
			}
			$path           = $data['path'];
			$version        = $data['version'] ?? 1.0;
			$timestamp_bust = ! empty( $data['timestamp_bust'] );
			$in_footer      = $data['in_footer'] ?? true;

			if ( $timestamp_bust ) {
				$version .= sprintf( '.%d', filemtime( $this->get_base_path() . $path ) );
			}

			wp_enqueue_script( $handle, $this->get_base_url() . $path, [], $version, $in_footer );

			if ( ! empty( $data['localize'] ) && ! empty( $data['localize']['data'] ) ) {
				wp_localize_script( $handle, $data['localize']['object'], $data['localize']['data'] );
			}
		}
	}

	protected function enqueue_styles(): void {
		foreach ( $this->css as $handle => $data ) {
			if ( empty( $data['path'] ) ) {
				continue;
			}

			$path      = $data['path'];
			$version   = $data['version'] ?? 1.0;
			$in_footer = $data['in_footer'] ?? true;

			wp_enqueue_style( $handle, $this->get_base_url() . $path, [], $version, $in_footer );
		}
	}
}