<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2020 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRarScript' ) ) {

	class WpssoRarScript {

		protected $p;

		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ), WPSSO_ADMIN_SCRIPTS_PRIORITY );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		}

		public static function admin_enqueue_scripts( $hook_name ) {

			$plugin_version = WpssoRarConfig::get_version();

			/**
			 * Don't load our javascript where we don't need it.
			 */
			switch ( $hook_name ) {

				case 'edit.php':

					wp_enqueue_script( 'wpsso-rar-admin-script', 
						WPSSORAR_URLPATH.'js/admin-script.min.js', 
							array( 'jquery' ), $plugin_version, true );

					break;	// Stop here.
			}

		}

		public static function enqueue_scripts() {

			if ( ! WpssoRarComment::is_rating_enabled( get_the_ID() ) ) {

				return;
			}

			$plugin_version = WpssoRarConfig::get_version();

			wp_enqueue_script( 'wpsso-rar-script', 
				WPSSORAR_URLPATH.'js/script.min.js', 
					array( 'jquery' ), $plugin_version );

			wp_localize_script( 'wpsso-rar-script',
				'wpsso_rar_script', self::get_script_data() );
		}

		public static function get_script_data() {

			$wpsso = Wpsso::get_instance();

			$is_reply = empty( $_GET[ 'replytocom' ] ) ? false : true;

			return array(
				'i18n_required_rating_text' => esc_attr__( 'Please select a rating before submitting.', 'wpsso-ratings-and-reviews' ),
				'i18n_required_review_text' => esc_attr__( 'Please write a review before submitting.', 'wpsso-ratings-and-reviews' ),
				'review_rating_required'    => empty( $wpsso->options[ 'rar_rating_required' ] ) || $is_reply ? false : true,
			);
		}
	}
}
