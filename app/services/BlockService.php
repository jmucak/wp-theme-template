<?php

namespace wsytesTheme\services;

class BlockService  {
	public string $category = 'wsytes-blocks';
	private string $mode = 'edit';


	// Add new block
	public function get_test_block() : array {
		return array(
			'name'            => 'test-block',
			'title'           => 'Test Block',
			'description'     => 'Test Block',
			'category'        => $this->category,
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
			'render_callback' => array( $this, 'get_blocks_callback' )
		);
	}
	// End Add new block

	/**
	 * Callback for each block
	 *
	 * @throws \Exception
	 */
	public function get_blocks_callback( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void {
		$slug  = str_replace( 'acf/', '', $block['name'] );
		$block = array_merge( [ 'className' => '' ], $block );

		if ( $is_preview ) {
			/*in case that this is preview as said in https://support.advancedcustomfields.com/forums/topic/register-block-preview-image-with-acf_register_block_type/#post-146180 then dont render the block but show the preview*/
			if ( isset( $block['data']['preview_image_help'] ) ) {
				echo "<img src='" . $block['data']['preview_image_help'] . "' style='width:100%; height:auto;''>";

				return;
			}
		}

		$fields = get_fields();

		if ( empty( $fields ) ) {
			$fields = array();
		}

		get_partial('blocks/'. $slug, $fields);
	}
}