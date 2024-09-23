<?php

get_header();

get_partial( 'layout/navigation' );

//$fields = get_fields();

echo get_filtered_content();

get_partial( 'layout/footer' );
get_footer();