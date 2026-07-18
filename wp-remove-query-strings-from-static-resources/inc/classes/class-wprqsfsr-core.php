<?php
if (!defined('ABSPATH')) {
    exit;
}
final class Wprqsfsr_Core
{
    private string $siteHost;
    public function __construct()
    {
        $this->siteHost = strtolower((string) wp_parse_url(home_url('/'), PHP_URL_HOST));
        if (!is_admin()) {
            add_filter('script_loader_src', [$this, 'removeQueryString'], 15);
            add_filter('style_loader_src', [$this, 'removeQueryString'], 15);
        }
    }
    public function removeQueryString(string $source): string
    {
        $queryPosition = strpos($source, '?');
        if ($queryPosition === false) {
            return $source;
        }
        $isCss = $queryPosition >= 4
            && strcasecmp(substr($source, $queryPosition - 4, 4), '.css') === 0;
        $isJavaScript = $queryPosition >= 3
            && strcasecmp(substr($source, $queryPosition - 3, 3), '.js') === 0;
        if (!$isCss && !$isJavaScript) {
            return $source;
        }
        $resourceHost = wp_parse_url($source, PHP_URL_HOST);
        if ($resourceHost === false) {
            return $source;
        }
        if ($resourceHost !== null && strcasecmp((string) $resourceHost, $this->siteHost) !== 0) {
            return $source;
        }
        return substr($source, 0, $queryPosition);
    }
}
