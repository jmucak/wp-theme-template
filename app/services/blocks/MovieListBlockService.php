<?php

namespace wsytesTheme\services\blocks;

use wsytesTheme\providers\PostTypeProvider;
use wsytesTheme\services\BlockService;

class MovieListBlockService extends BlockService {
	public function get_view( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void {
		if ( $is_preview ) {
			if ( isset( $block['data']['preview_image_help'] ) ) {
				echo "<img src='" . $block['data']['preview_image_help'] . "' style='width:100%; height:auto;''>";

				return;
			}
		}
		$fields = get_fields();

		if ( empty( $fields ) ) {
			$fields = array();
		}
		$args = apply_filters( 'wsytes_cpt_controller_args', array(
			'post_type' => PostTypeProvider::CPT_MOVIE
		) );

		$output = apply_filters( 'wsytes_cpt_controller_output', $args );
		$fields = array_merge( $fields, $output );

		get_partial( 'blocks/movie-list-block', $fields );
	}
}