<?php

define( 'INCLUDE_PATH', get_template_directory() . '/inc/' );
define( 'TEMPLATE_PATH', get_template_directory() . '/' );
define( 'INCLUDE_URL', get_template_directory_uri() );

if ( ! defined( 'FS_METHOD' ) ) {
	define( 'FS_METHOD', 'direct' );
}

if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	add_action( 'admin_notices', function () {
		?>
        <div class="notice notice-error">
            <h2>Missing <i>vendor/autoloader.php</i></h2>
            <p>
                <strong>
                    You are missing composer autoload. Please run <i>composer install</i> in root of your project.
                </strong>
            </p>
        </div>
		<?php
	} );

	return;
}
/**
 * If this command fails try to run "composer dump" in the theme root directory
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/global-functions.php';

// Here goes core class for registering
$core = new \wsytesTheme\core\Core();
$core->init();

// Please don't add any code here