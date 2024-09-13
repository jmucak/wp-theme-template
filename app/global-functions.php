<?php

use wsytesTheme\controllers\PartialController;


function get_partial( string $path, array $data = array(), bool $html = false ): bool|string|null {
	return PartialController::get_instance()->get_partial( $path, $data, $html );
}