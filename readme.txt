=== WPSSO Ratings and Reviews / Replies / Comments with Schema Aggregate Ratings ===
Plugin Name: WPSSO Ratings and Reviews
Plugin Slug: wpsso-ratings-and-reviews
Text Domain: wpsso-ratings-and-reviews
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/
Tags: star rating, aggregate rating, review, google, schema, comment, knowledge graph, product rating, product review, meta tags, schema review, schema markup
Contributors: jsmoriss
Requires At Least: 3.7
Tested Up To: 4.8
Stable Tag: 1.0.6

WPSSO extension to add ratings and reviews for WordPress comments, with Aggregate Rating meta tags and optional Schema Review markup.

== Description ==

<img class="readme-icon" src="https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/icon-256x256.png">

<p><strong>Extends the WordPress comment system with a new star rating and review feature</strong> &mdash; ratings and reviews can be enabled / disabled per post, new reviews are labeled as reviews, a star rating can be required before reviews are accepted, replies to reviews are properly labeled as replies / comments, and the colors of star ratings can be customized from the settings page.</p>

<p><strong>Provides <a href="https://schema.org/aggregateRating">Schema Aggregate Rating</a> with meta tags and optional JSON-LD markup</strong> &mdash; Google reads the aggregate rating meta tags and optional JSON-LD markup to add star ratings to search results!</p>

<p><strong>Includes complete <a href="https://schema.org/Review">Schema Review</a> details as optional JSON-LD markup</strong> &mdash; including information about the review (author name, creation time, excerpt, rating), along with the threaded replies / comments for each review.</p>

<blockquote>
<p><strong>Prerequisite</strong> &mdash; WPSSO Ratings and Reviews is an extension for the <a href="https://wordpress.org/plugins/wpsso/">WPSSO</a> plugin, which <em>automatically</em> generates complete and accurate meta tags + Schema markup from your content for social media optimization (SMO) and SEO.</p>

<p>The <a href="https://wpsso.com/extend/plugins/wpsso/">WPSSO Pro</a> plugin and its <a href="https://wpsso.com/extend/plugins/wpsso-schema-json-ld/">WPSSO JSON Pro</a> extension are required to add the <a href="https://schema.org/aggregateRating">Schema Aggregate Rating</a> and <a href="https://schema.org/Review">Schema Review</a> as optional JSON-LD markup.</p>
</blockquote>

== Installation ==

= Install and Uninstall =

* [Install the Plugin](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/install-the-plugin/)
* [Uninstall the Plugin](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/uninstall-the-plugin/)

== Frequently Asked Questions ==

= Frequently Asked Questions =

* None

== Other Notes ==

= Additional Documentation =

== Screenshots ==

01. WPSSO RAR showing the submission of a four-star review &mdash; note the themed labels (Your Rating, Your Review, etc.) and the customized star colors.
02. WPSSO RAR showing a reply to an earlier four-star review &mdash; note there are no rating options for replies to reviews, and the labels reflect this.
03. WPSSO RAR in the back-end showing an option to enable / disable ratings per post, some reviews with star ratings, and a reply to a review (no star rating).
04. WPSSO RAR settings page with options to enable / disable ratings by post type, force star ratings for reviews, and colors for the star ratings. 

== Changelog ==

= Repositories =

* [GitHub](https://surniaulula.github.io/wpsso-ratings-and-reviews/)
* [WordPress.org](https://wordpress.org/plugins/wpsso-ratings-and-reviews/developers/)

= Version Numbering =

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

= Changelog / Release Notes =

**Version 1.0.6 (2017/04/30)**

* *New Features*
	* None
* *Improvements*
	* None
* *Bugfixes*
	* None
* *Developer Notes*
	* Code refactoring to rename the $is_avail array to $avail for WPSSO v3.42.0.

**Version 1.0.5 (2017/04/16)**

* *New Features*
	* None
* *Improvements*
	* None
* *Bugfixes*
	* None
* *Developer Notes*
	* Refactored the plugin init filters and moved/renamed the registration boolean from `is_avail[$name]` to `is_avail['p_ext'][$name]`.

**Version 1.0.4 (2017/04/08)**

* *New Features*
	* None
* *Improvements*
	* None
* *Bugfixes*
	* None
* *Developer Notes*
	* Minor revision to move URLs in the extension config to the main WPSSO plugin config.
	* Dropped the package number from the production version string.

**Version 1.0.2-1 (2017/04/05)**

* *New Features*
	* None
* *Improvements*
	* Updated the plugin icon images and the documentation URLs.
	* Minimized the custom inline styles for the "Star" font and colors.
* *Bugfixes*
	* None
* *Developer Notes*
	* Moved the fonts sub-folder to the WPSSO plugin folder in WPSSO v3.40.11-1.

== Upgrade Notice ==

= 1.0.6 =

(2017/04/30) Code refactoring to rename the $is_avail array to $avail for WPSSO v3.42.0.

= 1.0.5 =

(2017/04/16) Refactored the plugin init filters and moved/renamed the registration boolean.

= 1.0.4 =

(2017/04/08) Minor revision to move URLs in the extension config to the main WPSSO plugin config.

= 1.0.2-1 =

(2017/04/05) Updated the plugin icon images and the documentation URLs. Minimized the custom inline styles. Moved the fonts sub-folder to the WPSSO plugin.

