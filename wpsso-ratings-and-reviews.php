<?php
/**
 * Plugin Name: WPSSO Ratings and Reviews
 * Plugin Slug: wpsso-ratings-and-reviews
 * Text Domain: wpsso-ratings-and-reviews
 * Domain Path: /languages
 * Plugin URI: https://wpsso.com/extend/plugins/wpsso-ratings-and-reviews/
 * Assets URI: https://jsmoriss.github.io/wpsso-ratings-and-reviews/assets/
 * Author: JS Morisset
 * Author URI: https://wpsso.com/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl.txt
 * Description: Ratings and Reviews for WordPress Comments with Schema Aggregate Rating and Schema Review Markup.
 * Requires PHP: 5.6
 * Requires At Least: 4.2
 * Tested Up To: 5.4.1
 * WC Tested Up To: 4.1.0
 * Version: 2.8.0-dev.3
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2017-2020 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRar' ) ) {

	class WpssoRar {

		/**
		 * Wpsso plugin class object variable.
		 */
		public $p;		// Wpsso

		/**
		 * Library class object variables.
		 */
		public $admin;		// WpssoRarAdmin
		public $comment;	// WpssoRarComment
		public $filters;	// WpssoRarFilters
		public $script;		// WpssoRarScript
		public $style;		// WpssoRarStyle
		public $reg;		// WpssoRarRegister

		/**
		 * Reference Variables (config, options, modules, etc.).
		 */
		private static $ext           = 'wpssorar';
		private static $p_ext         = 'rar';
		private static $notices_shown = false;
		private static $instance      = null;

		public function __construct() {

			require_once dirname( __FILE__ ) . '/lib/config.php';

			WpssoRarConfig::set_constants( __FILE__ );

			WpssoRarConfig::require_libs( __FILE__ );	// Includes the register.php class library.

			$this->reg = new WpssoRarRegister();		// Activate, deactivate, uninstall hooks.

			/**
			 * Add WPSSO filter hooks.
			 */
			add_filter( 'wpsso_get_config', array( __CLASS__, 'wpsso_get_config' ), 10, 2 );
			add_filter( 'wpsso_get_avail', array( __CLASS__, 'wpsso_get_avail' ), 10, 1 );

			/**
			 * Add WPSSO action hooks.
			 */
			add_action( 'wpsso_init_textdomain', array( __CLASS__, 'wpsso_init_textdomain' ) );
			add_action( 'wpsso_init_objects', array( $this, 'wpsso_init_objects' ), 10 );
			add_action( 'wpsso_init_plugin', array( $this, 'wpsso_init_plugin' ), 10 );

			/**
			 * WordPress action hooks.
			 */
			add_action( 'all_admin_notices', array( __CLASS__, 'maybe_show_notices' ) );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Checks the core plugin version and merges the extension / add-on config array.
		 */
		public static function wpsso_get_config( $cf, $plugin_version = 0 ) {

			if ( self::get_missing_requirements() ) {	// Returns false or an array of missing requirements.

				return $cf;	// Stop here.
			}

			return SucomUtil::array_merge_recursive_distinct( $cf, WpssoRarConfig::$cf );
		}

		/**
		 * The 'wpsso_get_avail' filter is run after the $check property is defined.
		 */
		public static function wpsso_get_avail( $avail ) {

			if ( self::get_missing_requirements() ) {		// Returns false or an array of missing requirements.

				$avail[ 'p_ext' ][ self::$p_ext ] = false;	// Signal that this extension / add-on is not available.

				return $avail;
			}

			$avail[ 'p_ext' ][ self::$p_ext ] = true;		// Signal that this extension / add-on is available.

			return $avail;
		}

		/**
		 * The 'wpsso_init_textdomain' action is run after the $check, $avail, and $debug properties are defined.
		 */
		public static function wpsso_init_textdomain( $debug_enabled = false ) {

			static $loaded = null;

			if ( null !== $loaded ) {
				return;
			}

			$loaded = true;

			load_plugin_textdomain( 'wpsso-ratings-and-reviews', false, 'wpsso-ratings-and-reviews/languages/' );
		}

		public function wpsso_init_objects() {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( self::get_missing_requirements() ) {	// Returns false or an array of missing requirements.

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: have missing requirements' );
				}

				return;	// Stop here.
			}

			/**
			 * Disable reviews on products if competing feature exists.
			 */
			if ( $this->p->avail[ 'ecom' ][ 'woocommerce' ] ) {

				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {

					if ( ! empty( $this->p->options[ 'rar_add_to_product' ] ) ) {

						$this->p->options[ 'rar_add_to_product' ] = 0;

						$this->p->opt->save_options( WPSSO_OPTIONS_NAME, $this->p->options, $network = false );
					}

					$this->p->options[ 'rar_add_to_product:is' ] = 'disabled';
				}
			}

			$this->comment = new WpssoRarComment( $this->p );
			$this->filters = new WpssoRarFilters( $this->p );
			$this->script  = new WpssoRarScript( $this->p );
			$this->style   = new WpssoRarStyle( $this->p );

			if ( is_admin() ) {
				$this->admin = new WpssoRarAdmin( $this->p );
			}
		}

		/**
		 * All WPSSO objects are instantiated and configured.
		 */
		public function wpsso_init_plugin() {

			$missing_reqs = self::get_missing_requirements();	// Returns false or an array of missing requirements.

			if ( ! $missing_reqs ) {

				return;	// Stop here.
			}

			foreach ( $missing_reqs as $key => $req_info ) {

				if ( ! empty( $req_info[ 'notice' ] ) ) {

					$this->p->notice->err( $req_info[ 'notice' ] );
				}
			}

			self::$notices_shown = true;
		}

		public static function maybe_show_notices() {

			if ( self::$notices_shown ) {	// Nothing to do.
				return;
			}

			$missing_reqs = self::get_missing_requirements();	// Returns false or an array of missing requirements.

			if ( ! $missing_reqs ) {

				return;	// Stop here.
			}

			foreach ( $missing_reqs as $key => $req_info ) {

				if ( ! empty( $req_info[ 'notice' ] ) ) {

					echo '<div class="notice notice-error error"><p>';
					echo $req_info[ 'notice' ];
					echo '</p></div>';
				}
			}
		}

		/**
		 * Returns false or an array of the missing requirements (ie. 'wpsso', 'woocommerce', etc.).
		 */
		private static function get_missing_requirements() {

			static $local_cache = null;

			if ( null !== $local_cache ) {
				return $local_cache;
			}

			$local_cache = array();

			self::wpsso_init_textdomain();	// If not already loaded, load the textdomain now.

			$info = WpssoRarConfig::$cf[ 'plugin' ][ self::$ext ];

			$notice_missing_transl = __( 'The %1$s version %2$s add-on requires the %3$s plugin &mdash; please activate the missing plugin.',
				'wpsso-ratings-and-reviews' );

			$notice_version_transl = __( 'The %1$s version %2$s add-on requires the %3$s version %4$s plugin or newer (version %5$s is currently installed).',
				'wpsso-ratings-and-reviews' );

			foreach ( $info[ 'req' ] as $key => $req_info ) {

				if ( ! empty( $req_info[ 'home' ] ) ) {
					$req_name = '<a href="' . $req_info[ 'home' ] . '">' . $req_info[ 'name' ] . '</a>';
				} else {
					$req_name = $req_info[ 'name' ];
				}

				if ( ! empty( $req_info[ 'class' ] ) ) {

					if ( ! class_exists( $req_info[ 'class' ] ) ) {

						$req_info[ 'notice' ] = sprintf( $notice_missing_transl, $info[ 'name' ], $info[ 'version' ], $req_name );
					}
				}


				if ( ! empty( $req_info[ 'version_const' ] ) ) {

					if ( defined( $req_info[ 'version_const' ] ) ) {

						$req_info[ 'version' ] = constant( $req_info[ 'version_const' ] );

						if ( ! empty( $req_info[ 'min_version' ] ) ) {

							if ( version_compare( $req_info[ 'version' ], $req_info[ 'min_version' ], '<' ) ) {

								$req_info[ 'notice' ] = sprintf( $notice_version_transl, $info[ 'name' ], $info[ 'version' ],
									$req_name, $req_info[ 'min_version' ], $req_info[ 'version' ] );
							}
						}
					}
				}

				if ( ! empty( $req_info[ 'notice' ] ) ) {

					$local_cache[ $key ] = $req_info;
				}
			}

			if ( empty( $local_cache ) ) {

				$local_cache = false;
			}

			return $local_cache;
		}
	}

	WpssoRar::get_instance();
}
