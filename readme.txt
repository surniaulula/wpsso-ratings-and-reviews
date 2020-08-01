=== Ratings and Reviews | WPSSO Add-on ===
Plugin Name: WPSSO Ratings and Reviews
Plugin Slug: wpsso-ratings-and-reviews
Text Domain: wpsso-ratings-and-reviews
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/
Tags: star rating, aggregate rating, review, google, schema, comment, knowledge graph, product rating, product review, meta tags, schema review, schema markup, woocommerce
Contributors: jsmoriss
Requires PHP: 5.6
Requires At Least: 4.2
Tested Up To: 5.5
WC Tested Up To: 4.3.1
Stable Tag: 2.8.0

Ratings and Reviews for WordPress Comments with Schema Aggregate Rating and Schema Review Markup.

== Description ==

<p style="margin:0;"><img class="readme-icon" src="https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/icon-256x256.png"></p>

**Compatible with WooCommerce product ratings and reviews.**

**Extends the WordPress comment system with ratings and reviews:**

* Star ratings can be enabled/disabled by post type or individual post.

* A rating value can be required (or not) before reviews are accepted.

* The review form is correctly labeled as a "Review".

* The review reply form is correctly labeled as a "Reply".

* The color of star ratings can be customized from the settings page.

**Provides [Schema Aggregate Rating](https://schema.org/aggregateRating) meta tags and optional JSON-LD markup:**

Google reads aggregate rating meta tags, or the optional Schema JSON-LD markup, to add star ratings to search results (the WPSSO Schema JSON-LD Markup add-on is required for JSON-LD markup).

**Includes complete [Schema Review](https://schema.org/Review) in the optional JSON-LD markup:**

Including information about the review (author name, creation time, excerpt, rating), along with the threaded replies / comments for each review (the [WPSSO JSON Premium add-on](https://wpsso.com/extend/plugins/wpsso-schema-json-ld/) is required for the optional JSON-LD markup).

<h3>No templates to modify or update!</h3>

Simply activate / deactivate the plugin to enable / disable the addition of ratings and reviews.

<h3>WPSSO Core Plugin Required</h3>

WPSSO Ratings and Reviews (aka WPSSO RAR) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/).

== Installation ==

<h3 class="top">Install and Uninstall</h3>

* [Install the WPSSO Ratings and Reviews add-on](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/install-the-plugin/).
* [Uninstall the WPSSO Ratings and Reviews add-on](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/uninstall-the-plugin/).

== Frequently Asked Questions ==

<h3 class="top">Frequently Asked Questions</h3>

* None.

<h3>Notes and Documentation</h3>

* [Developer Resources](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/developer/)
	* [Get Average Rating](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/developer/get-average-rating/)

== Screenshots ==

01. The WPSSO RAR settings page to enable ratings by post type and select colors for the star ratings. 
02. The WPSSO RAR review submission &mdash; note the customized labels (Your Rating, Your Review, etc.).

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Standard Version Repositories</h3>

* [GitHub](https://surniaulula.github.io/wpsso-ratings-and-reviews/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wpsso-ratings-and-reviews/)

<h3>Changelog / Release Notes</h3>

**Version 2.9.0-dev.3 (2020/08/01)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Tested with WordPress v5.5.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.2.
	* WPSSO Core v7.15.0-dev.1.

**Version 2.8.0 (2020/05/09)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Refactored the required plugin check to (optionally) check the class name and a version constant.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.2.
	* WPSSO Core v7.5.0.

== Upgrade Notice ==

= 2.9.0-dev.3 =

(2020/08/01) Tested with WordPress v5.5.

= 2.8.0 =

(2020/05/09) Refactored the required plugin check to (optionally) check the class name and a version constant.

