<?php

namespace wsytesTheme\helpers;

use WP_Post;
use wsytesTheme\providers\MenuProvider;

class MenuHelper {
	public static function get_header_menu_items(): array {
		return self::get_menu_items( MenuProvider::HEADER_MENU_LOCATION );
	}

	public static function get_footer_menu_items(): array {
		return self::get_menu_items( MenuProvider::FOOTER_MENU_LOCATION );
	}

	/**
	 *
	 * Get menu items and if has sub menu items than create sub menu items as well
	 *
	 * @param string $location
	 * @param array $args
	 * @return array
	 *
	 */
	public static function get_menu_items( string $location, array $args = array() ): array {
		$menu_locations = get_nav_menu_locations();

		if ( empty( $menu_locations[ $location ] ) ) {
			return array();
		}

		$menu = wp_get_nav_menu_object( $menu_locations[ $location ] );

		$menu_items = wp_get_nav_menu_items( $menu->term_id, $args );

		if ( empty( $menu_items ) ) {
			return array();
		}

		$new_menu_array = array();
		foreach ( (array) $menu_items as $key => $menu_item ) {
			$new_menu_array[ $menu_item->menu_item_parent ][] = $menu_item;
		}

		$new_menu_array1 = array();
		foreach ( (array) $menu_items as $key => $menu_item ) {
			if ( isset( $new_menu_array[ $menu_item->ID ] ) ) {
				$menu_item->sub = $new_menu_array[ $menu_item->ID ];
				if ( 0 === (int) $menu_item->menu_item_parent ) {
					$new_menu_array1[] = $menu_item;
				}
			}
		}

		return array_splice( $new_menu_array[0], 0, 15, $new_menu_array1 );
	}

	/**
	 * Get is active class based on menu item
	 *
	 * @param WP_Post $item
	 * @return string
	 *
	 */
	public static function get_is_active_class( WP_Post $item ): string {
		$post_type = get_post_type();

		if ( is_single() ) {
			$page_url = get_post_type_archive_link( get_post_type() );

			if ( $page_url === $item->url ) {
				return 'is-active';
			}

			return '';
		}

		if ( is_archive() ) {
			if ( get_post_type_archive_link( $post_type ) === $item->url ) {
				return 'is-active';
			}

			return '';
		}

		if ( is_home() ) {
			if ( get_post_type_archive_link( get_post_type() ) === $item->url ) {
				return 'is-active';
			}

			return '';
		}

		// Check item by id
		if ( 'page' === $post_type && (int) get_the_ID() === (int) $item->object_id ) {
			return 'is-active';
		}

		// Check item by url
		if ( 'page' === $post_type && get_permalink() === $item->url ) {
			return 'is-active';
		}

		return '';
	}

	/**
	 * @used: Used for item with submenus to add "has-active" class if any child menu has "is-active" class
	 * Note: If parent page is active it will return "is-active" class
	 *
	 * @param WP_Post $item
	 * @return string
	 *
	 */
	public static function get_has_active_class( WP_Post $item ): string {
		if ( empty( $item->sub ) ) {
			return self::get_is_active_class( $item );
		}

		foreach ( $item->sub as $item_sub ) {
			if ( self::get_is_active_class( $item_sub ) ) {
				return 'has-active';
			}
		}

		return self::get_is_active_class( $item );
	}
}