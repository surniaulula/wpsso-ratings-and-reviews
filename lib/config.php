<?php
/*
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2014-2017 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRarConfig' ) ) {

	class WpssoRarConfig {

		public static $cf = array(
			'plugin' => array(
				'wpssorar' => array(
					'version' => '1.0.6',		// plugin version
					'opt_version' => '4',		// increment when changing default options
					'short' => 'WPSSO RAR',		// short plugin name
					'name' => 'WPSSO Ratings and Reviews',
					'desc' => 'WPSSO extension to add ratings and reviews for WordPress comments, with Aggregate Rating meta tags and optional Schema Review markup.',
					'slug' => 'wpsso-ratings-and-reviews',
					'base' => 'wpsso-ratings-and-reviews/wpsso-ratings-and-reviews.php',
					'update_auth' => '',
					'text_domain' => 'wpsso-ratings-and-reviews',
					'domain_path' => '/languages',
					'req' => array(
						'short' => 'WPSSO',
						'name' => 'WPSSO',
						'min_version' => '3.42.0',
					),
					'img' => array(
						'icons' => array(
							'low' => 'images/icon-128x128.png',
							'high' => 'images/icon-256x256.png',
						),
					),
					'lib' => array(
						// submenu items must have unique keys
						'submenu' => array (
							'rar-general' => 'Rating / Review',
						),
						'gpl' => array(
						),
						'pro' => array(
						),
					),
				),
			),
			'opt' => array(						// options
				'defaults' => array(
					'rar_add_to_attachment' => 0,
					'rar_add_to_page' => 1,
					'rar_add_to_post' => 0,
					'rar_add_to_product' => 1,
					'rar_rating_required' => 1,
					'rar_star_color_selected' => '#222222',
					'rar_star_color_default' => '#dddddd',
				),
			),
		);

		public static function get_version() { 
			return self::$cf['plugin']['wpssorar']['version'];
		}

		public static function set_constants( $plugin_filepath ) { 
			define( 'WPSSORAR_FILEPATH', $plugin_filepath );						
			define( 'WPSSORAR_PLUGINDIR', trailingslashit( realpath( dirname( $plugin_filepath ) ) ) );
			define( 'WPSSORAR_PLUGINSLUG', self::$cf['plugin']['wpssorar']['slug'] );		// wpsso-ratings-and-reviews
			define( 'WPSSORAR_PLUGINBASE', self::$cf['plugin']['wpssorar']['base'] );		// wpsso-ratings-and-reviews/wpsso-ratings-and-reviews.php
			define( 'WPSSORAR_URLPATH', trailingslashit( plugins_url( '', $plugin_filepath ) ) );
			self::set_variable_constants();
		}

		public static function set_variable_constants( $var_const = null ) {
			if ( $var_const === null )
				$var_const = self::get_variable_constants();
			foreach ( $var_const as $name => $value )
				if ( ! defined( $name ) )
					define( $name, $value );
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

			require_once WPSSORAR_PLUGINDIR.'lib/comment.php';
			require_once WPSSORAR_PLUGINDIR.'lib/filters.php';
			require_once WPSSORAR_PLUGINDIR.'lib/register.php';
			require_once WPSSORAR_PLUGINDIR.'lib/script.php';
			require_once WPSSORAR_PLUGINDIR.'lib/style.php';

			if ( is_admin() ) {
				require_once WPSSORAR_PLUGINDIR.'lib/admin.php';
			}

			add_filter( 'wpssorar_load_lib', array( 'WpssoRarConfig', 'load_lib' ), 10, 3 );
		}

		public static function load_lib( $ret = false, $filespec = '', $classname = '' ) {
			if ( $ret === false && ! empty( $filespec ) ) {
				$filepath = WPSSORAR_PLUGINDIR.'lib/'.$filespec.'.php';
				if ( file_exists( $filepath ) ) {
					require_once $filepath;
					if ( empty( $classname ) )
						return SucomUtil::sanitize_classname( 'wpssorar'.$filespec, false );	// $underscore = false
					else return $classname;
				}
			}
			return $ret;
		}
	}
}

?>
