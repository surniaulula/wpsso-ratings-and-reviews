=== WPSSO Ratings and Reviews ===
Plugin Name: WPSSO Ratings and Reviews
Plugin Slug: wpsso-ratings-and-reviews
Text Domain: wpsso-ratings-and-reviews
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/
Tags: star rating, aggregate rating, product ratings, product reviews, woocommerce
Contributors: jsmoriss
Requires Plugins: wpsso
Requires PHP: 7.4.33
Requires At Least: 5.9
Tested Up To: 6.8.3
WC Tested Up To: 10.2.2
Stable Tag: 3.2.0

Adds Ratings and Reviews Features to the WordPress Comments System.

== Description ==

<!-- about -->

**Extends the WordPress comments system:**

Adds ratings and reviews features to Posts, Pages, and custom post types by extending the WordPress comments system.

**Compatible with WooCommerce and its product ratings:**

WooCommerce provides its own product ratings and reviews features.

The WPSSO Ratings and Reviews add-on can provide ratings and reviews features for other post types, without interfering with WooCommerce's product ratings and reviews features.

**Provides [Schema Aggregate Rating](https://schema.org/aggregateRating) and [Schema Review](https://schema.org/Review) markup:**

In Posts, Pages, and custom post types where ratings and reviews have been enabled, the WPSSO Ratings and Reviews add-on includes information in the Schema markup about the review (author name, creation time, excerpt, rating) and the threaded replies / comments for each review.

**No templates to modify or update:**

The WPSSO Ratings and Reviews add-on automatically and dynamically extends the WordPress comments system without modifying any templates.

Simply activate the plugin to enable the addition of ratings and reviews.

<!-- /about -->

<h3>WPSSO Core Required</h3>

WPSSO Ratings and Reviews is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/), which creates extensive and complete structured data to present your content at its best for social sites and search results – no matter how URLs are shared, reshared, messaged, posted, embedded, or crawled.

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
02. The WPSSO RAR review submission - note the customized labels (Your Rating, Your Review, etc.).

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes and/or incompatible API changes (ie. breaking changes).
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Standard Edition Repositories</h3>

* [GitHub](https://surniaulula.github.io/wpsso-ratings-and-reviews/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wpsso-ratings-and-reviews/)

<h3>Development Version Updates</h3>

<p><strong>WPSSO Core Premium edition customers have access to development, alpha, beta, and release candidate version updates:</strong></p>

<p>Under the SSO &gt; Update Manager settings page, select the "Development and Up" (for example) version filter for the WPSSO Core plugin and/or its add-ons. When new development versions are available, they will automatically appear under your WordPress Dashboard &gt; Updates page. You can reselect the "Stable / Production" version filter at any time to reinstall the latest stable version.</p>

<p><strong>WPSSO Core Standard edition users (ie. the plugin hosted on WordPress.org) have access to <a href="https://wordpress.org/plugins/wpsso-ratings-and-reviews/advanced/">the latest development version under the Advanced Options section</a>.</strong></p>

<h3>Changelog / Release Notes</h3>

**Version 3.2.0 (2024/08/25)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Changed the main instantiation action hook from 'init_objects' to 'init_objects_preloader'.
* **Requires At Least**
	* PHP v7.4.33.
	* WordPress v5.9.
	* WPSSO Core v18.20.0.

== Upgrade Notice ==

= 3.2.0 =

(2024/08/25) Changed the main instantiation action hook from 'init_objects' to 'init_objects_preloader'.

