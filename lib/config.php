<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2014-2019 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRarConfig' ) ) {

	class WpssoRarConfig {

		public static $cf = array(
			'plugin' => array(
				'wpssorar' => array(			// Plugin acronym.
					'version'     => '2.3.1-dev.3',	// Plugin version.
					'opt_version' => '6',		// Increment when changing default option values.
					'short'       => 'WPSSO RAR',	// Short plugin name.
					'name'        => 'WPSSO Ratings and Reviews',
					'desc'        => 'Ratings and reviews for WordPress comments with Aggregate Rating meta tags and Schema Review markup.',
					'slug'        => 'wpsso-ratings-and-reviews',
					'base'        => 'wpsso-ratings-and-reviews/wpsso-ratings-and-reviews.php',
					'update_auth' => '',
					'text_domain' => 'wpsso-ratings-and-reviews',
					'domain_path' => '/languages',
					'req'         => array(
						'short'       => 'WPSSO Core',
						'name'        => 'WPSSO Core',
						'min_version' => '6.6.1-dev.3',
					),
					'assets' => array(
						'icons' => array(
							'low'  => 'images/icon-128x128.png',
							'high' => 'images/icon-256x256.png',
						),
					),
					'lib' => array(
						'pro' => array(
						),
						'std' => array(
						),
						'submenu' => array(
							'rar-general' => 'Ratings / Reviews',
						),
					),
				),
			),
			'opt' => array(						// options
				'defaults' => array(
					'rar_add_to_attachment'       => 0,		// Rating Form for Post Types.
					'rar_add_to_page'             => 1,
					'rar_add_to_post'             => 0,
					'rar_add_to_product'          => 1,
					'rar_add_to_recipe'           => 1,
					'rar_rating_required'         => 1,		// Rating Required for Review.
					'rar_star_color_selected'     => '#222222',	// Selected Star Rating Color.
					'rar_star_color_default'      => '#dddddd',	// Unselected Star Rating Color.
					'plugin_avg_rating_col_media' => 0,
					'plugin_avg_rating_col_post'  => 1,
				),
			),
		);

		public static function get_version( $add_slug = false ) {

			$ext  = 'wpssorar';
			$info =& self::$cf[ 'plugin' ][$ext];

			return $add_slug ? $info[ 'slug' ] . '-' . $info[ 'version' ] : $info[ 'version' ];
		}

		public static function set_constants( $plugin_filepath ) { 

			if ( defined( 'WPSSORAR_VERSION' ) ) {	// Define constants only once.
				return;
			}

			define( 'WPSSORAR_FILEPATH', $plugin_filepath );						
			define( 'WPSSORAR_PLUGINBASE', self::$cf[ 'plugin' ][ 'wpssorar' ][ 'base' ] );		// wpsso-ratings-and-reviews/wpsso-ratings-and-reviews.php
			define( 'WPSSORAR_PLUGINDIR', trailingslashit( realpath( dirname( $plugin_filepath ) ) ) );
			define( 'WPSSORAR_PLUGINSLUG', self::$cf[ 'plugin' ][ 'wpssorar' ][ 'slug' ] );		// wpsso-ratings-and-reviews
			define( 'WPSSORAR_URLPATH', trailingslashit( plugins_url( '', $plugin_filepath ) ) );
			define( 'WPSSORAR_VERSION', self::$cf[ 'plugin' ][ 'wpssorar' ][ 'version' ] );						

			self::set_variable_constants();
		}

		public static function set_variable_constants( $var_const = null ) {

			if ( null === $var_const ) {
				$var_const = self::get_variable_constants();
			}

			foreach ( $var_const as $name => $value ) {
				if ( ! defined( $name ) ) {
					define( $name, $value );
				}
			}
		}

		public static function get_variable_constants() {

			$var_const = array();

			$var_const['WPSSORAR_META_REVIEW_RATING'] = 'rating';			// comment meta int
			$var_const['WPSSORAR_META_ALLOW_RATINGS'] = '_wpsso_allow_ratings';	// post meta 0/1
			$var_const['WPSSORAR_META_AVERAGE_RATING'] = '_wpsso_average_rating';	// post meta float
			$var_const['WPSSORAR_META_RATING_COUNTS'] = '_wpsso_rating_counts';	// post meta array
			$var_const['WPSSORAR_META_REVIEW_COUNT'] = '_wpsso_review_count';	// post meta int

			foreach ( $var_const as $name => $value ) {
				if ( defined( $name ) ) {
					$var_const[$name] = constant( $name );	// inherit existing values
				}
			}

			return $var_const;
		}

		public static function require_libs( $plugin_filepath ) {

			require_once WPSSORAR_PLUGINDIR . 'lib/comment.php';
			require_once WPSSORAR_PLUGINDIR . 'lib/filters.php';
			require_once WPSSORAR_PLUGINDIR . 'lib/register.php';
			require_once WPSSORAR_PLUGINDIR . 'lib/script.php';
			require_once WPSSORAR_PLUGINDIR . 'lib/style.php';

			if ( is_admin() ) {
				require_once WPSSORAR_PLUGINDIR . 'lib/admin.php';
			}

			add_filter( 'wpssorar_load_lib', array( 'WpssoRarConfig', 'load_lib' ), 10, 3 );
		}

		public static function load_lib( $ret = false, $filespec = '', $classname = '' ) {

			if ( false === $ret && ! empty( $filespec ) ) {

				$filepath = WPSSORAR_PLUGINDIR . 'lib/' . $filespec . '.php';

				if ( file_exists( $filepath ) ) {

					require_once $filepath;

					if ( empty( $classname ) ) {
						return SucomUtil::sanitize_classname( 'wpssorar' . $filespec, $allow_underscore = false );
					} else {
						return $classname;
					}
				}
			}

			return $ret;
		}
	}
}

