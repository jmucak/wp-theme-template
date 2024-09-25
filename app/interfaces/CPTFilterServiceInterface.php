<?php

namespace wsytesTheme\interfaces;

use wsytesTheme\repositories\PostRepository;

interface CPTFilterServiceInterface {
	public function parse_args( array $args ): array;

	public function get_output( PostRepository $repository, array $args ): string|array;
}