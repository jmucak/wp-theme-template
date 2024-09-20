<?php

use jmucak\wpHelpersPack\helpers\TemplateLoaderHelper;


/**
 * Function to get partial template
 *
 */
function get_partial( string $path, array $data = array(), bool $html = false ): bool|string|null {
	$file_path = TEMPLATE_PATH . 'partials/' . $path . '.php';

	return TemplateLoaderHelper::get_instance()->get_partial( $file_path, $data, $html );
}

/**
 * Function to get icon from static folder
 */
function get_icon( string $path, bool $html = false ): bool|string|null {
	$file_path = TEMPLATE_PATH . 'static/icons/' . $path . '.php';

	return TemplateLoaderHelper::get_instance()->get_partial( $file_path, array(), $html );
}

/**
 * Function to get base url to static folder
 */
function get_static_bu( string $url ): string {
	return TEMPLATE_URI . 'static/' . trim( $url );
}

/**
 * Function to get absolute url to static folder
 */
function get_static_au( string $url ): string {
	return TEMPLATE_PATH . 'static/' . trim( $url );
}

/**
 * Function to get filtered post content
 */
function get_filtered_content( int $id = null ) {
	global $post;

	if ( empty( $id ) ) {
		$id = $post->ID;
	}

	return apply_filters( 'the_content', get_post_field( 'post_content', $id ) );
}


// TODO:
// get_responsive_image