<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\providers\BlockProvider;
use wsytesTheme\services\BlockService;

class WPHelpersPackProvider {
	public function register(): void {
		( new BlockProvider() )->register( new BlockService() );
	}
}