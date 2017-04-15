<?php
/*
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2017 Jean-Sebastien Morisset (https://surniaulula.com/)
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

			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );	// also enqueued by admin class
		}

		public static function enqueue_styles() {
			if ( ! WpssoRarComment::is_rating_enabled( get_the_ID() ) ) {
				return;
			}

			wp_enqueue_style( 'wpsso-rar-style', 
				WPSSORAR_URLPATH.'css/style.min.css', 
					array(), WpssoRarConfig::get_version() );

			$wpsso = Wpsso::get_instance();
			$sel_color = $wpsso->options['rar_star_color_selected'];
			$def_color = $wpsso->options['rar_star_color_default'];

			$custom_style_css = '
				@font-face {
					font-family: "Star";
					src: url("'.WPSSO_URLPATH.'fonts/star.eot");
					src: url("'.WPSSO_URLPATH.'fonts/star.eot?#iefix") format("embedded-opentype"),
					url("'.WPSSO_URLPATH.'fonts/star.woff") format("woff"),
					url("'.WPSSO_URLPATH.'fonts/star.ttf") format("truetype"),
					url("'.WPSSO_URLPATH.'fonts/star.svg#star") format("svg");
					font-weight: normal;
					font-style: normal;
				}
				.wpsso-rar .star-rating:before { color:'.$def_color.'; }
				.wpsso-rar .star-rating span:before { color:'.$sel_color.'; }
				.wpsso-rar p.select-star a:before { color:'.$def_color.'; }
				.wpsso-rar p.select-star a:hover ~ a:before { color:'.$def_color.'; }
				.wpsso-rar p.select-star:hover a:before { color:'.$sel_color.'; }
				.wpsso-rar p.select-star.selected a.active:before { color:'.$sel_color.'; }
				.wpsso-rar p.select-star.selected a.active ~ a:before { color:'.$def_color.'; }
				.wpsso-rar p.select-star.selected a:not(.active):before { color:'.$sel_color.'; }
			';

			wp_add_inline_style( 'wpsso-rar-style', SucomUtil::minify_css( $custom_style_css, 'wpsso' ) );
		}
	}
}

?>
