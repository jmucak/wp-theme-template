<?php

namespace wsytesTheme\interfaces;

use wsytesTheme\repositories\PostRepository;

interface CPTFilterServiceInterface {
	public function get_output( array $posts, array $args, PostRepository $repository ): string|array;
}