<?php

namespace wsytesTheme\providers;

class MenuProvider {
	const HEADER_MENU_LOCATION = 'header-menu';
	const FOOTER_MENU_LOCATION = 'footer-menu';

	public function register() : void {
		register_nav_menus(array(
			self::HEADER_MENU_LOCATION => 'Header Menu',
			self::FOOTER_MENU_LOCATION => 'Footer Menu',
		));
	}
}