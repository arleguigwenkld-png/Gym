<?php
// Central theme loader: exposes $theme array and $preview flag
// Usage: include __DIR__ . '/theme.php'; then echo CSS variables or read $theme['primary'] etc.

if (!isset($preview)) {
    $preview = isset($_GET['preview']) ? (int)$_GET['preview'] : 0;
}

if (!function_exists('hp_safe_hex')) {
    function hp_safe_hex($v, $fallback) {
        $v = isset($v) ? (string)$v : '';
        if (preg_match('/^#?[0-9A-Fa-f]{6}$/', $v)) {
            return (strpos($v, '#') === 0) ? $v : ('#' . $v);
        }
        return $fallback;
    }
}

$defaults = [ 'primary' => '#BA830F', 'secondary' => '#2B2B2B', 'accent' => '#ff9800' ];
$theme = $defaults;
$__theme_file = __DIR__ . '/site_theme.json';
if (is_file($__theme_file)) {
    $raw = @file_get_contents($__theme_file);
    $data = @json_decode($raw, true);
    if (is_array($data)) {
        foreach (['primary','secondary','accent'] as $k) {
            if (isset($data[$k])) {
                $theme[$k] = hp_safe_hex($data[$k], $defaults[$k]);
            }
        }
    }
}

// Apply preview overrides without mutating storage
if ($preview === 1) {
    $theme['primary'] = hp_safe_hex($_GET['primary'] ?? '', $theme['primary']);
    $theme['secondary'] = hp_safe_hex($_GET['secondary'] ?? '', $theme['secondary']);
    $theme['accent'] = hp_safe_hex($_GET['accent'] ?? '', $theme['accent']);
}

// Helper: echo CSS variable block
if (!function_exists('theme_css_vars')) {
    function theme_css_vars($theme) {
        echo ':root{--primary: ' . htmlspecialchars($theme['primary']) . '; --secondary: ' . htmlspecialchars($theme['secondary']) . '; --accent: ' . htmlspecialchars($theme['accent']) . ';}';
    }
}
