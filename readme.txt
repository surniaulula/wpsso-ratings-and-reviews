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
Tested Up To: 4.8.2
Requires PHP: 5.3
Stable Tag: 1.0.7

WPSSO extension to add ratings and reviews for WordPress comments, with Aggregate Rating meta tags and optional Schema Review markup.

== Description ==

<img class="readme-icon" src="https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/icon-256x256.png">

**Extend the WordPress comment system with ratings and reviews:**

Star ratings and reviews can be enabled / disabled per post, new reviews are labeled as "reviews" (not comments), a rating can be required before reviews are accepted, replies to reviews are properly labeled as replies and/or comments, and the colors of star ratings can be customized from the settings page.

**Provides [Schema Aggregate Rating](https://schema.org/aggregateRating) meta tags and JSON-LD markup** (requires the optional WPSSO JSON extension):

Google can read the aggregate rating meta tags and/or optional Schema JSON-LD markup to add star ratings to search results!

**Includes complete [Schema Review](https://schema.org/Review) as optional JSON-LD markup:**

Including information about the review (author name, creation time, excerpt, rating), along with the threaded replies / comments for each review.

**WPSSO RAR is *fast* and coded for performance:**

WPSSO and its extensions make full use of all available caching techniques (persistent / non-persistent object and disk caching), and load only the PHP library files and object classes they need, keeping their code small, fast, and light.

WPSSO and its extensions are fully tested and compatible with PHP v7.x (PHP v5.3 or better required).

= WPSSO (Core Plugin) Prerequisite =

WPSSO Ratings and Reviews is an extension for the WPSSO (Core Plugin) &mdash; which provides complete and accurate meta tags and Schema markup from your content for social sharing, social media, search / SEO / rich cards, and more.

The [WPSSO Pro (Core Plugin)](https://wpsso.com/extend/plugins/wpsso/) and the [WPSSO JSON Pro](https://wpsso.com/extend/plugins/wpsso-schema-json-ld/) extension are required to add the [Schema Aggregate Rating](https://schema.org/aggregateRating) and [Schema Review](https://schema.org/Review) as Schema JSON-LD markup.

== Installation ==

= Install and Uninstall =

* [Install the WPSSO RAR Plugin](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/install-the-plugin/)
* [Uninstall the WPSSO RAR Plugin](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/uninstall-the-plugin/)

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

**Version 1.0.7 (2017/09/10)**

* *New Features*
	* None
* *Improvements*
	* None
* *Bugfixes*
	* None
* *Developer Notes*
	* Minor code refactoring for WPSSO v3.46.0.

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
	* Minor revision to move URLs in the extension config to the main WPSSO core plugin config.
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
	* Moved the fonts sub-folder to the WPSSO core plugin folder in WPSSO v3.40.11-1.

== Upgrade Notice ==

= 1.0.7 =

(2017/09/10) Minor code refactoring for WPSSO v3.46.0.

= 1.0.6 =

(2017/04/30) Code refactoring to rename the $is_avail array to $avail for WPSSO v3.42.0.

= 1.0.5 =

(2017/04/16) Refactored the plugin init filters and moved/renamed the registration boolean.

= 1.0.4 =

(2017/04/08) Minor revision to move URLs in the extension config to the main WPSSO core plugin config.

= 1.0.2-1 =

(2017/04/05) Updated the plugin icon images and the documentation URLs. Minimized the custom inline styles. Moved the fonts sub-folder to the WPSSO core plugin.

