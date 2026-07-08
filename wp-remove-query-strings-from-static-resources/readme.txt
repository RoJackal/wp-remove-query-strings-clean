=== WP Remove Query Strings From Static Resources ===
Contributors: rinkuyadav999
Donate link: https://lbcache.com
Tags: query strings, remove query strings, static resources, page speed, performance
Stable tag: 2.3
Requires at least: 5.0
Tested up to: 7.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Boost your WordPress site speed by removing query strings from CSS and JS files — improve your GTmetrix, PageSpeed, and Pingdom scores instantly.

== Description ==

**WP Remove Query Strings From Static Resources** is a lightweight, zero-configuration WordPress plugin that automatically removes query strings (like `?ver=6.6`) from your CSS and JavaScript file URLs.

By default, WordPress appends version parameters to static resource URLs — for example:

`https://example.com/style.css?ver=6.6`

While this helps with cache-busting during development, it prevents proxy servers and CDN networks from properly caching these files, which hurts your website's performance score.

This plugin strips those query strings, turning URLs like:

`https://example.com/style.css?ver=6.6`

into clean, cacheable URLs like:

`https://example.com/style.css`

= Why Does This Matter? =

Speed is a critical ranking factor for search engines. Tools like **Google PageSpeed Insights**, **GTmetrix**, **Pingdom**, and **YSlow** flag query strings on static resources as a performance issue. Removing them can:

* ✅ Improve your website performance score
* ✅ Enable better proxy and CDN caching
* ✅ Reduce page load time for returning visitors
* ✅ Contribute to better SEO rankings
* ✅ Improve overall user experience

= How It Works =

Once activated, the plugin hooks into WordPress's built-in `script_loader_src` and `style_loader_src` filters and silently removes all query string parameters from your CSS and JS URLs — on the frontend only. The WordPress admin dashboard is never affected.

No setup required. No settings page. Just install, activate, and you're done.

= Features =

* Removes all query string parameters from CSS and JS URLs (not just `?ver`)
* Works automatically on activation — no configuration needed
* Frontend-only — does not affect the WordPress admin area
* Extremely lightweight — zero impact on page generation time
* Compatible with all themes and plugins

[Learn more about Query Strings on Wikipedia](https://en.wikipedia.org/wiki/Query_string)

= Upgrade to Pro =

Get even faster load times and more advanced features with **Pro**! 

* **Advanced Caching & Compression**: Browser Caching with Customizable Cache Durations, GZIP Compression, Cache-Control Headers, Keep-Alive, and ETag Removal.
* **Code Minification**: Minify CSS, JS, and HTML, plus Delay JavaScript for a massive PageSpeed boost.
* **Media & Font Optimization**: Lazy Load Images & iFrames, and Google Fonts Optimization.
* **Database & Site Health**: Database Cleanup, DNS Prefetch, Preload Links, Heartbeat Control, and XML-RPC Disable.
* **WooCommerce Ready**: Built-in WooCommerce Optimization.
* **Settings Admin Page**: Easy-to-use interface to manage all features.
* **Premium Support & Updates**: Get fast, dedicated assistance and regular new features.

[Upgrade to Pro!](https://lbcache.com)

== Installation ==

There are three ways to install this plugin:

= Option 1: Install via WordPress Dashboard (Recommended) =

1. Go to **Dashboard > Plugins > Add New**.
2. Search for **WP Remove Query Strings From Static Resources**.
3. Click **Install Now**, then click **Activate**.
4. That's it — the plugin works immediately, no configuration needed.

= Option 2: Upload via WordPress Dashboard =

1. Download the plugin ZIP file from the [WordPress Plugin Repository](https://wordpress.org/plugins/wp-remove-query-strings-from-static-resources/).
2. Go to **Dashboard > Plugins > Add New > Upload Plugin**.
3. Choose the downloaded ZIP file and click **Install Now**.
4. Activate the plugin from the Plugins page.

= Option 3: Upload via FTP =

1. Download and extract the plugin ZIP file.
2. Upload the `wp-remove-query-strings-from-static-resources` folder to `/wp-content/plugins/` on your server.
3. Go to **Dashboard > Plugins**, find the plugin, and click **Activate**.

== Frequently Asked Questions ==

= Does this plugin have a settings page? =

No. This plugin works automatically as soon as you activate it. There are no settings to configure.

= Will it affect my WordPress admin dashboard? =

No. The plugin only runs on the frontend of your website. The admin dashboard is completely unaffected.

= Which query string parameters does it remove? =

It removes all query string parameters from CSS and JS URLs — including `?ver=`, `?v=`, `?timestamp=`, and any other parameters. It is not limited to just `?ver=`.

= Will this break my website? =

No. Removing query strings from static resources is a safe and widely recommended performance optimization. Your CSS and JS files will still load correctly.

= Does it work with caching plugins? =

Yes. It is compatible with all  caching plugins.

= Will it improve my PageSpeed or GTmetrix score? =

Yes. Tools like Google PageSpeed Insights, GTmetrix, Pingdom, and YSlow flag query strings on static resources as a performance issue. Removing them helps improve your score.

= I need support =

Please open a support topic on the [WordPress.org support forum](https://wordpress.org/support/plugin/wp-remove-query-strings-from-static-resources) and we will be happy to help.

== Screenshots ==

1. Code View

== Changelog ==

= 2.3 =
* Plugin check issues fixed
* Improved code

= 2.2 =
* Fixed: Replaced unsafe `strtok()` with `explode()` to prevent conflicts with other plugins and WordPress core loops.

= 2.0 =
* Improved: Removed unnecessary class property, filter callback now uses local variable
* Improved: Strip all query string parameters (not just ?ver and &ver)
* Improved: Plugin initialised via plugins_loaded hook for correct WP load order
* Added: Requires PHP header (7.4)
* Updated: Requires at least bumped to 5.0
* Updated: Tested up to 7.0
* Fixed: Typos and grammar in readme
* Updated: Readme rewritten for better clarity and SEO

= 1.8 =
* Remove additional class

= 1.7 =
* Added additional class

= 1.6 =
* Tested for WP 6.6

= 1.5 =
* Tested for WP 6.3

= 1.4 =
* Compatibility WP 6.0

= 1.3 =
* 23 Feb, 2019
* Text improved
* Increase Version

= 1.2 =
* 3 July, 2017
* Code improved

= 1.1 =
* 3 July, 2017
* Compatibility issue

= 1.0 =
* 29 June, 2017
* First Release

== Upgrade Notice ==

= 2.3 =
Major update: improved query string stripping to cover all parameters (not just ?ver), correct plugin load order via plugins_loaded hook, and a fully rewritten readme. Upgrade recommended for all users.
