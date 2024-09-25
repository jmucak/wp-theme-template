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

		$page = get_query_var( 'paged' );
		$args = $service->parse_args( array(
			'post_type'      => CPTProvider::CPT_MOVIE,
			'post_status'    => 'publish',
			'posts_per_page' => 2,
			'paged'          => ! empty( $page ) ? $page : 1,
			'genre'          => get_query_var( 'genre', '' ),
			'relation'       => ! empty( $_GET['relation'] ) ? $_GET['relation'] : '', // add to register query args
		) );

		$fields['output'] = $service->get_output( new PostRepository( $args ), $args );

		get_partial( 'blocks/movie-list-block', $fields );
	}
}