<?php

namespace wsytesTheme\controllers;

use Exception;

class PartialController {
	private static ?PartialController $instance = null;

	private function __construct() {
	}

	public static function get_instance(): ?PartialController {
		if ( null === self::$instance ) {
			self::$instance = new PartialController();
		}

		return self::$instance;
	}

	public function get_partial( string $path, array $data = array(), bool $html = false ) {
		$file_path = TEMPLATE_PATH . 'partials/' . $path . '.php';

		if ( ! file_exists( $file_path ) ) {
			throw new Exception( 'Partial file does not exist: ' . $file_path );
		}

		if ( $html ) {
			return $this->get_internal( $file_path, $data );
		}

		$this->render_internal( $file_path, $data );
	}

	// @codingStandardsIgnoreStart
	private function render_internal( string $_view_file_, array $_data_ = array() ): void {
		// we use special variable names here to avoid conflict when extracting data
		if ( ! empty( $_data_ ) ) {
			extract( $_data_, EXTR_OVERWRITE );
		}

		require $_view_file_;
	}

	private function get_internal( $_view_file_, array $_data_ = array() ): bool|string {
		// we use special variable names here to avoid conflict when extracting data
		if ( ! empty( $_data_ ) ) {
			extract( $_data_, EXTR_OVERWRITE );
		}

		ob_start();
		ob_implicit_flush( 0 );
		require $_view_file_;

		return ob_get_clean();
	}
	// @codingStandardsIgnoreEnd

}