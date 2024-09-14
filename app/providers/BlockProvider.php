<?php

namespace wsytesTheme\providers;

use wsytesTheme\services\BlockService;

class BlockProvider {
	private BlockService $block_service;

	public function register(): void {
		$this->block_service = new BlockService();
		add_action( 'acf/init', array( $this, 'register_blocks' ) );
		add_filter( 'allowed_block_types_all', array( $this, 'filter_allowed_blocks' ) );
		add_filter( 'block_categories_all', array( $this, 'filter_block_categories' ) );
	}

	/**
	 * Register blocks with acf
	 */
	public function register_blocks(): void {
		foreach ( $this->block_service->get_blocks() as $block ) {
			acf_register_block_type( $block );
		}
	}

	/**
	 * Filter gutenberg blocks
	 */
	public function filter_allowed_blocks( bool|array $allowed_block_types ): array {
		$all_blocks = get_dynamic_block_names();

		$filtered_acf_arrays = array_filter( $all_blocks, fn( $block_name ) => str_contains( $block_name, 'acf' ) );

		$gutenberg_blocks = array(
			'core/column',
			'core/columns',
			'core/block',
			'core/paragraph',
			'core/heading',
			'core/image',
			'core/gallery',
			'core/shortcode',
		);

		return array_merge( $filtered_acf_arrays, $gutenberg_blocks );
	}

	/**
	 * Add custom gutenberg block category
	 */
	public function filter_block_categories( array $categories ): array {
		$categories[] = array(
			'slug'  => $this->block_service->category,
			'title' => 'Wsytes Blocks'
		);

		return $categories;
	}
}