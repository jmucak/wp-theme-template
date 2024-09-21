<?php

namespace wsytesTheme\services;

use jmucak\wpHelpersPack\interfaces\CPTSettingsServiceInterface;

class CPTSettingsService implements CPTSettingsServiceInterface {
	// Add cpt name, always should be singular name
	const CPT_MOVIE = 'movie';
	const DOMAIN = 'wsytes'; // Change to your project name, used for translations

	// Add custom taxonomy name, always should be singular name
	const TAXONOMY_GENRE = 'genre';

	// Set custom post types
	public function get_post_types(): array {
		return array(
			// call settings for new custom post type
			self::CPT_MOVIE => $this->get_movie_args(),
		);
	}

	// Set custom taxonomies
	public function get_taxonomies(): array {
		return array(
			// call settings for new custom taxonomy
			self::TAXONOMY_GENRE => $this->get_genre_args(),
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
	private function get_genre_args(): array {
		return array(
			'post_types' => array(
				self::CPT_MOVIE,
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


	/**
	 * Default labels for CPT
	 *
	 * @param string $label
	 * @param string $label_plural
	 * @param string $domain
	 * @return array
	 */
	protected function get_default_post_types_labels( string $label, string $label_plural, string $domain = '' ): array {
		return array(
			'name'                  => sprintf( __( '%s', $domain ), $label_plural ),
			'singular_name'         => sprintf( __( '%s', $domain ), $label ),
			'all_items'             => sprintf( __( 'All %s', $domain ), $label_plural ),
			'menu_name'             => sprintf( __( '%s', 'Admin menu name', $domain ), $label_plural ),
			'add_new'               => __( 'Add New', $domain ),
			'add_new_item'          => sprintf( __( 'Add new %s', $domain ), $label ),
			'edit'                  => __( 'Edit', $domain ),
			'edit_item'             => sprintf( __( 'Edit %s', $domain ), $label ),
			'new_item'              => sprintf( __( 'New %s', $domain ), $label ),
			'view_item'             => sprintf( __( 'View %s', $domain ), $label ),
			'view_items'            => sprintf( __( 'View %s', $domain ), $label_plural ),
			'search_items'          => sprintf( __( 'Search %s', $domain ), $label_plural ),
			'not_found'             => sprintf( __( 'No %s found', $domain ), $label_plural ),
			'not_found_in_trash'    => sprintf( __( 'No %s found in trash', $domain ), $label_plural ),
			'parent'                => sprintf( __( 'Parent %s', $domain ), $label ),
			'featured_image'        => sprintf( __( '%s image', $domain ), $label ),
			'set_featured_image'    => sprintf( __( 'Set %s image', $domain ), $label ),
			'remove_featured_image' => sprintf( __( 'Remove %s image', $domain ), $label ),
			'use_featured_image'    => sprintf( __( 'Use as %s image', $domain ), $label ),
			'insert_into_item'      => sprintf( __( 'Insert into %s', $domain ), $label ),
			'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', $domain ), $label ),
			'filter_items_list'     => sprintf( __( 'Filter %s', $domain ), $label_plural ),
			'items_list_navigation' => sprintf( __( '%s navigation', $domain ), $label_plural ),
			'items_list'            => sprintf( __( '%s list', $domain ), $label_plural ),
		);
	}


	/**
	 * Default labels for taxonomies
	 *
	 * @param string $label
	 * @param string $domain
	 * @return array
	 */
	protected function get_default_taxonomies_labels( string $label, string $domain = '' ): array {
		return array(
			'name'              => sprintf( __( '%s', $domain ), $label ),
			'singular_name'     => sprintf( __( '%s', $domain ), $label ),
			'search_items'      => sprintf( __( 'Search %s', $domain ), $label ),
			'all_items'         => sprintf( __( 'All %s', $domain ), $label ),
			'parent_item'       => sprintf( __( 'Parent %s', $domain ), $label ),
			'parent_item_colon' => sprintf( __( 'Parent %s:', $domain ), $label ),
			'edit_item'         => sprintf( __( 'Edit %s', $domain ), $label ),
			'update_item'       => sprintf( __( 'Update %s', $domain ), $label ),
			'add_new_item'      => sprintf( __( 'Add new %s', $domain ), $label ),
			'new_item_name'     => sprintf( __( 'New %s', $domain ), $label ),
			'not_found'         => sprintf( __( 'No &quot;%s&quot; found', $domain ), $label ),
		);
	}
}