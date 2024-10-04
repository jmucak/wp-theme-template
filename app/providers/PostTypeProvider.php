<?php

namespace wsytesTheme\providers;

use jmucak\wpHelpersPack\CPTHelper;

class PostTypeProvider {
	const CPT_MOVIE = 'movie'; // Add cpt name, always should be singular name
	const RELATION_MOVIE = 'and';
	const DOMAIN = 'wsytes'; // Change to your project name, used for translations

	public function register() : void {
		register_post_type(self::CPT_MOVIE, $this->get_movie_args());
	}

	// Settings for new custom post type
	public function get_movie_args(): array {
		return array(
			'labels'              => CPTHelper::get_post_type_labels( 'Movie', 'Movies', self::DOMAIN ),
			'description'         => '',
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'public'              => true,
			'show_ui'             => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
			'rewrite'             => array(
				'with_front' => false,
				'slug'       => self::CPT_MOVIE,
			),
			'query_var'           => true,
			'has_archive'         => false,
			'show_in_nav_menus'   => true,
			'show_in_rest'        => true,
			'menu_icon'           => null,
			'acfe_admin_archive'  => false,
		);
	}
	// End settings for new custom post type
}