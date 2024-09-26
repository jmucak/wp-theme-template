<?php

namespace wsytesTheme\factories;

use Exception;
use wsytesTheme\interfaces\CPTFilterServiceInterface;
use wsytesTheme\providers\CPTProvider;
use wsytesTheme\services\ArticleService;
use wsytesTheme\services\MovieService;

class CPTFactory {
	private static $instance = null;

	public static function get_instance(): ?CPTFactory {
		if ( self::$instance === null ) {
			self::$instance = new CPTFactory();
		}

		return self::$instance;
	}

	// Prevent cloning
	protected function __clone() {
	}

	// Prevent unserialization
	public function __wakeup() {
		throw new Exception( 'Cannot unserialize a singleton.' );
	}

	public function get_service( string $post_type ): ?CPTFilterServiceInterface {
		return match ( $post_type ) {
			CPTProvider::CPT_MOVIE => new MovieService(),
			CPTProvider::CPT_ARTICLE => new ArticleService(),
			default => null,
		};
	}
}