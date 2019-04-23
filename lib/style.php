<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017-2019 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRarStyle' ) ) {

	class WpssoRarStyle {

		protected $p;

		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
		}

		public static function enqueue_styles() {

			if ( ! WpssoRarComment::is_rating_enabled( get_the_ID() ) ) {
				return;
			}

			$wpsso = Wpsso::get_instance();

			$sel_color = $wpsso->options[ 'rar_star_color_selected' ];
			$def_color = $wpsso->options[ 'rar_star_color_default' ];

			$plugin_version = WpssoRarConfig::get_version();

			wp_enqueue_style( 'wpsso-rar-style', 
				WPSSORAR_URLPATH . 'css/style.min.css', 
					array(), $plugin_version );

			$custom_style_css = '

				@font-face {
					font-family:"WpssoStar";
					font-weight:normal;
					font-style:normal;
					src: url("' . WPSSO_URLPATH . 'fonts/star.eot?' . $plugin_version . '");
					src: url("' . WPSSO_URLPATH . 'fonts/star.eot?' . $plugin_version . '#iefix") format("embedded-opentype"),
						url("' . WPSSO_URLPATH . 'fonts/star.woff?' . $plugin_version . '") format("woff"),
						url("' . WPSSO_URLPATH . 'fonts/star.ttf?' . $plugin_version . '") format("truetype"),
						url("' . WPSSO_URLPATH . 'fonts/star.svg?' . $plugin_version . '#star") format("svg");
				}

				.wpsso-rar .star-rating::before { color:' . $def_color . '; }
				.wpsso-rar .star-rating span::before { color:' . $sel_color . '; }
				.wpsso-rar p.select-star a::before { color:' . $def_color . '; }
				.wpsso-rar p.select-star a:hover ~ a::before { color:' . $def_color . '; }
				.wpsso-rar p.select-star:hover a::before { color:' . $sel_color . '; }
				.wpsso-rar p.select-star.selected a.active::before { color:' . $sel_color . '; }
				.wpsso-rar p.select-star.selected a.active ~ a::before { color:' . $def_color . '; }
				.wpsso-rar p.select-star.selected a:not(.active)::before { color:' . $sel_color . '; }
			';

			wp_add_inline_style( 'wpsso-rar-style', SucomUtil::minify_css( $custom_style_css, 'wpsso' ) );
		}
	}
}
