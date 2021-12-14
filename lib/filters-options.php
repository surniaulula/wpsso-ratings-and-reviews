<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRarFiltersOptions' ) ) {

	class WpssoRarFiltersOptions {

		private $p;	// Wpsso class object.
		private $a;	// WpssoRar class object.

		/**
		 * Instantiated by WpssoRarFilters->__construct().
		 */
		public function __construct( &$plugin, &$addon ) {

			$this->p =& $plugin;
			$this->a =& $addon;

			$this->p->util->add_plugin_filters( $this, array( 
				'add_custom_post_type_names' => 1,
				'add_custom_taxonomy_names'  => 1,
			) );
		}

		public function filter_add_custom_post_type_names( $post_type_names ) {

			$post_type_names[ 'rar_add_to' ]            = 0;
			$post_type_names[ 'plugin_avg_rating_col' ] = 1;

			return $post_type_names;
		}

		public function filter_add_custom_taxonomy_names( $taxonomy_names ) {

			unset( $taxonomy_names[ 'plugin_avg_rating_col_tax' ] );

			return $taxonomy_names;
		}
	}
}
