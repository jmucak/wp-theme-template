<?php

namespace wsytesTheme\providers;

use wsytesTheme\helpers\CPTHelper;

class CPTProvider {
	const CPT_MOVIE = 'movie'; // Add cpt name, always should be singular name
	const DOMAIN = 'wsytes'; // Change to your project name, used for translations
	const TAXONOMY_GENRE = 'genre'; // Add custom taxonomy name, always should be singular name

	// Settings for new custom post type
	public static function get_movie_args(): array {
		return array(
			'labels'              => CPTHelper::get_post_type_labels('Movie', 'Movies', self::DOMAIN),
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


	// Settings for new custom taxonomy
	public static function get_genre_args(): array {
		return array(
			'post_types' => array(self::CPT_MOVIE),
			'args' => array(
				'labels'             => CPTHelper::get_taxonomy_labels('Genre', self::DOMAIN),
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
			)
		);
	}
	// End settings for new custom taxonomy
}