<?php

namespace wsytesTheme\services\blocks;

use wsytesTheme\providers\CPTProvider;
use wsytesTheme\services\BlockService;

class ArticleListBlockService extends BlockService {
	public function get_view( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void {
		$fields = get_fields();

		if ( empty( $fields ) ) {
			$fields = array();
		}

		$args = apply_filters( 'wsytes_cpt_controller_args', array(
			'post_type' => CPTProvider::CPT_ARTICLE
		) );

		$output = apply_filters( 'wsytes_cpt_controller_output', $args );
		$fields = array_merge( $fields, $output );

		get_partial( 'blocks/article-list-block', $fields );
	}
}