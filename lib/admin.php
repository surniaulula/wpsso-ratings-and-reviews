<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2018 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRarAdmin' ) ) {

	class WpssoRarAdmin {

		protected $p;

		public function __construct( &$plugin ) {
			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$this->p->util->add_plugin_filters( $this, array(
				'get_sortable_columns' => 1,
			) );

			add_action( 'admin_enqueue_scripts', array( 'WpssoRarStyle', 'enqueue_styles' ) );
			add_action( 'post_comment_status_meta_box-options', array( $this, 'show_comment_metabox_option' ), 10, 1 );
			add_action( 'quick_edit_custom_box', array( $this, 'show_quick_edit_option' ), 10, 2 );
            		add_action( 'save_post', array( $this, 'save_rating_meta_option' ), 10, 3 );
		}

		public function filter_get_sortable_columns( $columns ) {
			return array_merge( array( 
				'avg_rating' => array(
					'header' => 'Rating',
					'meta_key' => WPSSORAR_META_AVERAGE_RATING,
					'orderby' => 'meta_value',
					'width' => '80px',
					'height' => 'auto',
				)
			), $columns );
		}

		public function show_quick_edit_option( $column_name, $post_type ) {

			static $nonce_added = null;

			if ( $nonce_added === null ) {
				wp_nonce_field( WpssoAdmin::get_nonce_action(), WPSSO_NONCE_NAME );	// WPSSO_NONCE_NAME is an md5() string
				$nonce_added = true;
			}

			if ( $column_name !== 'wpsso_avg_rating' ) {
				return;
			}

			$label = __( 'Allow ratings for reviews (comments).', 'wpsso-ratings-and-reviews' );

			echo '<fieldset class="inline-edit-col-right quick-edit-rating">';
			echo '<div class="inline-edit-col quick-edit-' . $column_name . '">';
			echo '<div class="inline-edit-group">';
			echo '<label class="alignleft">';
			printf( '<input type="hidden" name="is_checkbox_%1$s" value="1"/>' .
				'<input type="checkbox" id="%1$s" name="%1$s" class="selectit"/>',
					WPSSORAR_META_ALLOW_RATINGS );
			echo '<span class="checkbox-title">' . $label . '</span>';
			echo '</label>';
			echo '</div>';
			echo '</div>';
			echo '</fieldset>';
		}

		public function show_comment_metabox_option( $post_obj ) {

			if ( ! is_object( $post_obj ) ) {	// just in case
				return;
			}

			$post_type = get_post_type( $post_obj->ID );
			$disabled = isset( $this->p->options['rar_add_to_' . $post_type . ':is'] ) &&
				$this->p->options['rar_add_to_' . $post_type . ':is'] == 'disabled' ? true : false;
			$label = __( 'Allow ratings for reviews (comments).', 'wpsso-ratings-and-reviews' );

			if ( ! $disabled ) {
				$allow_ratings = WpssoRarComment::is_rating_enabled( $post_obj->ID );	// get current setting
				printf( '<br /><label for="%1$s"><input type="hidden" name="is_checkbox_%1$s" value="1"/>' .
					'<input type="checkbox" id="%1$s" name="%1$s" class="selectit" %2$s/> %3$s</label>',
						WPSSORAR_META_ALLOW_RATINGS, checked( $allow_ratings, 1, false ), $label );
			}
		}

        	public function save_rating_meta_option( $post_id, $post_obj, $update ) {
			if ( isset ( $_POST['post_type'] ) && current_user_can( 'edit_' . $_POST['post_type'], $post_id ) ) {
				if ( ! empty( $_POST['is_checkbox_'.WPSSORAR_META_ALLOW_RATINGS] ) ) {
					if ( ! empty( $_POST[WPSSORAR_META_ALLOW_RATINGS] ) && strtolower( $_POST[WPSSORAR_META_ALLOW_RATINGS] ) === 'on' ) {
						update_post_meta( $post_id, WPSSORAR_META_ALLOW_RATINGS, 1 );
					} else {
						update_post_meta( $post_id, WPSSORAR_META_ALLOW_RATINGS, 0 );
					}
				}
			}
		}
	}
}

