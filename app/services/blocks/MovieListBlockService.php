<?php

namespace wsytesTheme\services\blocks;

use wsytesTheme\providers\CPTProvider;
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
		$repository = new PostRepository();
		$args = $repository->parse_args(array(
			'post_type' => CPTProvider::CPT_MOVIE,
		));

		$fields['output'] = $service->get_output( $args );

		get_partial( 'blocks/movie-list-block', $fields );
	}
}