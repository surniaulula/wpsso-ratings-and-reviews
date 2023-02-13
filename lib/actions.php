<?php
/*
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2023 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRarActions' ) ) {

	class WpssoRarActions {

		private $p;	// Wpsso class object.
		private $a;	// WpssoRar class object.

		/*
		 * Instantiated by WpssoRar->init_objects().
		 */
		public function __construct( &$plugin, &$addon ) {

			static $do_once = null;

			if ( true === $do_once ) {

				return;	// Stop here.
			}

			$do_once = true;

			$this->p =& $plugin;
			$this->a =& $addon;

			$this->p->util->add_plugin_actions( $this, array(
				'clear_post_cache' => 2,
			) );
		}

		public function action_clear_post_cache( $post_id ) {

			WpssoRarComment::update_cache_post_meta( $post_id );
		}
	}
}
