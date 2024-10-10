<?php

namespace wsytesTheme\factories;

use wsytesTheme\interfaces\CPTFilterServiceInterface;

class CPTFactory {
	public static function get_service( string $post_type ): ?CPTFilterServiceInterface {
		if ( str_contains( $post_type, '-' ) || str_contains( $post_type, '_' ) ) {
			// Replace hyphens and underscores with spaces
			$string = str_replace( [ '-', '_' ], ' ', $post_type );

			// Capitalize the first letter of each word
			$string = ucwords( $string );

			// Remove spaces
			$string = str_replace( ' ', '', $string );
		} else {
			$string = ucfirst( $post_type );
		}

		$service_class = 'wsytesTheme\\services\\' . $string . 'Service';

		if ( class_exists( $service_class ) ) {
			return new $service_class;
		}

		return null;
	}
}