<?php

namespace wsytesTheme\services;

use WP_Query;
use wsytesTheme\interfaces\CPTFilterServiceInterface;
use wsytesTheme\providers\CPTProvider;
use wsytesTheme\repositories\TaxonomyRepository;

class ArticleService implements CPTFilterServiceInterface {
	public function get_output( array $posts, array $args, WP_Query $query ): string|array {
		$taxonomy_repository = new TaxonomyRepository();
		$args['categories'] = $taxonomy_repository->get_terms( CPTProvider::TAXONOMY_ARTICLE_CAT );

		return array(
			'html' => get_partial( 'components/article-list', $args, true ),
			'url'  => sprintf( '%spage/%s/%s', $args['permalink'], $args['paged'], $args['query'] )
		);
	}
}