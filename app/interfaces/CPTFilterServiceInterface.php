<?php

namespace wsytesTheme\interfaces;

use WP_Query;

interface CPTFilterServiceInterface {
	public function get_output( array $posts, array $args, WP_Query $query ): string|array;
}