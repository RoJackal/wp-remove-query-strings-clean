# WP Remove Query Strings Clean

A non-commercial WordPress plugin fork maintained for [highproxies.com](https://highproxies.com) and [usrmagurele.ro](https://usrmagurele.ro).

Requires PHP 8.5 or newer. The plugin removes query strings from local CSS and JavaScript resource URLs while leaving external and non-static resources unchanged. It has no advertising, tracking, donation prompts, upgrade notices, commercial feature promotions, settings page, or third-party commercial integrations.

## Validation

GitHub Actions checks PHP 8.5 syntax, behavior, and comparative filtering performance on every pull request and push to `main`.

## Installation

1. Copy the `wp-remove-query-strings-from-static-resources` directory to `wp-content/plugins/`.
2. Activate **WP Remove Query Strings Clean** in WordPress.
3. Purge the WordPress, server, and CDN caches.

## Cache warning

Removing WordPress version query strings also removes their cache-busting effect. Purge every relevant cache after updating themes, plugins, CSS, or JavaScript.

## Licence and attribution

This fork is based on **WP Remove Query Strings From Static Resources** by Rinku Yadav and remains licensed under GPLv2 or later.
