<?php
/*
 * Plugin Name: WPSSO Ratings and Reviews
 * Plugin Slug: wpsso-ratings-and-reviews
 * Text Domain: wpsso-ratings-and-reviews
 * Domain Path: /languages
 * Plugin URI: https://wpsso.com/extend/plugins/wpsso-ratings-and-reviews/
 * Assets URI: https://jsmoriss.github.io/wpsso-ratings-and-reviews/assets/
 * Author: JS Morisset
 * Author URI: https://wpsso.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Adds Ratings and Reviews Features to the WordPress Comments System.
 * Requires Plugins: wpsso
 * Requires PHP: 7.4.33
 * Requires At Least: 5.9
 * Tested Up To: 6.7.0
 * WC Tested Up To: 9.3.3
 * Version: 3.2.0
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes and/or incompatible API changes (ie. breaking changes).
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2017-2024 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoAbstractAddOn' ) ) {

	require_once dirname( __FILE__ ) . '/lib/abstract/add-on.php';
}

if ( ! class_exists( 'WpssoRar' ) ) {

	class WpssoRar extends WpssoAbstractAddOn {

		protected $p;	// Wpsso class object.

		private static $instance  = null;	// WpssoRar class object.

		public function __construct() {

			parent::__construct( __FILE__, __CLASS__ );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init_textdomain() {

			load_plugin_textdomain( 'wpsso-ratings-and-reviews', false, 'wpsso-ratings-and-reviews/languages/' );
		}

		/*
		 * Called by Wpsso->set_objects() which runs at init priority 10.
		 */
		public function init_objects_preloader() {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( $this->get_missing_requirements() ) {	// Returns false or an array of missing requirements.

				return;	// Stop here.
			}

			/*
			 * Make sure there are no conflicting settings.
			 */
			if ( ! empty( $this->p->options[ 'plugin_ratings_reviews_svc' ] ) ) {

				if ( 'none' !== $this->p->options[ 'plugin_ratings_reviews_svc' ] ) {

					$this->init_textdomain();	// If not already loaded, load the textdomain now.

					$info = $this->cf[ 'plugin' ][ $this->ext ];

					$addon_name  = $info[ 'name' ];

					// translators: Please ignore - translation uses a different text domain.
					$option_label = _x( 'Ratings and Reviews Service', 'option label', 'wpsso' );

					$option_link = $this->p->util->get_admin_url( 'advanced#sucom-tabset_services-tab_ratings_reviews', $option_label );

					$notice_msg = sprintf( __( 'The %1$s add-on is not compatible with the %2$s option.', 'wpsso-ratings-and-reviews' ),
						$addon_name, $option_link ) . ' ';

					$notice_msg .= sprintf( __( 'You must either deactivate the %1$s add-on or disable the %2$s option.', 'wpsso-ratings-and-reviews' ),
						$addon_name, $option_link );

					$this->p->notice->err( $notice_msg );

					return;	// Stop here.
				}
			}

			new WpssoRarActions( $this->p, $this );
			new WpssoRarComment( $this->p, $this );
			new WpssoRarFilters( $this->p, $this );
			new WpssoRarScript( $this->p, $this );
			new WpssoRarStyle( $this->p, $this );

			if ( is_admin() ) {

				new WpssoRarAdmin( $this->p, $this );
			}
		}
	}

	WpssoRar::get_instance();
}
