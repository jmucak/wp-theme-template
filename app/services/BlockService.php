<?php

namespace wsytesTheme\services;

class BlockService {
	public function get_view( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void {
		$slug = str_replace( 'acf/', '', $block['name'] );

//		if ( $is_preview ) {
//			/*in case that this is preview as said in https://support.advancedcustomfields.com/forums/topic/register-block-preview-image-with-acf_register_block_type/#post-146180 then dont render the block but show the preview*/
//			if ( isset( $block['data']['preview_image_help'] ) ) {
//				echo "<img src='" . $block['data']['preview_image_help'] . "' style='width:100%; height:auto;''>";
//
//				return;
//			}
//		}

		$fields = get_fields();

		if ( empty( $fields ) ) {
			$fields = array();
		}

		get_partial( 'blocks/' . $slug, $fields );
	}
}