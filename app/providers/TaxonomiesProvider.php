<?php

namespace wsytesTheme\providers;

class TaxonomiesProvider {
	// Add custom taxonomy name, always should be singular name
	const GENRE_TAXONOMY = 'genre';
	const DOMAIN = 'wsytes'; // Change to your project name, used for translations

	public function init(): void {
		foreach ( $this->get_custom_taxonomies() as $taxonomy => $args ) {
			register_taxonomy( $taxonomy, $args['post_types'], $args['args'] );
		}
	}

	public function get_custom_taxonomies(): array {
		return array(
			// call settings for new custom taxonomy
			self::GENRE_TAXONOMY => $this->get_genre_args(),
		);
	}

	// Settings for new custom taxonomy
	private function get_genre_args(): array {
		return array(
			'post_types' => array(
				CPTProvider::MOVIES_CPT,
			),
			'args'       => array(
				'labels'             => $this->get_default_labels( 'Genre' ),
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
	 * Default labels for taxonomies
	 *
	 * @param string $label
	 * @return array
	 *
	 */
	protected function get_default_labels( string $label ): array {
		return array(
			'name'              => sprintf( __( '%s', self::DOMAIN ), $label ),
			'singular_name'     => sprintf( __( '%s', self::DOMAIN ), $label ),
			'search_items'      => sprintf( __( 'Search %s', self::DOMAIN ), $label ),
			'all_items'         => sprintf( __( 'All %s', self::DOMAIN ), $label ),
			'parent_item'       => sprintf( __( 'Parent %s', self::DOMAIN ), $label ),
			'parent_item_colon' => sprintf( __( 'Parent %s:', self::DOMAIN ), $label ),
			'edit_item'         => sprintf( __( 'Edit %s', self::DOMAIN ), $label ),
			'update_item'       => sprintf( __( 'Update %s', self::DOMAIN ), $label ),
			'add_new_item'      => sprintf( __( 'Add new %s', self::DOMAIN ), $label ),
			'new_item_name'     => sprintf( __( 'New %s', self::DOMAIN ), $label ),
			'not_found'         => sprintf( __( 'No &quot;%s&quot; found', self::DOMAIN ), $label ),
		);
	}
}