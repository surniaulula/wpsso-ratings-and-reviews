<?php
/*
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017 Jean-Sebastien Morisset (https://surniaulula.com/)
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

			add_action( 'admin_enqueue_scripts', array( 'WpssoRarStyle', 'enqueue_styles' ) );
			add_action( 'post_comment_status_meta_box-options', array( $this, 'add_rating_meta_option' ) );
            		add_action( 'save_post', array( $this, 'save_rating_meta_option' ), 10, 3);
		}

		public function add_rating_meta_option( $post ) {
			$post_type = get_post_type( $post->ID );
			$disabled = isset( $this->p->options['rar_add_to_'.$post_type.':is'] ) &&
				$this->p->options['rar_add_to_'.$post_type.':is'] == 'disabled' ? true : false;

			if ( ! $disabled ) {
				$rating_enabled = WpssoRarComment::is_rating_enabled( $post->ID );	// get current setting
				printf( '<br /><label for="%1$s"><input type="checkbox" id="%1$s" name="%1$s" class="selectit" %2$s/> %3$s</label>',
					WPSSORAR_META_ALLOW_RATINGS, checked( $rating_enabled, 1, false ), __( 'Allow ratings for reviews (comments).', 
						'wpsso-ratings-and-reviews' ) );
			}
		}

        	public function save_rating_meta_option( $post_id, $post, $update ) {
			if ( ! isset ( $_POST['post_type'] ) ) {
				return;
			} elseif ( ! current_user_can( 'edit_'.$_POST['post_type'], $post_id ) ) {
				return;
			} elseif ( isset ( $_POST[WPSSORAR_META_ALLOW_RATINGS] ) && 
				strtolower( $_POST[WPSSORAR_META_ALLOW_RATINGS] ) === 'on' ) {
				return update_post_meta( $post_id, WPSSORAR_META_ALLOW_RATINGS, 1 );
			} else {
				return update_post_meta( $post_id, WPSSORAR_META_ALLOW_RATINGS, 0 );
			}
		}
	}
}

?>
