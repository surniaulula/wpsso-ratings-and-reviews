<?php
/*
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRarSubmenuRarGeneral' ) && class_exists( 'WpssoAdmin' ) ) {

	class WpssoRarSubmenuRarGeneral extends WpssoAdmin {

		public function __construct( &$plugin, $id, $name, $lib, $ext ) {
			$this->p =& $plugin;
			$this->menu_id = $id;
			$this->menu_name = $name;
			$this->menu_lib = $lib;
			$this->menu_ext = $ext;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}
		}

		protected function add_meta_boxes() {
			add_meta_box( $this->pagehook.'_general',
				_x( 'Ratings and Reviews', 'metabox title', 'wpsso-ratings-and-reviews' ), 
					array( &$this, 'show_metabox_general' ), $this->pagehook, 'normal' );
		}

		public function show_metabox_general() {
			$metabox = 'rar';
			$this->p->util->do_table_rows( apply_filters( $this->p->cf['lca'].'_'.$metabox.'_general_rows', 
				$this->get_table_rows( $metabox, 'general' ), $this->form ), 'metabox-'.$metabox.'-general' );
		}

		protected function get_table_rows( $metabox, $key ) {
			$table_rows = array();
			switch ( $metabox.'-'.$key ) {
				case 'rar-general':

					$table_rows['rar_add_to'] = $this->form->get_th_html( _x( 'Enable by Default for Post Types',
						'option label', 'wpsso-rar' ), '', 'rar_add_to' ).
					'<td>'.$this->form->get_post_type_checkboxes( 'rar_add_to' ).'</td>';

					break;
			}
			return $table_rows;
		}
	}
}

?>
