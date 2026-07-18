<?php
define('ABSPATH', __DIR__);
$GLOBALS['wprqsfsr_admin'] = false;
$GLOBALS['wprqsfsr_filters'] = [];
function is_admin(): bool
{
    return $GLOBALS['wprqsfsr_admin'];
}
function add_filter(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): bool
{
    $GLOBALS['wprqsfsr_filters'][$hook] = [$callback, $priority, $acceptedArgs];
    return true;
}
function home_url(string $path = ''): string
{
    return 'https://example.com' . $path;
}
function wp_parse_url(string $url, int $component = -1): string|int|array|false|null
{
    if (str_starts_with($url, '//')) {
        $url = 'https:' . $url;
    }
    return parse_url($url, $component);
}
require_once __DIR__ . '/../wp-remove-query-strings-from-static-resources/inc/classes/class-wprqsfsr-core.php';
$filter = new Wprqsfsr_Core();
$tests = [
    ['https://example.com/app.css?ver=1', 'https://example.com/app.css'],
    ['https://example.com/app.CSS?ver=1', 'https://example.com/app.CSS'],
    ['https://EXAMPLE.COM/app.js?v=2', 'https://EXAMPLE.COM/app.js'],
    ['//example.com/app.js?ver=1', '//example.com/app.js'],
    ['/wp-content/app.css?ver=1', '/wp-content/app.css'],
    ['wp-content/app.js?ver=1', 'wp-content/app.js'],
    ['https://cdn.example.net/app.css?ver=1', 'https://cdn.example.net/app.css?ver=1'],
    ['https://example.com/app.php?ver=1', 'https://example.com/app.php?ver=1'],
    ['https://example.com/app.css', 'https://example.com/app.css'],
    ['https://example.com/app.css?ver=1#fragment', 'https://example.com/app.css'],
];
foreach ($tests as [$source, $expected]) {
    $actual = $filter->removeQueryString($source);
    if ($actual !== $expected) {
        fwrite(STDERR, "FAIL: {$source}
Expected: {$expected}
Actual: {$actual}
");
        exit(1);
    }
}
if (count($GLOBALS['wprqsfsr_filters']) !== 2) {
    fwrite(STDERR, "FAIL: expected two WordPress filters.
");
    exit(1);
}
final class LegacyFilter
{
    public function removeQueryString(string $source): string
    {
        if (strpos($source, '?') !== false) {
            $path = (string) wp_parse_url($source, PHP_URL_PATH);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            if (in_array(strtolower($extension), ['css', 'js'], true)) {
                $sourceHost = wp_parse_url($source, PHP_URL_HOST);
                $siteHost = wp_parse_url(home_url(), PHP_URL_HOST);
                if (empty($sourceHost) || $sourceHost === $siteHost) {
                    $source = explode('?', $source)[0];
                }
            }
        }
        return $source;
    }
}
$legacy = new LegacyFilter();
$sources = [
    'https://example.com/app.css?ver=1',
    'https://example.com/app.CSS?ver=1',
    'https://example.com/app.js?v=2',
    '//example.com/app.js?ver=1',
    '/wp-content/app.css?ver=1',
    'wp-content/app.js?ver=1',
    'https://cdn.example.net/app.css?ver=1',
    'https://example.com/app.php?ver=1',
    'https://example.com/app.css',
    'https://example.com/app.css?ver=1#fragment',
];
$iterations = 100000;
$benchmark = static function (callable $callback) use ($sources, $iterations): array {
    $checksum = 0;
    $start = hrtime(true);
    for ($iteration = 0; $iteration < $iterations; $iteration++) {
        foreach ($sources as $source) {
            $checksum += strlen($callback($source));
        }
    }
    return [(hrtime(true) - $start) / 1000000, $checksum];
};
for ($iteration = 0; $iteration < 1000; $iteration++) {
    $filter->removeQueryString($sources[$iteration % count($sources)]);
    $legacy->removeQueryString($sources[$iteration % count($sources)]);
}
[$optimizedMilliseconds, $optimizedChecksum] = $benchmark([$filter, 'removeQueryString']);
[$legacyMilliseconds, $legacyChecksum] = $benchmark([$legacy, 'removeQueryString']);
if ($optimizedChecksum !== $legacyChecksum) {
    fwrite(STDERR, "FAIL: benchmark implementations produced different results.
");
    exit(1);
}
$ratio = $legacyMilliseconds / $optimizedMilliseconds;
printf("PASS: %d behavioural cases
", count($tests));
printf("Optimized: %.2f ms
", $optimizedMilliseconds);
printf("Legacy: %.2f ms
", $legacyMilliseconds);
printf("Speed ratio: %.2fx
", $ratio);
if ($optimizedMilliseconds > $legacyMilliseconds * 1.10) {
    fwrite(STDERR, "FAIL: optimized implementation is slower than the legacy implementation.
");
    exit(1);
}
