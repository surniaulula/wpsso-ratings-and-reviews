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
		protected static $status_cache = array();

		public function __construct( &$plugin ) {
			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			// called by comment-template.php for both login form and logged-in users
			add_filter( 'comment_form_field_comment', array( __CLASS__, 'add_comment_form_html' ) );

			// called for both front and back-end
			add_filter( 'comment_text', array( __CLASS__, 'add_comment_text_rating' ) );

			add_action( 'comment_post', array( __CLASS__, 'save_comment_rating' ) );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );	// also enqueued by admin class
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		}

		/*
		 * Check if ratings are allowed for this post type.
		 */
		public static function is_rating_enabled( $post_id ) {
			if ( isset( self::$status_cache[$post_id] ) ) {	// use a status cache to optimize
				return self::$status_cache[$post_id];
			}

			$wpsso = Wpsso::get_instance();
			$post_type = get_post_type( $post_id );
			$default = empty( $wpsso->options['rar_add_to_'.$post_type] ) ? 0 : 1;

			if ( ( $current = get_post_meta( $post_id, WPSSORAR_POST_META_NAME, true ) ) === '' ) {
				$status = $default;
			} elseif ( empty( $current ) ) {
				$status = 0;
			} else {
				$status = 1;
			}

			return self::$status_cache[$post_id] = $status;
		}

		/*
		 * Prepend the rating field to the comment textarea. Called for both the comment login form and logged-in users.
		 */
		public static function add_comment_form_html( $comment_textarea ) {
			$post_id = get_the_ID();

			if ( self::is_rating_enabled( $post_id ) ) {
				$comment_textarea = implode( "\n", self::add_comment_rating_field() ).	// prepend
					$comment_textarea;
			}

			return $comment_textarea;
		}

		/*
		 * Prepend the rating field to a comment fields array.
		 */
		public static function add_comment_rating_field( $form_fields = array() ) {
			$select = '<p class="comment-form-rating"'.
				( empty( $_GET['replytocom'] ) ?	// auto-hide rating select for replies
					'>' : ' style="display:none;">' );

			$select .= sprintf( '<label for="rating">%s</label>',
				_x( 'Rating', 'field label', 'wpsso-ratings-and-reviews' ) ).
					' '.'<select id="rating" name="'.WPSSORAR_COMMENT_META_NAME.'">';

			$select .= '<option value=""></option>';	// do not select a rating by default
			for( $i = 1; $i <= 5; $i++ ) {
				$select .= '<option'.( $i ? '' : ' disabled selected' ).
					' value="'.$i.'">'.$i.'</option>';
			}
			$select .= '</select></p>';

			// make the ratings field first
			$form_fields = array( 'rating' => $select ) + $form_fields;

			return $form_fields;
		}

		/*
		 * Save the rating value on comment submit, unless it's a reply (replies should not have ratings).
		 */
		public static function save_comment_rating( $comment_id ) { 
			if ( empty( $_GET['replytocom'] ) && empty( $_POST['replytocom'] ) ) {	// don't save reply ratings

				$rating = (int) SucomUtil::get_request_value( WPSSORAR_COMMENT_META_NAME, 'POST' );

				if ( $rating ) {
					add_comment_meta( $comment_id, WPSSORAR_COMMENT_META_NAME, $rating );
				}
			}
		}

		/*
		 * Append the rating value to the comment text. This filter is called on both the front and back-end.
		 */
		public static function add_comment_text_rating( $comment_text ) {
			$comment_id = get_comment_ID();
			$comment_obj = get_comment( $comment_id );

			if ( ! empty( $comment_obj->comment_post_ID ) &&
				self::is_rating_enabled( $comment_obj->comment_post_ID ) ) {

				$rating = get_comment_meta( $comment_id, WPSSORAR_COMMENT_META_NAME, true );

				if ( $rating ) {
					$comment_text .= '<p class="comment-text-rating">'.	// append rating stars
						self::get_rating_stars_html( $rating ).'</p>';
				}
			}
			return $comment_text;
		}

		/*
		 * Create the rating stars HTML for the rating value provided.
		 */
		public static function get_rating_stars_html( $rating ) { 
			$html = ''; 
			if ( ! empty( $rating ) ) { 
				$html = '<span class="rating-stars">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$html .= '<i class="fa fa-star'.
						( $i <= $rating ? ' rated' : '-o' ).'"></i>';
				} 
				$html .= '</span>';
			}
			return $html;
		}

		/*
		 * Enqueue the Font Awesome styles. Also hooked by the WpssoRarAdmin class for the back-end.
		 */
		public static function enqueue_styles() {
			if ( ! self::is_rating_enabled( get_the_ID() ) ) {
				return;
			}

			/*
			 * Font Awesome
			 */
			wp_enqueue_style( 'fontawesome', WPSSORAR_URLPATH.'css/font-awesome.min.css', array(), '4.7.0' ); 

			/*
			 * jQuery Bar Rating Theme
			 */
			wp_enqueue_style( 'bar-rating-theme', WPSSORAR_URLPATH.'css/themes/fontawesome-stars-o.min.css', array(), '1.2.2' ); 

			/*
			 * Custom Styles
			 */
			wp_enqueue_style( 'wpsso-rar-style', WPSSORAR_URLPATH.'css/style.min.css', array(), WpssoRarConfig::get_version() );
		}

		/*
		 * Enqueue the BarRating jQuery scripts.
		 */
		public static function enqueue_scripts() {
			if ( ! self::is_rating_enabled( get_the_ID() ) ) {
				return;
			}

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
