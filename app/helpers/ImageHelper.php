<?php

namespace wsytesTheme\helpers;

use jmucak\wpImagePack\services\ImageService;

class ImageHelper {
	public static function get_responsive_image_data( array $args ): array {
		$default = array(
			'image'           => null,
			'sizes'           => array(
				'desktop'        => '',
				'desktop_retina' => '',
				'mobile'         => '',
				'mobile_retina'  => '',
			),
			'urls'            => array(
				'desktop'        => 'https://picsum.photos/id/236/1440/1440',
				'desktop_retina' => 'https://picsum.photos/id/236/1920/1920',
				'mobile'         => 'https://picsum.photos/id/234/600/600',
				'mobile_retina'  => 'https://picsum.photos/id/234/900/900',
			),
			'alt'             => 'Placeholder image',
			'aspect_ratio'    => '1-1',
			'object_fit'      => 'cover',
			'object_position' => 'center',
			'is_background'   => false,
			'lazy'            => true,
			'native_lazy'     => false,
			'priority'        => false,
			'animate'         => true,
			'width'           => '',
			'height'          => '',
			'loader_bg'       => '',
			'modifier_class'  => '',
		);

		$args = array_merge( $default, $args );


		if ( empty( $args['image'] ) || ! is_int( $args['image'] ) || empty( $args['sizes'] ) ) {
			return $args;
		}

		// if desktop size not entered don't show image
		if ( empty( $args['sizes']['desktop'] ) ) {
			return array();
		}

		$image_service = ImageService::get_instance();
		$args['urls']  = array();
		foreach ( $args['sizes'] as $key => $size ) {
			$args['urls'] [ $key ] = $image_service->get_image_url( $args['image'], $size );
		}

		$args['urls']['mobile']         = $args['urls']['mobile'] ?? $args['urls']['desktop'];
		$args['urls']['mobile_retina']  = $args['urls']['mobile_retina'] ?? $args['urls']['desktop'];
		$args['urls']['desktop_retina'] = $args['urls']['desktop_retina'] ?? $args['urls']['desktop'];

		$args['alt'] = $image_service->get_image_alt( $args['image'] );

		return $args;
	}
}