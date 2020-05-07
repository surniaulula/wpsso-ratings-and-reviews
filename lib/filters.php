<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2020 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoRarFilters' ) ) {

	class WpssoRarFilters {

		private $p;

		public function __construct( &$plugin ) {

			/**
			 * Just in case - prevent filters from being hooked and executed more than once.
			 */
			static $do_once = null;

			if ( true === $do_once ) {
				return;	// Stop here.
			}

			$do_once = true;

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$this->p->util->add_plugin_filters( $this, array( 
				'get_defaults' => 1,
				'og'           => 2,
			), $prio = 1000 );

			if ( is_admin() ) {

				$this->p->util->add_plugin_filters( $this, array( 
					'messages_tooltip' => 2,
				) );
			}
		}

		public function filter_get_defaults( $defs ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			/**
			 * Add options using a key prefix array and post type names.
			 */
			$this->p->util->add_post_type_names( $defs, array(
				'rar_add_to' => 0,
			) );

			return $defs;
		}

		public function filter_og( array $mt_og, array $mod ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $mod[ 'is_post' ] || ! $mod[ 'id' ] ) {	// Make sure we have a valid post id.
				return $mt_og;
			} 

			if ( ! WpssoRarComment::is_rating_enabled( $mod[ 'id' ] ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: post id ' . $mod[ 'id' ] . ' ratings disabled' );
				}

				return $mt_og;
			}

			if ( empty( $mt_og[ 'og:type' ] ) ) {	// Just in case.

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: open graph type is empty' );
				}

				return $mt_og;
			}

			$og_type      = $mt_og[ 'og:type' ];
			$worst_rating = 1;
			$best_rating  = 5;

			if ( apply_filters( $this->p->lca . '_og_add_mt_rating', true, $mod ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'add rating meta tags is true' );
				}

				$average_rating = (float) WpssoRarComment::get_average_rating( $mod[ 'id' ] );
				$rating_count   = (int) WpssoRarComment::get_rating_count( $mod[ 'id' ] );
				$review_count   = (int) WpssoRarComment::get_review_count( $mod[ 'id' ] );

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'average rating = ' . $average_rating );
					$this->p->debug->log( 'rating count = ' . $rating_count );
					$this->p->debug->log( 'review count = ' . $review_count );
				}

				/**
				 * An average rating value must be greater than 0.
				 */
				if ( $average_rating > 0 ) {
			
					/**
					 * At least one rating or review is required.
					 */
					if ( $rating_count > 0 || $review_count > 0 ) {

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'adding rating meta tags for ' . $mod[ 'name' ] . ' id ' . $mod[ 'id' ] );
						}

						$mt_og[ $og_type . ':rating:average' ] = $average_rating;
						$mt_og[ $og_type . ':rating:count' ]   = $rating_count;
						$mt_og[ $og_type . ':rating:worst' ]   = $worst_rating;
						$mt_og[ $og_type . ':rating:best' ]    = $best_rating;
						$mt_og[ $og_type . ':review:count' ]   = $review_count;

					} elseif ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'rating and review count is invalid (must be greater than 0)' );
					}

				} elseif ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'average rating is invalid (must be greater than 0)' );
				}

			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'add rating meta tags is false' );
			}

			if ( apply_filters( $this->p->lca . '_og_add_mt_reviews', false, $mod ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'add review meta tags is true' );
				}

				$mt_og[ $og_type . ':reviews' ] = $mod[ 'obj' ]->get_og_type_reviews( $mod[ 'id' ],
					$og_type, $rating_meta = 'rating', $worst_rating, $best_rating );

			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'add review meta tags is false' );
			}

			return $mt_og;
		}

		public function filter_messages_tooltip( $text, $msg_key ) {

			if ( strpos( $msg_key, 'tooltip-rar_' ) !== 0 ) {
				return $text;
			}

			switch ( $msg_key ) {

				case 'tooltip-rar_add_to':		// Rating Form for Post Types.

					$text = __( 'Enable or disable the ratings feature by public post type.', 'wpsso-ratings-and-reviews' ) . ' ';

					break;

				case 'tooltip-rar_rating_required':	// Rating Required to Submit Review.

					$text = __( 'A rating value must be selected to submit a review (enabled by default).', 'wpsso-ratings-and-reviews' );

					break;

				case 'tooltip-rar_star_color_default':	// Unselected Star Rating Color.

					$text = __( 'The border color for unselected stars.', 'wpsso-ratings-and-reviews' );

					break;

				case 'tooltip-rar_star_color_selected':	// Selected Star Rating Color.

					$text = __( 'The color for selected stars.', 'wpsso-ratings-and-reviews' );

					break;
			}

			return $text;
		}
	}
}
