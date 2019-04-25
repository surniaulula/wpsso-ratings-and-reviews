<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2019 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRarSubmenuRarGeneral' ) && class_exists( 'WpssoAdmin' ) ) {

	class WpssoRarSubmenuRarGeneral extends WpssoAdmin {

		public function __construct( &$plugin, $id, $name, $lib, $ext ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$this->menu_id   = $id;
			$this->menu_name = $name;
			$this->menu_lib  = $lib;
			$this->menu_ext  = $ext;
		}

		/**
		 * Called by the extended WpssoAdmin class.
		 */
		protected function add_meta_boxes() {

			$metabox_id      = 'general';
			$metabox_title   = _x( 'Ratings and Reviews', 'metabox title', 'wpsso-ratings-and-reviews' );
			$metabox_screen  = $this->pagehook;
			$metabox_context = 'normal';
			$metabox_prio    = 'default';
			$callback_args   = array(	// Second argument passed to the callback function / method.
			);

			add_meta_box( $this->pagehook . '_' . $metabox_id, $metabox_title,
				array( $this, 'show_metabox_general' ), $metabox_screen,
					$metabox_context, $metabox_prio, $callback_args );
		}

		public function show_metabox_general() {
			$metabox_id = 'rar';
			$this->p->util->do_metabox_table( apply_filters( $this->p->lca . '_' . $metabox_id . '_general_rows', 
				$this->get_table_rows( $metabox_id, 'general' ), $this->form ), 'metabox-'.$metabox_id.'-general' );
		}

		protected function get_table_rows( $metabox_id, $tab_key ) {

			$table_rows = array();

			switch ( $metabox_id.'-'.$tab_key ) {

				case 'rar-general':

					$json_req_msg = $this->p->admin->get_ext_required_msg( 'json' );
					$json_disable = empty( $json_req_msg ) ? false : true;

					$table_rows[ 'rar_add_to' ] = $this->form->get_th_html( _x( 'Enable by Default for Post Types',
						'option label', 'wpsso-ratings-and-reviews' ), '', 'rar_add_to' ).
					'<td>'.$this->form->get_checklist_post_types( 'rar_add_to' ).'</td>';

					$table_rows[ 'rar_rating_required' ] = $this->form->get_th_html( _x( 'Rating Required to Submit Review',
						'option label', 'wpsso-ratings-and-reviews' ), '', 'rar_rating_required' ).
					'<td>'.$this->form->get_checkbox( 'rar_rating_required' ).'</td>';

					$table_rows[ 'rar_star_color_selected' ] = $this->form->get_th_html( _x( 'Selected Star Rating Color',
						'option label', 'wpsso-ratings-and-reviews' ), '', 'rar_star_color_selected' ).
					'<td>'.$this->form->get_input_color( 'rar_star_color_selected' ).'</td>';

					$table_rows[ 'rar_star_color_default' ] = $this->form->get_th_html( _x( 'Unselected Star Rating Color',
						'option label', 'wpsso-ratings-and-reviews' ), '', 'rar_star_color_default' ).
					'<td>'.$this->form->get_input_color( 'rar_star_color_default' ).'</td>';

					$table_rows[ 'rar_add_5_star_rating' ] = '' .
					$this->form->get_th_html( _x( 'Add Schema 5 Star Rating If None',
						'option label', 'wpsso-ratings-and-reviews' ), '', 'rar_add_5_star_rating' ) . 
					'<td>' . $this->form->get_checkbox( 'schema_add_5_star_rating',
						'', '', $json_disable ) . $json_req_msg . '</td>';

					break;
			}

			return $table_rows;
		}
	}
}
