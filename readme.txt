=== WPSSO Ratings and Reviews / Replies with Schema Aggregate Ratings (Compatible with WooCommerce) ===
Plugin Name: WPSSO Ratings and Reviews
Plugin Slug: wpsso-ratings-and-reviews
Text Domain: wpsso-ratings-and-reviews
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/
Tags: star rating, aggregate rating, review, google, schema, comment, knowledge graph, product rating, product review, meta tags, schema review, schema markup, woocommerce
Contributors: jsmoriss
Requires PHP: 5.4
Requires At Least: 3.8
Tested Up To: 4.9.4
WC Tested Up To: 3.3.4
Stable Tag: 1.3.3

WPSSO Core add-on to provide ratings and reviews for WordPress comments with Aggregate Rating meta tags, and optional Schema Review markup.

== Description ==

<img class="readme-icon" src="https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/icon-256x256.png">

**A WPSSO Core add-on to provide ratings and reviews for WordPress comments with aggregate rating meta tags, and optional Schema Review markup.**

Extends the WordPress comment system with ratings and reviews &mdash; star ratings and reviews can be enabled / disabled by post type and/or individual posts, new reviews are correctly labeled as "reviews" (not "comments"), a rating can be required before reviews are accepted, replies to reviews are properly labeled as "replies", and colors of star ratings can be customized from the settings page.

Does not conflict with WooCommerce ratings and reviews &mdash; the [WooCommerce](https://wordpress.org/plugins/woocommerce/) plugin settings are checked, and if WooCommerce product reviews are enabled (or the [Yotpo Reviews for Woocommerce](https://wordpress.org/plugins/yotpo-social-reviews-for-woocommerce/) plugin is active), the "product" post type is ignored to avoid conflicts with WooCommerce product reviews.

Provides [Schema Aggregate Rating](https://schema.org/aggregateRating) meta tags and JSON-LD markup &mdash; Google reads aggregate rating meta tags (or the optional Schema JSON-LD markup) to add star ratings to search results ([WPSSO JSON Pro add-on](https://wpsso.com/extend/plugins/wpsso-schema-json-ld/) required for JSON-LD markup). WooCommerce product ratings and reviews are also included in the aggregate rating meta tags and JSON-LD markup.

Includes complete [Schema Review](https://schema.org/Review) as optional JSON-LD markup &mdash; including information about the review (author name, creation time, excerpt, rating), along with the threaded replies / comments for each review ([WPSSO JSON Pro add-on](https://wpsso.com/extend/plugins/wpsso-schema-json-ld/) required for JSON-LD markup).

WPSSO Ratings and Reviews is *incredibly fast* and coded for performance &mdash; WPSSO Core and its add-ons make full use of all available caching techniques (persistent / non-persistent object and disk caching), and load only the PHP library files and object classes they need, keeping their code small, fast, and light. WPSSO Core and its add-ons are also fully tested and compatible with PHP v7.x (PHP v5.4 or better required).

<h3>WPSSO Core Plugin Prerequisite</h3>

WPSSO Ratings and Reviews (aka WPSSO RAR) is an add-on for the WPSSO Core plugin &mdash; which creates complete &amp; accurate meta tags and Schema markup from your existing content for social sharing, Social Media Optimization (SMO), Search Engine Optimization (SEO), Google Rich Cards, Pinterest Rich Pins, etc. 

The [WPSSO Core Pro plugin](https://wpsso.com/) and the [WPSSO JSON Pro add-on](https://wpsso.com/extend/plugins/wpsso-schema-json-ld/) are required to add the [Schema Aggregate Rating](https://schema.org/aggregateRating) and [Schema Review](https://schema.org/Review) as Schema JSON-LD markup.

== Installation ==

<h3>Install and Uninstall</h3>

* [Install the WPSSO RAR Add-on](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/install-the-plugin/)
* [Uninstall the WPSSO RAR Add-on](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/uninstall-the-plugin/)

== Frequently Asked Questions ==

<h3>Frequently Asked Questions</h3>

* None

== Other Notes ==

<h3>Additional Documentation</h3>

* [Developer Resources](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/developer/)
	* [Get Average Rating](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/developer/get-average-rating/)

== Screenshots ==

01. WPSSO RAR showing the submission of a four-star review &mdash; note the themed labels (Your Rating, Your Review, etc.) and the customized star colors.
02. WPSSO RAR showing a reply to an earlier four-star review &mdash; note there are no rating options for replies to reviews, and the labels reflect this.
03. WPSSO RAR in the back-end showing an option to enable / disable ratings per post, some reviews with star ratings, and a reply to a review (no star rating).
04. WPSSO RAR settings page with options to enable / disable ratings by post type, force star ratings for reviews, and colors for the star ratings. 

== Changelog ==

<h3>Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Free / Standard Version Repositories</h3>

* [GitHub](https://surniaulula.github.io/wpsso-ratings-and-reviews/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wpsso-ratings-and-reviews/)

<h3>Changelog / Release Notes</h3>

**Version 1.3.4-dev.1 (2018/04/01)**

* *New Features*
	* None
* *Improvements*
	* None
* *Bugfixes*
	* None
* *Developer Notes*
	* Renamed the WpssoUtil do_table_rows() method to do_metabox_table() for the Gutenberg changes in WPSSO v3.57.0.

**Version 1.3.3 (2018/03/24)**

* *New Features*
	* None
* *Improvements*
	* Renamed plugin "Extensions" to "Add-ons" to avoid confusion and improve / simplify translations.
* *Bugfixes*
	* None
* *Developer Notes*
	* None

**Version 1.3.2 (2018/03/05)**

* *New Features*
	* None
* *Improvements*
	* Improved parsing for the comment label in the 'comment_field' value.
* *Bugfixes*
	* None
* *Developer Notes*
	* Added `jQuery( document ).ready()` to the plugin jQuery scripts to delay their execution until the HTML document is fully loaded.

== Upgrade Notice ==

= 1.3.4-dev.1 =

(2018/04/01) Renamed the WpssoUtil do_table_rows() method to do_metabox_table() for the Gutenberg changes in WPSSO v3.57.0.

= 1.3.3 =

(2018/03/24) Renamed plugin "Extensions" to "Add-ons" to avoid confusion and improve / simplify translations.

