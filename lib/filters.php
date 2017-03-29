<?php
/*
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRarFilters' ) ) {

	class WpssoRarFilters {

		protected $p;

		public function __construct( &$plugin ) {
			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$this->p->util->add_plugin_filters( $this, array( 
				'get_defaults' => 1,
				'og' => 2,	// $mt_og, $mod
			) );
		}

		public function filter_get_defaults( $def_opts ) {
			$def_opts = $this->p->util->add_ptns_to_opts( $def_opts, 'rar_add_to', 0 );
			return $def_opts;
		}

		public function filter_og( array $mt_og, array $mod ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $mod['is_post'] || ! $mod['id'] ) {
				return $mt_og;
			} 
			
			if ( ! WpssoRarComment::is_rating_enabled( $mod['id'] ) ) {
				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'post id '.$mod['id'].' ratings disabled' );
				}
				return $mt_og;
			}

			$average_rating = WpssoRarComment::get_average_rating( $mod['id'] );
			$rating_count = WpssoRarComment::get_rating_count( $mod['id'] );
			$review_count = WpssoRarComment::get_review_count( $mod['id'] );

			if ( empty( $average_rating ) ) {
				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'post id '.$mod['id'].' average rating is empty' );
				}
			} elseif ( empty( $rating_count ) && empty( $review_count ) ) {
				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'post id '.$mod['id'].' rating and review counts empty' );
				}
			} else {
				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'adding average rating meta tags for post id '.$mod['id'] );
				}
				$og_type = $mt_og['og:type'];
		
				$mt_og[$og_type.':rating:average'] = $average_rating;
				$mt_og[$og_type.':rating:count'] = $rating_count;
				$mt_og[$og_type.':rating:worst'] = 1;
				$mt_og[$og_type.':rating:best'] = 5;
				$mt_og[$og_type.':review:count'] = $review_count;
			}

			return $mt_og;
		}
	}
}

?>
