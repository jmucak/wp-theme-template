<?php

namespace wsytesTheme\providers;

use wsytesTheme\services\BlockService;

class BlockProvider {
	public const CATEGORY = 'wsytes-blocks';
	private string $mode = 'mode';

	public function get_blocks(): array {
		return array(
			$this->get_test_block(),
		);
	}

	// Add new block
	private function get_test_block(): array {
		return array(
			'name'            => 'test-block',
			'title'           => 'Test Block',
			'description'     => 'Test Block',
			'category'        => self::CATEGORY,
			'mode'            => $this->mode,
			'icon'            => null,
			'keywords'        => array( 'test' ),
			'post_types'      => array( 'post', 'page' ),
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'preview_image_help' => TEMPLATE_URI . 'static/blocks/test-block.png'
					)
				)
			),
			'enqueue_style'   => '',
			'enqueue_script'  => '',
			'enqueue_assets'  => '',
			'render_callback' => array( new BlockService(), 'get_view' )
		);
	}
	// End Add new block
}