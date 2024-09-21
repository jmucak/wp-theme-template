<?php

get_header();

get_partial( 'layout/navigation' );

$fields = get_fields();

var_dump( $fields );

echo get_the_content();

get_partial( 'layout/footer' );
get_footer();