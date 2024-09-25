<?php

namespace wsytesTheme\services\blocks;

use wsytesTheme\repositories\PostRepository;
use wsytesTheme\services\BlockService;
use wsytesTheme\services\MovieService;

class MovieListBlockService extends BlockService {
	public function get_view( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void {
		$fields = get_fields();

		if ( empty( $fields ) ) {
			$fields = array();
		}

		$service = new MovieService();

		$args = $service->parse_args(  );

		$post_repository = new PostRepository( $args );

		$fields['output'] = $service->get_output( $post_repository->posts, $args, $post_repository );

		get_partial( 'blocks/movie-list-block', $fields );
	}
}