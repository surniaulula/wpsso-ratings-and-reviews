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
		protected static $rating_enabled = array();

		public function __construct( &$plugin ) {
			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			// called by comment-template.php for both login form and logged-in users
			add_filter( 'comment_form_field_comment', array( __CLASS__, 'add_comment_form_html' ) );

			// called for both front and back-end
			add_filter( 'comment_text', array( __CLASS__, 'add_rating_to_comment_text' ) );

			add_action( 'comment_post', array( __CLASS__, 'save_request_comment_rating' ) );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );	// also enqueued by admin class
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		}

		/*
		 * Check if ratings are allowed for this post type.
		 */
		public static function is_rating_enabled( $post_id ) {

			if ( isset( self::$rating_enabled[$post_id] ) ) {	// use a status cache to optimize
				return self::$rating_enabled[$post_id];
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

			return self::$rating_enabled[$post_id] = $status;
		}

		/*
		 * Prepend the rating field to the comment textarea. Called for both the comment login form and logged-in users.
		 */
		public static function add_comment_form_html( $comment_textarea ) {

			$post_id = get_the_ID();

			if ( strpos( $comment_textarea, 'id="rating"' ) === false && self::is_rating_enabled( $post_id ) ) {

				// check for a reply argument when javascript is disabled
				$is_reply = empty( $_GET['replytocom'] ) ? false : true;

				// prepare the "review" label
				$review_label = sprintf( '<span class="comment-label-review"'.( $is_reply ? ' style="display:none;">' : '>' ).
					'<label for="review">%1$s <span class="required">*</span></label></span>',
						_x( 'Your Review', 'field label', 'wpsso-ratings-and-reviews' ) );

				// add a "review" label after the "comment" label and hide/show one or the other
				$comment_textarea = preg_replace( '/(<label for="comment">.*<\/label>)/Uim',
					'<span class="comment-label-comment"'.( $is_reply ? '>' : ' style="display:none;">' ).'$1</span>'.
						$review_label, $comment_textarea );

				// add the "rating" label and select
				$comment_textarea = '<div class="wpsso-rar">'.
					implode( "\n", self::get_extra_comment_fields() ).	// prepend the fields
						$comment_textarea.'</div>';
			}

			return $comment_textarea;
		}

		/*
		 * Prepend the rating field to a comment fields array.
		 */
		public static function get_extra_comment_fields( $form_fields = array() ) {

			$wpsso = Wpsso::get_instance();
			$is_required = empty( $wpsso->options['rar_rating_required'] ) ? false : true;
			$is_req_attr = $is_required ? ' aria-required="true" required="required"' : '';
			$is_req_span = $is_required ? ' <span class="required">*</span>' : '';
			$is_reply = empty( $_GET['replytocom'] ) ? false : true;

			$select = '<p class="comment-form-rating"'.
				( $is_reply ? ' style="display:none;">' : '>' )."\n";	// auto-hide for replies

			$select .= sprintf( '<label for="rating">%s'.$is_req_span.'</label>',
				_x( 'Your Rating', 'field label', 'wpsso-ratings-and-reviews' ) ).'
<select name="'.WPSSORAR_COMMENT_META_NAME.'" id="rating"'.$is_req_attr.'>
	<option value="">' . _x( 'Rating&hellip;', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="5">' . _x( 'Excellent', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="4">' . _x( 'Good', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="3">' . _x( 'Average', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="2">' . _x( 'Not Good', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="1">' . _x( 'Awful', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
</select></p>';

			// make the ratings field first
			$form_fields = array( 'rating' => $select ) + $form_fields;

			return $form_fields;
		}

		/*
		 * Save the rating value on comment submit, unless it's a reply (replies should not have ratings).
		 */
		public static function save_request_comment_rating( $comment_id ) { 

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
		public static function add_rating_to_comment_text( $comment_text ) {

			$comment_id = get_comment_ID();
			$comment_obj = get_comment( $comment_id );

			if ( ! empty( $comment_obj->comment_post_ID ) &&
				self::is_rating_enabled( $comment_obj->comment_post_ID ) ) {

				$rating = get_comment_meta( $comment_id, WPSSORAR_COMMENT_META_NAME, true );

				if ( $rating ) {
					$comment_text .= '<div class="wpsso-rar">'.	// append rating stars
						self::get_star_rating_html( $rating ).'</div>';
				}
			}
			return $comment_text;
		}

		/*
		 * Create the rating stars HTML for the rating value provided.
		 */
		public static function get_star_rating_html( $rating ) { 

			$html = ''; 
			$rating = (int) $rating;

			if ( ! empty( $rating ) ) { 
				$html = '<div class="star-rating" title="'.
					sprintf( __( 'Rated %d out of 5', 'wpsso-ratings-and-reviews' ), $rating ).'">'.
				'<span style="width:'.( ( $rating / 5 ) * 100 ).'%;">'.
					sprintf( __( 'Rated %d out of 5', 'wpsso-ratings-and-reviews' ), $rating ). 
				'</span></div>';
			}
			return $html;
		}

		public static function enqueue_styles() {

			if ( ! self::is_rating_enabled( get_the_ID() ) ) {
				return;
			}
			wp_enqueue_style( 'wpsso-rar-style', WPSSORAR_URLPATH.'css/style.min.css', array(), WpssoRarConfig::get_version() );
		}

		public static function enqueue_scripts() {

			if ( ! self::is_rating_enabled( get_the_ID() ) ) {
				return;
			}
			wp_enqueue_script( 'wpsso-rar-script', WPSSORAR_URLPATH.'js/script.min.js', array( 'jquery' ), WpssoRarConfig::get_version() );

			wp_localize_script( 'wpsso-rar-script', 'wpsso_rar_script', self::get_script_data() );
		}

		public static function get_script_data() {

			$wpsso = Wpsso::get_instance();

			return array(
				'i18n_required_rating_text' => esc_attr__( 'Please select a rating before submitting.', 'wpsso-ratings-and-reviews' ),
				'i18n_required_review_text' => esc_attr__( 'Please write a review before submitting.', 'wpsso-ratings-and-reviews' ),
				'review_rating_required'    => empty( $wpsso->options['rar_rating_required'] ) ? false : true,
			);
		}
	}
}

?>
