<?php
namespace wsytesTheme\helpers;

class PartialHelper {
	private static ?PartialHelper $instance = null;

	private function __construct() {
	}

	public static function get_instance(): ?PartialHelper {
		if ( null === self::$instance ) {
			self::$instance = new PartialHelper();
		}

		return self::$instance;
	}

	// @codingStandardsIgnoreStart
	public function render_internal( string $_view_file_, array $_data_ = array() ): void {
		// we use special variable names here to avoid conflict when extracting data
		if ( ! empty( $_data_ ) ) {
			extract( $_data_, EXTR_OVERWRITE );
		}

		require $_view_file_;
	}

	public function get_internal( $_view_file_, array $_data_ = array() ): bool|string {
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