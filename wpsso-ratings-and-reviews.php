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
 * Requires At Least: 4.4
 * Tested Up To: 5.5.1
 * WC Tested Up To: 4.5.2
 * Version: 2.11.0-dev.1
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

if ( ! class_exists( 'SucomAddOn' ) ) {

	require_once dirname( __FILE__ ) . '/lib/abstracts/com/add-on.php';	// SucomAddOn class.
}

if ( ! class_exists( 'WpssoRar' ) ) {

	class WpssoRar extends SucomAddOn {

		/**
		 * Library class object variables.
		 */
		public $admin;		// WpssoRarAdmin class.
		public $comment;	// WpssoRarComment class.
		public $filters;	// WpssoRarFilters class.
		public $script;		// WpssoRarScript class.
		public $style;		// WpssoRarStyle class.
		public $reg;		// WpssoRarRegister class.

		/**
		 * Reference Variables (config, options, modules, etc.).
		 */
		protected $p;
		protected $ext   = 'wpssorar';
		protected $p_ext = 'rar';
		protected $cf    = array();

		private static $instance  = null;

		public function __construct() {

			require_once dirname( __FILE__ ) . '/lib/config.php';

			WpssoRarConfig::set_constants( __FILE__ );

			WpssoRarConfig::require_libs( __FILE__ );	// Includes the register.php class library.

			$this->cf =& WpssoRarConfig::$cf;

			$this->reg = new WpssoRarRegister();		// Activate, deactivate, uninstall hooks.

			/**
			 * WPSSO filter hooks.
			 */
			add_filter( 'wpsso_get_config', array( $this, 'get_config' ), 10, 1 );
			add_filter( 'wpsso_get_avail', array( $this, 'get_avail' ), 10, 1 );

			/**
			 * WPSSO action hooks.
			 */
			add_action( 'wpsso_init_textdomain', array( $this, 'init_textdomain' ), 10, 1 );
			add_action( 'wpsso_init_objects', array( $this, 'init_objects' ), 10, 0 );
			add_action( 'wpsso_init_plugin', array( $this, 'init_missing_requirements' ), 10, 2 );

			/**
			 * WordPress action hooks.
			 */
			add_action( 'all_admin_notices', array( $this, 'show_missing_requirements' ) );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init_textdomain( $debug_enabled = false ) {

			static $local_cache = null;

			if ( null === $local_cache || $debug_enabled ) {

				$local_cache = 'wpsso-ratings-and-reviews';

				load_plugin_textdomain( 'wpsso-ratings-and-reviews', false, 'wpsso-ratings-and-reviews/languages/' );
			}

			return $local_cache;
		}

		public function init_objects() {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( $this->get_missing_requirements() ) {	// Returns false or an array of missing requirements.

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
	}

	WpssoRar::get_instance();
}
