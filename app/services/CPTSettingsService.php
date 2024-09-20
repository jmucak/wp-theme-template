<?php

namespace wsytesTheme\services;

use jmucak\wpHelpersPack\services\AbstractCPTSettingsService;

class CPTSettingsService extends AbstractCPTSettingsService {
	// Add cpt name, always should be singular name
	const MOVIES_CPT = 'movie';
	const DOMAIN = 'wsytes'; // Change to your project name, used for translations

	// Add custom taxonomy name, always should be singular name
	const GENRE_TAXONOMY = 'genre';

	public function get_post_types(): array {
		return array(
			// call settings for new custom post type
			self::MOVIES_CPT => $this->get_movie_args(),
		);
	}

	public function get_taxonomies(): array {
		return array(
			// call settings for new custom taxonomy
			self::GENRE_TAXONOMY => $this->get_genre_args(),
		);
	}

	// Settings for new custom post type
	private function get_movie_args(): array {
		return array(
			'labels'              => $this->get_default_post_types_labels( 'Movie', 'Movies', self::DOMAIN ),
			'description'         => '',
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'public'              => true,
			'show_ui'             => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
			'rewrite'             => array(
				'with_front' => false,
				'slug'       => self::MOVIES_CPT,
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
	private function get_genre_args(): array {
		return array(
			'post_types' => array(
				self::MOVIES_CPT,
			),
			'args'       => array(
				'labels'             => $this->get_default_taxonomies_labels( 'Genre', self::DOMAIN ),
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