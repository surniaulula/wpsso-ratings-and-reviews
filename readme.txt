=== WPSSO Ratings and Reviews ===
Plugin Name: WPSSO Ratings and Reviews
Plugin Slug: wpsso-ratings-and-reviews
Text Domain: wpsso-ratings-and-reviews
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/
Tags: star rating, aggregate rating, review, google, schema, comment, knowledge graph, product rating, product review, meta tags, schema review, schema markup, woocommerce
Contributors: jsmoriss
Requires Plugins: wpsso
Requires PHP: 7.2
Requires At Least: 5.2
Tested Up To: 6.1.1
Stable Tag: 2.20.0

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

<p><strong>WPSSO Core Premium customers have access to development, alpha, beta, and release candidate version updates:</strong></p>

<p>Under the SSO &gt; Update Manager settings page, select the "Development and Up" (for example) version filter for the WPSSO Core plugin and/or its add-ons. When new development versions are available, they will automatically appear under your WordPress Dashboard &gt; Updates page. You can reselect the "Stable / Production" version filter at any time to reinstall the latest stable version.</p>

<h3>Changelog / Release Notes</h3>

**Version 2.20.1-dev.2 (2023/01/24)**

* **New Features**
	* None.
* **Improvements**
	* Added compatibility declaration for WooCommerce HPOS.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Updated the `WpssoAbstractAddOn` class.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.2.
	* WPSSO Core v14.6.1-dev.2.

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

**Version 2.19.0 (2022/03/14)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Renamed the WPSSORAR_META_REVIEW_RATING constant to WPSSO_META_RATING_NAME.
	* Removed the `$mt_prefix` argument from:
		* `WpssoPost->get_mt_reviews()`
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.2.
	* WPSSO Core v11.7.0.

**Version 2.18.1 (2022/03/07)**

Maintenance release.

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.2.
	* WPSSO Core v11.5.0.

**Version 2.18.0 (2022/01/19)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Renamed the lib/abstracts/ folder to lib/abstract/.
	* Renamed the `SucomAddOn` class to `SucomAbstractAddOn`.
	* Renamed the `WpssoAddOn` class to `WpssoAbstractAddOn`.
	* Renamed the `WpssoWpMeta` class to `WpssoAbstractWpMeta`.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.2.
	* WPSSO Core v9.14.0.

== Upgrade Notice ==

= 2.20.1-dev.2 =

(2023/01/24) Added compatibility declaration for WooCommerce HPOS.

= 2.20.0 =

(2023/01/20) Updated the `SucomAbstractAddOn` common library class.

= 2.19.0 =

(2022/03/14) Renamed the WPSSORAR_META_REVIEW_RATING constant to WPSSO_META_RATING_NAME.

= 2.18.1 =

(2022/03/07) Maintenance release.

= 2.18.0 =

(2022/01/19) Renamed the lib/abstracts/ folder and its classes.

