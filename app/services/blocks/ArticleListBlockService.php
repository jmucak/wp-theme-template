<?php

namespace wsytesTheme\services\blocks;

use wsytesTheme\providers\CPTProvider;
use wsytesTheme\repositories\PostRepository;
use wsytesTheme\services\ArticleService;
use wsytesTheme\services\BlockService;

class ArticleListBlockService extends BlockService {
	public function get_view( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void {
		$fields = get_fields();

		if ( empty( $fields ) ) {
			$fields = array();
		}

		$repository = new PostRepository();
		$args       = $repository->parse_args( array(
			'post_type' => CPTProvider::CPT_ARTICLE,
			'taxonomy'  => CPTProvider::TAXONOMY_ARTICLE_CAT,
			'relation'  => CPTProvider::RELATION_ARTICLE
		) );


		$service = new ArticleService();

		$output = $service->get_output( $repository->query( $args ), $args, $repository );
		$fields = array_merge($fields, $output);

		get_partial( 'blocks/article-list-block', $fields );
	}
}