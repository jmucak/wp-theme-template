<?php

namespace wsytesTheme\factories;

use wsytesTheme\interfaces\CPTFilterServiceInterface;

class CPTFactory {
	public static function get_service( string $post_type ): ?CPTFilterServiceInterface {
		$service_class = 'wsytesTheme\\services\\'. ucfirst( $post_type ) . 'Service';

		if ( class_exists( $service_class ) ) {
			return new $service_class;
		}

		return null;
	}
}