<?php

namespace wsytesTheme\providers;


use jmucak\wpServiceManagerPack\helpers\CPTHelper;

class CPTProvider {
	const CPT_MOVIE = 'movie'; // Add cpt name, always should be singular name
	const CPT_ARTICLE = 'article';
	const RELATION_MOVIE = 'and';
	const RELATION_ARTICLE = 'or';
	const DOMAIN = 'wsytes'; // Change to your project name, used for translations
	const TAXONOMY_GENRE = 'genre'; // Add custom taxonomy name, always should be singular name
	const TAXONOMY_ARTICLE_CAT = 'article_cat'; // Add custom taxonomy name, always should be singular name

	public static function get_config() : array {
		return array(
			'post_types' => array(
				self::CPT_MOVIE   => self::get_movie_args(),
				self::CPT_ARTICLE => self::get_article_args(),
			),
			'taxonomies' => array(
				self::TAXONOMY_GENRE       => self::get_genre_args(),
				self::TAXONOMY_ARTICLE_CAT => self::get_article_category_args(),
			)
		);
	}


	// Settings for new custom post type
	public static function get_movie_args(): array {
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

	public static function get_article_args(): array {
		return array(
			'labels'              => CPTHelper::get_post_type_labels( 'Article', 'Articles', self::DOMAIN ),
			'description'         => '',
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'public'              => true,
			'show_ui'             => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
			'rewrite'             => array(
				'with_front' => false,
				'slug'       => self::CPT_ARTICLE,
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
			'post_types' => array( self::CPT_MOVIE ),
			'args'       => array(
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
			)
		);
	}

	public static function get_article_category_args(): array {
		return array(
			'post_types' => array( self::CPT_ARTICLE ),
			'args'       => array(
				'labels'             => CPTHelper::get_taxonomy_labels( 'Category', self::DOMAIN ),
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