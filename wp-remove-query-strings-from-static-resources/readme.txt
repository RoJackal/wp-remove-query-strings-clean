=== WP Remove Query Strings Clean ===
Contributors: rinkuyadav999, rojackal
Tags: query strings, static resources, CSS, JavaScript, caching
Stable tag: 2.5.0
Requires at least: 5.0
Tested up to: 7.0
Requires PHP: 8.5
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A non-commercial fork that removes query strings from local CSS and JavaScript resources.

== Description ==

**WP Remove Query Strings Clean** is a lightweight, zero-configuration WordPress plugin maintained for highproxies.com and usrmagurele.ro.

It removes query strings such as `?ver=6.6` from local CSS and JavaScript URLs on the public site. External resources and URLs that do not point to CSS or JavaScript files are left unchanged.

This fork contains no advertising, donation links, upgrade notices, commercial feature promotions, tracking, or third-party commercial integrations.

The plugin preserves the original GPLv2-or-later licence and upstream attribution.

== Features ==

* Removes query strings from local CSS and JavaScript resource URLs.
* Ignores external resources.
* Ignores non-CSS and non-JavaScript URLs.
* Runs only on the public-facing site.
* Requires no settings or administration page.
* Contains no commercial integrations or promotional notices.

== Installation ==

1. Copy the `wp-remove-query-strings-from-static-resources` directory to `/wp-content/plugins/`.
2. Activate **WP Remove Query Strings Clean** from the WordPress Plugins page.
3. Purge the WordPress, server, and CDN caches.

== Important Cache Note ==

WordPress version query strings normally provide cache busting. After updating themes, plugins, CSS, or JavaScript, purge all relevant caches so visitors receive the current files.

== Changelog ==

= 2.5.0 =

* Requires PHP 8.5 or newer.
* Replaced repeated URL-path parsing and `pathinfo()` calls with short extension comparisons.
* Cached the site hostname instead of parsing `home_url()` for every resource.
* Added case-insensitive hostname comparison.
* Simplified the plugin bootstrap.
* Added behavioral, syntax, and comparative performance tests for PHP 8.5.

= 2.4.1 =

* Forked for private site maintenance.
* Removed third-party commercial links and promotions.
* Removed the upgrade notice, promotional admin page, and commercial plugin action links.
* Added an Update URI header to prevent replacement by the WordPress.org version.
* Preserved the core query-string removal behaviour and upstream GPL attribution.

= 2.4 =

* Added strict CSS and JavaScript extension checking.
* Added protection for external resources.
* Improved internal reliability.

== Upstream ==

Based on **WP Remove Query Strings From Static Resources** by Rinku Yadav, licensed under GPLv2 or later.
