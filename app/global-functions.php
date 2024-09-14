<?php

use wsytesTheme\helpers\PartialHelper;


/**
 * @throws Exception
 */
function get_partial( string $path, array $data = array(), bool $html = false ) {
	$file_path = TEMPLATE_PATH . 'partials/' . $path . '.php';

	if ( ! file_exists(  $file_path ) ) {
		throw new Exception( 'Partial file does not exist: ' . $file_path );
	}

	if ( $html ) {
		return PartialHelper::get_instance()->get_internal( $file_path, $data );
	}

	PartialHelper::get_instance()->render_internal( $file_path, $data );
}

// TODO:
// get_slice_partial()
// get_icon()
// get_base_url() => bu()
// bf_content()
// get_responsive_image