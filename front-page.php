<?php

use jmucak\wpOnDemandImages\services\DirectoryService;
use jmucak\wpOnDemandImages\services\ImageService;

get_header();

get_partial( 'layout/navigation' );

$fields = get_fields();

var_dump( $fields );

$image_service     = ImageService::get_instance();
$image_sizes       = $image_service->add_image_size( 'image_800', array( 800, 0 ) );
$image_sizes       = $image_service->add_image_size( 'image_900', array( 900, 0 ) );
$image_sizes       = $image_service->add_image_size( 'image_1000', array( 1000, 0 ) );
$directory_service = new DirectoryService();
$image             = $directory_service->get_attachment_image_by_size_name( 168, 'image_800' );

if ( ! empty( $image ) ) { ?>
    <img src="<?php
	echo $image; ?>" alt="">
<?php
}

echo get_the_content();

get_partial( 'layout/footer' );
get_footer();