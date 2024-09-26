<?php

namespace wsytesTheme\services;

use wsytesTheme\interfaces\CPTFilterServiceInterface;
use wsytesTheme\providers\CPTProvider;
use wsytesTheme\repositories\PostRepository;
use wsytesTheme\repositories\TaxonomyRepository;

class ArticleService implements CPTFilterServiceInterface {
	public function get_output( array $posts, array $args, PostRepository $repository ): string|array {
		$taxonomy_repository = new TaxonomyRepository();

		$args = array_merge( $args, array(
			'categories' => $taxonomy_repository->get_terms( CPTProvider::TAXONOMY_ARTICLE_CAT ),
			'max_pages'  => $repository->max_num_pages,
			'items'      => $posts,
		) );

		return array(
			'html' => get_partial( 'components/article-list', $args, true ),
			'url'  => sprintf( '%spage/%s/%s', $args['permalink'], $args['paged'], $args['query'] )
		);
	}
}