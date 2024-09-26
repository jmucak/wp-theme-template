<?php

namespace wsytesTheme\interfaces;

interface CPTFilterServiceInterface {
	public function get_output( array $args ): string;

	public function get_url( array $args ): string;
}