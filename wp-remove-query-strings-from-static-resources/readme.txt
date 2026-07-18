=== WP Remove Query Strings Clean ===
Contributors: rinkuyadav999, rojackal
Tags: query strings, static resources, CSS, JavaScript, caching
Stable tag: 2.4.1
Requires at least: 5.0
Tested up to: 7.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A non-commercial fork that removes query strings from local CSS and JavaScript resources.

== Description ==

**WP Remove Query Strings Clean** is a lightweight, zero-configuration WordPress plugin maintained for highproxies.com and usrmagurele.ro.

It removes query strings such as `?ver=6.6` from local CSS and JavaScript URLs on the public site. External resources and URLs that do not point to CSS or JavaScript files are left unchanged.

This fork contains no advertising, donation links, upgrade notices, commercial feature promotions, tracking, or lbcache.com integrations.

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

= 2.4.1 =

* Forked for private site maintenance.
* Removed all lbcache.com links and commercial promotion.
* Removed the upgrade notice, promotional admin page, and commercial plugin action links.
* Added an Update URI header to prevent replacement by the WordPress.org version.
* Preserved the core query-string removal behaviour and upstream GPL attribution.

= 2.4 =

* Added strict CSS and JavaScript extension checking.
* Added protection for external resources.
* Improved internal reliability.

== Upstream ==

Based on **WP Remove Query Strings From Static Resources** by Rinku Yadav, licensed under GPLv2 or later.
