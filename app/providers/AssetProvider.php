<?php

namespace wsytesTheme\providers;

use jmucak\wpAssetServicePack\AssetService;

class AssetProvider {
	public function register(): void {
		$asset_service = new AssetService( array(
			'base_url'  => TEMPLATE_URI . '/static/',
			'base_path' => get_theme_file_path( '/static/' )
		) );

		$asset_service->register_site_assets( $this->get_site_assets_config() );
//		$asset_service->register_admin_assets( $this->get_admin_assets_config() );
		$asset_service->register_editor_assets( $this->get_editor_assets_config() );
	}

	private function get_site_assets_config(): array {
		return array(
			'js'  => array(
				'wsytesThemeVendor' => array(
					'path'           => 'dist/vendor.js',
					'version'        => '1.0.0',
					'localize'       => array(
						'object' => 'frontend_rest_object',
						'data'   => array(
							'rest_url'  => get_rest_url( null, RESTProvider::get_api_namespace() ),
							'route_cpt' => RESTProvider::ROUTE_CPT
						),
					),
					'timestamp_bust' => true,
				),
				'wsytesThemeBundle' => array(
					'path'           => 'dist/bundle.js',
					'version'        => '1.0.0',
					'timestamp_bust' => true,
				),
			),
			'css' => array(
				'wsytesThemeMainCSS' => array(
					'path'           => 'dist/style.css',
					'in_footer'      => false,
					'version'        => '1.0.0',
					'timestamp_bust' => true,
				),
			),
		);
	}

	private function get_admin_assets_config(): array {
		return array(
			'js'  => array(
				'wsytesThemeAdminBundle' => array(
					'path'           => 'dist/admin.js',
					'version'        => '1.0.0',
					'timestamp_bust' => true,
				),
			),
			'css' => array(
				'wsytesThemeAdminCSS' => array(
					'path'           => 'dist/style.css',
					'in_footer'      => false,
					'version'        => '1.0.0',
					'timestamp_bust' => true,
				),
			),
		);
	}

	private function get_editor_assets_config(): array {
		return array(
//			'js'  => array(
//				'wsytesThemeEditorBundle' => array(
//					'path'           => 'dist/editor.js',
//					'version'        => '1.0.0',
//					'timestamp_bust' => true,
//				),
//			),
			'css' => array(
				'wsytesThemeEditorCSS' => array(
					'path'           => 'dist/style.css',
					'in_footer'      => false,
					'version'        => '1.0.0',
					'timestamp_bust' => true,
				),
			),
		);
	}
}