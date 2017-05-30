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

			if ( is_admin() ) {
				$this->p->util->add_plugin_filters( $this, array( 
					'messages_tooltip' => 2,		// tooltip messages filter
				) );
			}
		}

		public function filter_get_defaults( $def_opts ) {
			$def_opts = $this->p->util->add_ptns_to_opts( $def_opts, 'rar_add_to', 0 );
			return $def_opts;
		}

		// use 'og' filter instead of the 'og_seed' filter to get the og:type meta tag value
		public function filter_og( array $mt_og, array $mod ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $mod['is_post'] || ! $mod['id'] ) {	// make sure we have a valid post id
				return $mt_og;
			} 
			
			if ( ! WpssoRarComment::is_rating_enabled( $mod['id'] ) ) {
				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'post id '.$mod['id'].' ratings disabled' );
				}
				return $mt_og;
			}

			$lca = $this->p->cf['lca'];
			$og_type = $mt_og['og:type'];

			if ( apply_filters( $lca.'_og_add_mt_rating', true, $mod ) ) {	// enabled by default
				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'add rating meta tags is true' );
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
					$mt_og[$og_type.':rating:average'] = number_format( (float) $average_rating, 2, '.', '' );
					$mt_og[$og_type.':rating:count'] = $rating_count;
					$mt_og[$og_type.':rating:worst'] = 1;
					$mt_og[$og_type.':rating:best'] = 5;
					$mt_og[$og_type.':review:count'] = $review_count;
				}
			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'add rating meta tags is false' );
			}

			if ( apply_filters( $lca.'_og_add_mt_reviews', false, $mod ) ) {	// disabled by default
				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'add review meta tags is true' );
				}
				$mt_og[$og_type.':reviews'] = $mod['obj']->get_og_type_reviews( $mod['id'], $og_type, 'rating' );
			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'add review meta tags is false' );
			}

			return $mt_og;
		}

		public function filter_messages_tooltip( $text, $idx ) {
			if ( strpos( $idx, 'tooltip-rar_' ) !== 0 )
				return $text;

			switch ( $idx ) {
				case 'tooltip-rar_add_to':
					$text = __( 'You can choose to enable or disable ratings by default for each public post type.', 'wpsso-ratings-and-reviews' ).' ';
					$text .= sprintf( __( 'When editing a post (page, or custom post type), an "%1$s" option is also available to enable or disable ratings for that specific webpage.', 'wpsso-ratings-and-reviews' ), __( 'Allow ratings for reviews (comments).', 'wpsso-ratings-and-reviews' ) );
					break;
				case 'tooltip-rar_rating_required':
					$text = __( 'Force a reviewer to select a rating before submitting their review (enabled by default).', 'wpsso-ratings-and-reviews' );
					break;
				case 'tooltip-rar_star_color_selected':
					$text = __( 'A color for selected stars representing the rating.', 'wpsso-ratings-and-reviews' );
					break;
				case 'tooltip-rar_star_color_default':
					$text = __( 'A default color for unselected stars.', 'wpsso-ratings-and-reviews' );
					break;
			}
			return $text;
		}
	}
}

?>
