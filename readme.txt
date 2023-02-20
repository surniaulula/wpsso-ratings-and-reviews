=== WPSSO Ratings and Reviews ===
Plugin Name: WPSSO Ratings and Reviews
Plugin Slug: wpsso-ratings-and-reviews
Text Domain: wpsso-ratings-and-reviews
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/
Tags: star rating, aggregate rating, product ratings, product reviews, schema review, woocommerce
Contributors: jsmoriss
Requires Plugins: wpsso
Requires PHP: 7.2
Requires At Least: 5.4
Tested Up To: 6.1.1
WC Tested Up To: 7.4.0
Stable Tag: 2.21.0

Ratings and Reviews for WordPress Comments with Schema Aggregate Rating and Schema Review Markup.

== Description ==

<!-- about -->

**Extends the built-in WordPress comment system.**

**Compatible with WooCommerce and its product ratings.**

**Provides [Schema Aggregate Rating](https://schema.org/aggregateRating) markup.**

**Provides [Schema Review](https://schema.org/Review) markup:**

Including information about the review (author name, creation time, excerpt, rating) and threaded replies / comments for each review.

**No templates to modify or update:**

Simply activate the plugin to enable the addition of ratings and reviews.

<!-- /about -->

<h3>WPSSO Core Required</h3>

WPSSO Ratings and Reviews (WPSSO RAR) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/), which provides complete structured data for WordPress to present your content at its best on social sites and in search results – no matter how URLs are shared, reshared, messaged, posted, embedded, or crawled.

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

**Version 2.22.0 (2023/02/20)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Added a new 'wpssorar_post_column_rating_value' filter.
	* Removed the 'wpsso_cache_refreshed_notice' filter hook.
	* Removed the `WpssoRarFilters->filter_cache_refreshed_notice()` method.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.4.
	* WPSSO Core v15.4.0.

**Version 2.21.0 (2023/02/14)**

* **New Features**
	* None.
* **Improvements**
	* Changed the cache clearing action hook to a cache refresh filter hook.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Added a new `WpssoRarFilters->filter_cache_refreshed_notice()` method.
	* Removed the `WpssoRarActions->action_clear_cache()` method.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.4.
	* WPSSO Core v15.3.0.

**Version 2.20.1 (2023/01/26)**

* **New Features**
	* None.
* **Improvements**
	* Added compatibility declaration for WooCommerce HPOS.
	* Updated the minimum WordPress version from v5.2 to v5.4.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Updated the `WpssoAbstractAddOn` library class.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.4.
	* WPSSO Core v14.7.0.

**Version 2.20.0 (2023/01/20)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Updated the `SucomAbstractAddOn` common library class.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.2.
	* WPSSO Core v14.5.0.

== Upgrade Notice ==

= 2.22.0 =

(2023/02/20) Added a new 'wpssorar_post_column_rating_value' filter.

= 2.21.0 =

(2023/02/14) Changed the cache clearing action hook to a cache refresh filter hook.

= 2.20.1 =

(2023/01/26) Added compatibility declaration for WooCommerce HPOS. Updated the minimum WordPress version from v5.2 to v5.4.

= 2.20.0 =

(2023/01/20) Updated the `SucomAbstractAddOn` common library class.

