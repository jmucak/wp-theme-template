<?php

namespace wsytesTheme\providers;

class CPTProvider {
	// Add cpt name, always should be singular name
	const MOVIES_CPT = 'movie';
	const DOMAIN = 'wsytes'; // Change to your project name, used for translations

	public function init(): void {
		foreach ( $this->get_custom_post_types() as $post_type => $args ) {
			register_post_type( $post_type, $args );
		}
	}

	/**
	 *
	 *
	 * @return array[]
	 */
	public function get_custom_post_types(): array {
		return array(
			// call settings for new custom post type
			self::MOVIES_CPT => $this->get_movie_args(),
		);
	}

	// Settings for new custom post type
	private function get_movie_args(): array {
		return array(
			'labels'              => $this->get_default_labels( 'Movie', 'Movies' ),
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

	/**
	 * Default labels for CPT
	 *
	 * @param string $label
	 * @param string $label_plural
	 * @return array
	 */
	protected function get_default_labels( string $label, string $label_plural ): array {
		return array(
			'name'                  => sprintf( __( '%s', self::DOMAIN ), $label_plural ),
			'singular_name'         => sprintf( __( '%s', self::DOMAIN ), $label ),
			'all_items'             => sprintf( __( 'All %s', self::DOMAIN ), $label_plural ),
			'menu_name'             => sprintf( __( '%s', 'Admin menu name', self::DOMAIN ), $label_plural ),
			'add_new'               => __( 'Add New', self::DOMAIN ),
			'add_new_item'          => sprintf( __( 'Add new %s', self::DOMAIN ), $label ),
			'edit'                  => __( 'Edit', self::DOMAIN ),
			'edit_item'             => sprintf( __( 'Edit %s', self::DOMAIN ), $label ),
			'new_item'              => sprintf( __( 'New %s', self::DOMAIN ), $label ),
			'view_item'             => sprintf( __( 'View %s', self::DOMAIN ), $label ),
			'view_items'            => sprintf( __( 'View %s', self::DOMAIN ), $label_plural ),
			'search_items'          => sprintf( __( 'Search %s', self::DOMAIN ), $label_plural ),
			'not_found'             => sprintf( __( 'No %s found', self::DOMAIN ), $label_plural ),
			'not_found_in_trash'    => sprintf( __( 'No %s found in trash', self::DOMAIN ), $label_plural ),
			'parent'                => sprintf( __( 'Parent %s', self::DOMAIN ), $label ),
			'featured_image'        => sprintf( __( '%s image', self::DOMAIN ), $label ),
			'set_featured_image'    => sprintf( __( 'Set %s image', self::DOMAIN ), $label ),
			'remove_featured_image' => sprintf( __( 'Remove %s image', self::DOMAIN ), $label ),
			'use_featured_image'    => sprintf( __( 'Use as %s image', self::DOMAIN ), $label ),
			'insert_into_item'      => sprintf( __( 'Insert into %s', self::DOMAIN ), $label ),
			'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', self::DOMAIN ), $label ),
			'filter_items_list'     => sprintf( __( 'Filter %s', self::DOMAIN ), $label_plural ),
			'items_list_navigation' => sprintf( __( '%s navigation', self::DOMAIN ), $label_plural ),
			'items_list'            => sprintf( __( '%s list', self::DOMAIN ), $label_plural ),
		);
	}
}