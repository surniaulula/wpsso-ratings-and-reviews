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
		protected static $rating_cache = array();

		public function __construct( &$plugin ) {
			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			// called by comment-template.php to define text and html for the form
			add_filter( 'comment_form_defaults', array( __CLASS__, 'add_comment_form_defaults' ), 500 );

			// called for both front and back-end
			add_filter( 'comment_text', array( __CLASS__, 'add_rating_to_comment_text' ) );

			add_action( 'wp_update_comment_count', array( __CLASS__, 'clear_rating_post_meta' ) );
			add_action( 'comment_post', array( __CLASS__, 'save_request_comment_rating' ) );
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
			$disabled = isset( $wpsso->options['rar_add_to_'.$post_type.':is'] ) &&
				$wpsso->options['rar_add_to_'.$post_type.':is'] == 'disabled' ? true : false;

			if ( $disabled ) {
				$enabled = 0;
			} elseif ( ( $current = get_post_meta( $post_id, WPSSORAR_META_ALLOW_RATINGS, true ) ) === '' ) {
				$enabled = $default;
			} elseif ( empty( $current ) ) {
				$enabled = 0;
			} else {
				$enabled = 1;
			}

			return self::$rating_enabled[$post_id] = $enabled;
		}

		/*
		 * Update the title, comment field, and submit button to toggle review/comment labels.
		 */
		public static function add_comment_form_defaults( $defaults ) {

			if ( ! self::is_rating_enabled( get_the_ID() ) ) {
				return $defaults;
			}

			$is_reply = empty( $_GET['replytocom'] ) ? false : true;
			$is_req_span = ' <span class="required">*</span>';
			$rev_span_begin = '<span class="comment-toggle-review"'.
				( $is_reply ? ' style="display:none;"' : '' ).'>';
			$rev_span_end = '</span><!-- .comment-toggle-review -->';
			$cmt_span_begin = '<span class="comment-toggle-comment"'.
				( $is_reply ? '' : ' style="display:none;"' ).'>';
			$cmt_span_end = '</span><!-- .comment-toggle-comment -->';

			/*
			 * Title
			 */
			$defaults['title_reply_before'] = '<span class="wpsso-rar">'.
				$rev_span_begin.'<h3 id="review-title" class="comment-review-title">'.
					_x( 'Leave a Review', 'form label', 'wpsso-ratings-and-reviews' ).
						'</h3>'.$rev_span_end.$cmt_span_begin.$defaults['title_reply_before'];

			$defaults['title_reply_after'] .= $cmt_span_end.'</span><!-- .wpsso-rar -->';

			/*
			 * Comment Box
			 */
			$defaults['comment_field'] = preg_replace( '/(<label for="comment">.*<\/label>)/Uim',
				$rev_span_begin.'<label for="review">'._x( 'Your Review', 'form label', 'wpsso-ratings-and-reviews' ).
					$is_req_span.'</label>'.$rev_span_end.$cmt_span_begin.'$1'.$cmt_span_end,
						$defaults['comment_field'] );

			$defaults['comment_field'] = '<span class="wpsso-rar">'.
				self::get_form_rating_field().$defaults['comment_field'].
					'</span><!-- .wpsso-rar -->';

			/*
			 * Submit Button
			 */
			$defaults['submit_button'] = '<span class="wpsso-rar">'.$rev_span_begin.
				'<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="'.
					_x( 'Post Review', 'form label', 'wpsso-ratings-and-reviews' ).'" />'.
						$rev_span_end.$cmt_span_begin.$defaults['submit_button'].$cmt_span_end.
							'</span><!-- .wpsso-rar -->';

			return $defaults;
		}

		public static function get_form_rating_field() {

			$wpsso = Wpsso::get_instance();
			$is_required = empty( $wpsso->options['rar_rating_required'] ) ? false : true;
			$is_req_span = $is_required ? ' <span class="required">*</span>' : '';
			$is_reply = empty( $_GET['replytocom'] ) ? false : true;

			// auto-hide the paragraph for replies
			$select = '<p class="comment-form-rating"'.
				( $is_reply ? ' style="display:none;">' : '>' )."\n";

			// auto-disable the select for replies
			$select .= sprintf( '<label for="rating">%s'.$is_req_span.'</label>',
				_x( 'Your Rating', 'form label', 'wpsso-ratings-and-reviews' ) ).'
<select name="'.WPSSORAR_META_REVIEW_RATING.'" id="rating"'.( $is_reply ? ' disabled' : '' ).'">
	<option value="">' . _x( 'Rating&hellip;', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="5">' . _x( 'Excellent', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="4">' . _x( 'Good', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="3">' . _x( 'Average', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="2">' . _x( 'Not Good', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
	<option value="1">' . _x( 'Awful', 'option value', 'wpsso-ratings-and-reviews' ) . '</option>
</select></p>';

			return $select;
		}

		/*
		 * Save the rating value on comment submit, unless it's a reply (replies should not have ratings).
		 */
		public static function save_request_comment_rating( $comment_id ) { 
			if ( empty( $_GET['replytocom'] ) && empty( $_POST['replytocom'] ) ) {	// don't save reply ratings
				$rating_value = (int) SucomUtil::get_request_value( WPSSORAR_META_REVIEW_RATING, 'POST' );
				if ( $rating_value ) {
					add_comment_meta( $comment_id, WPSSORAR_META_REVIEW_RATING, $rating_value );
				}
			}
		}

		/*
		 * Append the rating value to the comment text. This filter is called on both the front and back-end.
		 */
		public static function add_rating_to_comment_text( $comment_text ) {

			// only add a single star rating (ours or from another plugin)
			if ( strpos( $comment_text, ' class="star-rating"' ) !== false ) {
				return $comment_text;
			}
			
			$comment_id = get_comment_ID();
			$comment_obj = get_comment( $comment_id );

			if ( empty( $comment_obj->comment_post_ID ) ||
				! self::is_rating_enabled( $comment_obj->comment_post_ID ) ) {
				return $comment_text;
			}

			$rating_value = get_comment_meta( $comment_id, WPSSORAR_META_REVIEW_RATING, true );

			if ( $rating_value ) {
				$comment_text = '<div class="wpsso-rar">'.
					self::get_star_rating_html( $rating_value ).
						'</div><!-- .wpsso-rar -->'.$comment_text;
			}

			return $comment_text;
		}

		/*
		 * Create the rating stars HTML for the rating value provided.
		 */
		public static function get_star_rating_html( $rating_value ) { 

			$html = ''; 
			$rating_value = (int) $rating_value;

			if ( ! empty( $rating_value ) ) { 
				$html = '<div class="star-rating" title="'.
					sprintf( __( 'Rated %d out of 5', 'wpsso-ratings-and-reviews' ), $rating_value ).'">'.
				'<span style="width:'.( ( $rating_value / 5 ) * 100 ).'%;">'.
					sprintf( __( 'Rated %d out of 5', 'wpsso-ratings-and-reviews' ), $rating_value ). 
				'</span></div>';
			}
			return $html;
		}

		public static function clear_rating_post_meta( $post_id ) {
			delete_post_meta( $post_id, WPSSORAR_META_AVERAGE_RATING );
			delete_post_meta( $post_id, WPSSORAR_META_RATING_COUNTS );
			delete_post_meta( $post_id, WPSSORAR_META_REVIEW_COUNT );
		}

		/*
		 * Average Rating
		 */
		public static function get_average_rating( $post_id ) {
			if ( ! metadata_exists( 'post', $post_id, WPSSORAR_META_AVERAGE_RATING ) ) {
				self::sync_average_rating( $post_id );	// calculate the average rating
			} 
			return (float) get_post_meta( $post_id, WPSSORAR_META_AVERAGE_RATING, true );
		}

		public static function sync_average_rating( $post_id ) {
			if ( $count_total = self::get_rating_count( $post_id ) ) {
				global $wpdb; 
				$rating_total = $wpdb->get_var( $wpdb->prepare( "
					SELECT SUM(meta_value) FROM $wpdb->commentmeta
					LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
					WHERE meta_key = 'rating'
					AND comment_post_ID = %d
					AND comment_parent = '0'
					AND comment_approved = '1'
					AND meta_value > 0", $post_id ) );
				$average = number_format( $rating_total / $count_total, 2, '.', '' );
			} else {
				$average = 0;
			}
			update_post_meta( $post_id, WPSSORAR_META_AVERAGE_RATING, $average );
		}

		/*
		 * Rating Count
		 */
		public static function get_rating_count( $post_id, $count_idx = null ) {
			if ( ! metadata_exists( 'post', $post_id, WPSSORAR_META_RATING_COUNTS ) ) {
				self::sync_rating_counts( $post_id );
			}
			$rating_counts = array_filter( (array) get_post_meta( $post_id, WPSSORAR_META_RATING_COUNTS, true ) );
			if ( $count_idx === null ) {
				return array_sum( $rating_counts );
			} else {
				return isset( $rating_counts[$count_idx] ) ?
					(int) $rating_counts[$count_idx] : 0;
			}
		}

		public static function sync_rating_counts( $post_id ) {
			global $wpdb;
			$count_meta = $wpdb->get_results( $wpdb->prepare( "
				SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_parent = '0'
				AND comment_approved = '1'
				AND meta_value > 0
				GROUP BY meta_value", $post_id ) );
			$rating_counts = array();
			foreach ( $count_meta as $count ) {
				$rating_counts[$count->meta_value] = $count->meta_value_count;
			}
			update_post_meta( $post_id, WPSSORAR_META_RATING_COUNTS, $rating_counts );
		}

		/*
		 * Review Count
		 */
		public static function get_review_count( $post_id ) {
			if ( ! metadata_exists( 'post', $post_id, WPSSORAR_META_REVIEW_COUNT ) ) {
				self::sync_review_count( $post_id );
			}
			return (int) get_post_meta( $post_id, WPSSORAR_META_REVIEW_COUNT, true );
		}

		public static function sync_review_count( $post_id ) {
			global $wpdb;
			$review_count = $wpdb->get_var( $wpdb->prepare( "
				SELECT COUNT(*) FROM $wpdb->comments
				WHERE comment_parent = 0
				AND comment_post_ID = %d
				AND comment_parent = '0'
				AND comment_approved = '1'", $post_id ) );
			update_post_meta( $post_id, WPSSORAR_META_REVIEW_COUNT, $review_count );
		}
	}
}

?>
