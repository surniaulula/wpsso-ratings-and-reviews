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
 * Description: WPSSO Core extension to add ratings and reviews for WordPress comments, with Aggregate Rating meta tags and optional Schema Review markup.
 * Requires PHP: 5.4
 * Requires At Least: 3.8
 * Tested Up To: 4.9.4
 * WC Tested Up To: 3.3.1
 * Version: 1.3.0-b.1
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2017-2018 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRar' ) ) {

	class WpssoRar {

		/**
		 * Class Object Variables
		 */
		public $p;		// Wpsso
		public $reg;		// WpssoRarRegister
		public $admin;		// WpssoRarAdmin
		public $comment;	// WpssoRarComment
		public $filters;	// WpssoRarFilters
		public $script;		// WpssoRarScript
		public $style;		// WpssoRarStyle

		/**
		 * Reference Variables (config, options, modules, etc.).
		 */
		private $have_req_min = true;	// Have minimum wpsso version.

		private static $instance;

		public function __construct() {

			require_once ( dirname( __FILE__ ) . '/lib/config.php' );
			WpssoRarConfig::set_constants( __FILE__ );
			WpssoRarConfig::require_libs( __FILE__ );	// includes the register.php class library
			$this->reg = new WpssoRarRegister();		// activate, deactivate, uninstall hooks

			if ( is_admin() ) {
				add_action( 'admin_init', array( __CLASS__, 'required_check' ) );
			}

			add_action( 'wpsso_init_textdomain', array( __CLASS__, 'wpsso_init_textdomain' ) );
			add_filter( 'wpsso_get_config', array( &$this, 'wpsso_get_config' ), 10, 2 );
			add_action( 'wpsso_init_options', array( &$this, 'wpsso_init_options' ), 10 );
			add_action( 'wpsso_init_objects', array( &$this, 'wpsso_init_objects' ), 10 );
			add_action( 'wpsso_init_plugin', array( &$this, 'wpsso_init_plugin' ), 10 );
		}

		public static function &get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		public static function required_check() {
			if ( ! class_exists( 'Wpsso' ) ) {
				add_action( 'all_admin_notices', array( __CLASS__, 'required_notice' ) );
			}
		}

		// also called from the activate_plugin method with $deactivate = true
		public static function required_notice( $deactivate = false ) {

			self::wpsso_init_textdomain();

			$info = WpssoRarConfig::$cf['plugin']['wpssorar'];

			$die_msg = __( '%1$s is an extension for the %2$s plugin &mdash; please install and activate the %3$s plugin before activating %4$s.', 'wpsso-ratings-and-reviews' );

			$error_msg = __( 'The %1$s extension requires the %2$s plugin &mdash; install and activate the %3$s plugin or <a href="%4$s">deactivate the %5$s extension</a>.', 'wpsso-ratings-and-reviews' );

			if ( true === $deactivate ) {

				if ( ! function_exists( 'deactivate_plugins' ) ) {
					require_once trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin.php';
				}

				deactivate_plugins( $info['base'], true );	// $silent = true

				wp_die( '<p>' . sprintf( $die_msg, $info['name'], $info['req']['name'], $info['req']['short'], $info['short'] ) . '</p>' );

			} else {

				$deactivate_url = html_entity_decode( wp_nonce_url( add_query_arg( array(
					'action' => 'deactivate',
					'plugin' => $info['base'],
					'plugin_status' => 'all',
					'paged' => 1,
					's' => '',
				), admin_url( 'plugins.php' ) ), 'deactivate-plugin_' . $info['base'] ) );

				echo '<div class="notice notice-error error"><p>';
				echo sprintf( $error_msg, $info['name'], $info['req']['name'], $info['req']['short'], $deactivate_url, $info['short'] );
				echo '</p></div>';
			}
		}

		public static function wpsso_init_textdomain() {
			load_plugin_textdomain( 'wpsso-ratings-and-reviews', false, 'wpsso-ratings-and-reviews/languages/' );
		}

		public function wpsso_get_config( $cf, $plugin_version = 0 ) {

			$info = WpssoRarConfig::$cf['plugin']['wpssorar'];

			if ( version_compare( $plugin_version, $info['req']['min_version'], '<' ) ) {
				$this->have_req_min = false;
				return $cf;
			}

			return SucomUtil::array_merge_recursive_distinct( $cf, WpssoRarConfig::$cf );
		}

		public function wpsso_init_options() {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->have_req_min ) {
				$this->p->avail['p_ext']['rar'] = false;	// just in case
				return;	// stop here
			}

			$this->p->avail['p_ext']['rar'] = true;
		}

		public function wpsso_init_objects() {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->have_req_min ) {
				return;	// stop here
			}

			// disable reviews on products if competing feature exists
			if ( $this->p->avail['ecom']['woocommerce'] ) {
				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' || ! empty( $this->p->avail['ecom']['yotpowc'] ) ) {
					if ( ! empty( $this->p->options['rar_add_to_product'] ) ) {
						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'ratings feature for products found - ratings for the product post type disabled' );
						}
						if ( is_admin() ) {
							$this->p->notice->warn( sprintf( __( 'An existing products rating feature has been found &mdash; %1$s for the "product" custom post type has been disabled.', 'wpsso-ratings-and-reviews' ), $this->p->cf['plugin']['wpssorar']['short'] ) );
						}
						$this->p->options['rar_add_to_product'] = 0;
						$this->p->opt->save_options( WPSSO_OPTIONS_NAME, $this->p->options, false );
					}
					$this->p->options['rar_add_to_product:is'] = 'disabled';
				}
			}

			$this->comment = new WpssoRarComment( $this->p );
			$this->filters = new WpssoRarFilters( $this->p );
			$this->script = new WpssoRarScript( $this->p );
			$this->style = new WpssoRarStyle( $this->p );

			if ( is_admin() ) {
				$this->admin = new WpssoRarAdmin( $this->p );
			}
		}

		public function wpsso_init_plugin() {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->have_req_min ) {
				$this->min_version_notice();
				return;	// stop here
			}
		}

		private function min_version_notice() {

			$info = WpssoRarConfig::$cf['plugin']['wpssorar'];
			$have_version = $this->p->cf['plugin']['wpsso']['version'];

			$error_msg = sprintf( __( 'The %1$s version %2$s extension requires %3$s version %4$s or newer (version %5$s is currently installed).',
				'wpsso-ratings-and-reviews' ), $info['name'], $info['version'], $info['req']['short'], $info['req']['min_version'], $have_version );

			trigger_error( sprintf( __( '%s warning:', 'wpsso-ratings-and-reviews' ), $info['short'] ).' '.$error_msg, E_USER_WARNING );

			if ( is_admin() ) {
				$this->p->notice->err( $error_msg );
				if ( method_exists( $this->p->admin, 'get_check_for_updates_link' ) ) {
					$this->p->notice->inf( $this->p->admin->get_check_for_updates_link() );
				}
			}
		}
	}

	WpssoRar::get_instance();
}

