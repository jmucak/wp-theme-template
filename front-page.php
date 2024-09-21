<?php

use jmucak\wpOnDemandImages\services\ImageService;

get_header();

get_partial( 'layout/navigation' );

$fields = get_fields();

var_dump( $fields );

$image_service     = ImageService::get_instance();
$image = $image_service->get_image(168, 'thumbnail');

if ( ! empty( $image ) ) { ?>
    <img src="<?php
	echo $image['url']; ?>" alt="">
<?php
}

echo get_the_content();

get_partial( 'layout/footer' );
get_footer();