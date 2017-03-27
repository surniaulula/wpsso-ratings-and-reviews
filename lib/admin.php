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

			$this->add_actions();
		}

		public function add_actions() {
			add_action( 'admin_enqueue_scripts', array( 'WpssoRarComment', 'enqueue_styles' ) );
			add_action( 'post_comment_status_meta_box-options', array( $this, 'add_rating_meta_option' ) );
            		add_action( 'save_post', array( $this, 'save_rating_meta_option' ), 10, 3);
		}

		public function add_rating_meta_option( $post ) {

			$default = 1;

			// fetch the current value and perform some quick sanitation
            		if ( ( $current = get_post_meta( $post->ID, WPSSORAR_POST_META_NAME, true ) ) === '' ) {
				$current = $default;
			} elseif ( empty( $current ) ) {
				$current = 0;
			} else {
				$current = 1;
			}

			printf( '<br /><label for="%1$s"><input type="checkbox" id="%1$s" name="%1$s" class="selectit" %2$s/> %3$s</label>',
				WPSSORAR_POST_META_NAME, checked( 1, $current, false ), __( 'Allow ratings and comments as reviews.', 
					'wpsso-ratings-and-reviews' ) );
		}

        	public function save_rating_meta_option( $post_id, $post, $update ) {

			if ( ! isset ( $_POST['post_type'] ) ) {	// just in case
				return;
			}

			if ( ! current_user_can( 'edit_'.$_POST['post_type'], $post_id ) ) {	// just in case
				return;
			}

			if ( isset ( $_POST[WPSSORAR_POST_META_NAME] ) && strtolower( $_POST[WPSSORAR_POST_META_NAME] ) === 'on' ) {
				return update_post_meta( $post_id, WPSSORAR_POST_META_NAME, 1 );
			} else {
				return update_post_meta( $post_id, WPSSORAR_POST_META_NAME, 0 );
			}
		}
	}
}

?>
