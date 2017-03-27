<?php
/*
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRarComment' ) ) {

	class WpssoRarComment {

		protected $p;

		public function __construct( &$plugin ) {
			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$this->add_actions();
			$this->add_filters();
		}

		public function add_actions() {
			add_action( 'comment_form_logged_in_before', array( $this, 'show_comment_rating_select' ) );
			add_action( 'comment_form_top', array( $this, 'show_comment_rating_select' ) );
			add_action( 'comment_post', array( $this, 'save_comment_rating' ) );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );	// also enqueued by admin
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		}

		public function add_filters() {
			add_filter( 'comment_text', array( $this, 'add_comment_text_rating' ) );	// filters front and back-end
		}

		public function show_comment_rating_select() {
			echo '<div class="wpsso-rar comment-form"'.
				( empty( $_GET['replytocom'] ) ? '' : ' style="display:none;"' ).	// hide rating select for replies
					'><select id="rating-select" name="'.WPSSORAR_COMMENT_META_NAME.'">';
			echo '<option value=""></option>';	// do not select a rating by default
			for( $i = 1; $i <= 5; $i++ ) {
				echo '<option'.( $i ? '' : ' disabled selected' ).
					' value="'.$i.'">'.$i.'</option>';
			}
			echo '</select></div>';
		}

		public function save_comment_rating( $comment_id ) { 
			if ( empty( $_GET['replytocom'] ) && empty( $_POST['replytocom'] ) ) {	// don't save reply ratings
				if ( ( $rating = (int) SucomUtil::get_request_value( WPSSORAR_COMMENT_META_NAME, 'POST' ) ) > 0 ) {
					add_comment_meta( $comment_id, WPSSORAR_COMMENT_META_NAME, $rating );
				}
			}
		}

		// filter is called on both the front-end and the admin back-end
		public function add_comment_text_rating( $comment ) {
			if ( $rating = get_comment_meta( get_comment_ID(), WPSSORAR_COMMENT_META_NAME, true ) ) {
				$comment .= '<div class="wpsso-rar comment-rating">'.
					$this->get_rating_stars_html( $rating ).'</div>';
			}
			return $comment;
		}

		public function get_rating_stars_html( $rating ) { 
			$html = ''; 
			if ( ! empty( $rating ) ) { 
				$html = '<span class="rating-stars">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$html .= '<i class="fa fa-star-o'.( $i <= $rating ? ' rated' : '' ).'"></i>';
				} 
				$html .= '</span>';
			}
			return $html;
		}

		// also enqueued by the WpssoRarAdmin class
		public static function enqueue_styles() {
			/*
			 * Font Awesome
			 */
			wp_enqueue_style( 'fontawesome', WPSSORAR_URLPATH.'css/font-awesome.min.css', array(), '4.7.0' ); 
			
			/*
			 * jQuery Bar Rating Theme
			 */
			wp_enqueue_style( 'bar-rating-theme', WPSSORAR_URLPATH.'css/themes/fontawesome-stars.min.css', array(), '1.2.2' ); 
			
			/*
			 * Custom Styles
			 */
			wp_enqueue_style( 'wpsso-rar-style', WPSSORAR_URLPATH.'css/style.min.css', array(), WpssoRarConfig::get_version() );
		}

		public static function enqueue_scripts() {
			/*
			 * jQuery Bar Rating
			 *	http://antenna.io/demo/jquery-bar-rating/examples/
			 *	https://github.com/antennaio/jquery-bar-rating
			 */
			wp_enqueue_script( 'bar-rating', WPSSORAR_URLPATH.'js/jquery.barrating.min.js', array( 'jquery' ), '1.2.2' );

			/*
			 * Custom jQuery
			 */
			wp_enqueue_script( 'wpsso-rar-script', WPSSORAR_URLPATH.'js/script.min.js', array( 'jquery' ), WpssoRarConfig::get_version() );
		}
	}
}

?>
