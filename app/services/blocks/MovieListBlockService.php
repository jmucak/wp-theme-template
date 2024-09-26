<?php

namespace wsytesTheme\services\blocks;

use wsytesTheme\services\BlockService;
use wsytesTheme\services\MovieService;

class MovieListBlockService extends BlockService {
	public function get_view( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void {
		$fields = get_fields();

		if ( empty( $fields ) ) {
			$fields = array();
		}

		$service = new MovieService();

		$fields['output'] = $service->get_output( $service->parse_args() );

		get_partial( 'blocks/movie-list-block', $fields );
	}
}