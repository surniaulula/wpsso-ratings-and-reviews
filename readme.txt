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
Requires PHP: 7.2
Requires At Least: 5.2
Tested Up To: 5.9.3
WC Tested Up To: 6.3.1
Stable Tag: 2.19.0

Ratings and Reviews for WordPress Comments with Schema Aggregate Rating and Schema Review Markup.

== Description ==

<!-- about -->

**The WPSSO Ratings and Reviews add-on extends the WordPress comment system:**

* The star ratings can be enabled/disabled by post type or individual post.
* A rating value can be optional, or required before reviews are accepted.
* The color of star ratings can be customized from the add-on settings page.
* The theme template review form is correctly labeled as a "Review".
* The theme template review reply form is correctly labeled as a "Reply".

**Compatible with WooCommerce product ratings.**

**Provides [Schema Aggregate Rating](https://schema.org/aggregateRating) markup.**

**Provides [Schema Review](https://schema.org/Review) markup,** including information about the review (author name, creation time, excerpt, rating) and threaded replies / comments for each review.

<h3>No templates to modify or update!</h3>

Simply activate the plugin to enable the addition of ratings and reviews.

<!-- /about -->

<h3>WPSSO Core Required</h3>

WPSSO Ratings and Reviews (WPSSO RAR) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/).

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

<p>Under the SSO &gt; Update Manager settings page, select the "Development and Up" (for example) version filter for the WPSSO Core plugin and/or its add-ons. Save the plugin settings and click the "Check for Plugin Updates" button to fetch the latest version information. When new development versions are available, they will automatically appear under your WordPress Dashboard &gt; Updates page. You can always reselect the "Stable / Production" version filter at any time to reinstall the latest stable version.</p>

<h3>Changelog / Release Notes</h3>

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

**Version 2.17.0 (2021/12/16)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Replaced a call to `WpssoUtil->add_post_type_names()` with a new 'wpsso_add_custom_post_type_options' filter hook.
	* Replaced a call to `WpssoUtil->add_taxonomy_names()` with a new 'wpsso_add_custom_taxonomy_options' filter hook.
	* Moved the `WpssoAdmin->filter_get_sortable_columns()` filter hook to the `WpssoFilters` class.
	* Moved the `WpssoAdmin->post_callback_rating_enabled()` callback method to the `WpssoFilters` class.
	* Renamed disabled option key suffix from `":is" = "disabled"` to `":disabled" = true`.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.2.
	* WPSSO Core v9.12.0.

**Version 2.16.0 (2021/12/08)**

* **New Features**
	* None.
* **Improvements**
	* Improved the post meta cache update methods for new / changed comments.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Replaced the 'wp_update_comment_count' action hook with 'comment_post' and 'transition_comment_status' to clear the comment rating metadata cache.
	* Replaced the `WpssoRarComment::clear_rating_post_meta()` method by:
		* `WpssoRarComment::update_cache_comment_post()`
		* `WpssoRarComment::update_cache_transition_comment_status()`
		* `WpssoRarComment::update_cache_post_meta()`
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.2.
	* WPSSO Core v9.11.0.

**Version 2.15.3 (2021/11/16)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Refactored the `SucomAddOn->get_missing_requirements()` method.
* **Requires At Least**
	* PHP v7.2.
	* WordPress v5.2.
	* WPSSO Core v9.8.0.

**Version 2.15.2 (2021/10/18)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* Fixed an extra newline character, that was converted to a line-break, in comment text.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v9.2.0.

**Version 2.15.1 (2021/10/06)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Standardized `get_table_rows()` calls and filters in 'submenu' and 'sitesubmenu' classes.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v9.1.0.

**Version 2.15.0 (2021/09/24)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* Fixed saving star rating colors in the SSO &gt; Ratings / Reviews settings page.
* **Developer Notes**
	* Updated the 'wpsso_og_add_mt_reviews' default value for WPSSO Core v9.0.0.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v9.0.0.

**Version 2.14.2 (2021/06/27)**

* **New Features**
	* None.
* **Improvements**
	* Added a conflict check for the new "Ratings and Reviews Service" option in WPSSO Core v8.33.0.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v8.34.0.

**Version 2.14.1 (2021/06/18)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Updated the 'wpsso-rar-script' localized variable names.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.31.0.

**Version 2.14.0 (2021/06/08)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Updated the 'wpsso_get_sortable_columns' filter for WPSSO Core v8.30.0.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.30.0.

**Version 2.13.1 (2021/02/25)**

* **New Features**
	* None.
* **Improvements**
	* Updated the banners and icons of WPSSO Core and its add-ons.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.25.2.

**Version 2.13.0 (2021/01/21)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Changed `jQuery( document ).on( 'ready' )` event handlers to `jQuery()` for jQuery v3.0.
	* Renamed 'get_og_type_reviews()' to 'get_mt_reviews()' for WPSSO v8.20.0.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.20.0.

**Version 2.12.0 (2020/12/04)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Included the `$addon` argument for library class constructors.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.16.0.

== Upgrade Notice ==

= 2.19.0 =

(2022/03/14) Renamed the WPSSORAR_META_REVIEW_RATING constant to WPSSO_META_RATING_NAME.

= 2.18.1 =

(2022/03/07) Maintenance release.

= 2.18.0 =

(2022/01/19) Renamed the lib/abstracts/ folder and its classes.

= 2.17.0 =

(2021/12/16) Replaced method calls with filter hooks when completing the default options array.

= 2.16.0 =

(2021/12/08) Improved the post meta cache update methods for new / changed comments.

= 2.15.3 =

(2021/11/16) Refactored the `SucomAddOn->get_missing_requirements()` method.

= 2.15.2 =

(2021/10/18) Fixed an extra newline character, that was converted to a line-break, in comment text.

= 2.15.1 =

(2021/10/06) Standardized `get_table_rows()` calls and filters in 'submenu' and 'sitesubmenu' classes.

= 2.15.0 =

(2021/09/24) Fixed saving star rating colors in the SSO &gt; Ratings / Reviews settings page.

= 2.14.2 =

(2021/06/27) Added a conflict check for the new "Ratings and Reviews Service" option in WPSSO Core v8.33.0.

= 2.14.1 =

(2021/06/18) Updated the 'wpsso-rar-script' localized variable names.

= 2.14.0 =

(2021/06/08) Updated the 'wpsso_get_sortable_columns' filter for WPSSO Core v8.30.0.

= 2.13.1 =

(2021/02/25) Updated the banners and icons of WPSSO Core and its add-ons.

= 2.13.0 =

(2021/01/21) Changed `jQuery( document ).on( 'ready' )` event handlers to `jQuery()` for jQuery v3.0.

= 2.12.0 =

(2020/12/04) Included the `$addon` argument for library class constructors.

