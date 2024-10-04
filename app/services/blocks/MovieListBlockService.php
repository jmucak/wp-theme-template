<?php

namespace wsytesTheme\services\blocks;

use wsytesTheme\providers\PostTypeProvider;
use wsytesTheme\services\BlockService;

class MovieListBlockService extends BlockService {
	public function get_view( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void {
		$fields = get_fields();

		if ( empty( $fields ) ) {
			$fields = array();
		}
		$args       = apply_filters( 'wsytes_cpt_controller_args', array(
			'post_type' => PostTypeProvider::CPT_MOVIE
		) );

		$output = apply_filters( 'wsytes_cpt_controller_output', $args );
		$fields = array_merge($fields, $output);

		get_partial( 'blocks/movie-list-block', $fields );
	}
}