<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\CPTHelper;

class TaxonomyProvider {
	const DOMAIN = 'wsytes'; // Change to your project name, used for translations
	const TAXONOMY_GENRE = 'genre'; // Add custom taxonomy name, always should be singular name

	public function register(): void {
		register_taxonomy( self::TAXONOMY_GENRE, array( PostTypeProvider::CPT_MOVIE ), $this->get_genre_args() );
	}

	// Settings for new custom taxonomy
	public function get_genre_args(): array {
		return array(
			'labels'             => CPTHelper::get_taxonomy_labels( 'Genre', self::DOMAIN ),
			'description'        => '',
			'public'             => true,
			'publicly_queryable' => true,
			'hierarchical'       => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'query_var'          => true,
			'rewrite'            => false,
		);
	}
	// End settings for new custom taxonomy
}