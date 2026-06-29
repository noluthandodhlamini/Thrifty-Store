<?php

if (!defined('CSS_VERSION')) {
    define('CSS_VERSION', '20260628b');
}

if (!defined('SITE_BASE')) {
    $documentRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '');
    $appRoot = str_replace('\\', '/', realpath(dirname(__DIR__)) ?: '');

    if ($documentRoot !== '' && $appRoot !== '' && str_starts_with($appRoot, $documentRoot)) {
        $siteBase = substr($appRoot, strlen($documentRoot));
    } else {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
        $dir = dirname($script);

        if (str_ends_with($dir, '/admin')) {
            $dir = dirname($dir);
        }

        $siteBase = ($dir === '/' || $dir === '.') ? '' : $dir;
    }

    define('SITE_BASE', rtrim($siteBase, '/'));
}

function asset_url($path)
{
    $path = str_replace('\\', '/', (string)$path);
    $path = ltrim($path, '/');

    if ($path === '') {
        return SITE_BASE === '' ? '/' : SITE_BASE . '/';
    }

    $segments = explode('/', $path);
    $encodedPath = implode('/', array_map('rawurlencode', $segments));

    if (SITE_BASE === '') {
        return '/' . $encodedPath;
    }

    return SITE_BASE . '/' . $encodedPath;
}

function site_url($path = '')
{
    $path = str_replace('\\', '/', (string)$path);
    $path = ltrim($path, '/');

    if ($path === '') {
        return SITE_BASE === '' ? '/' : SITE_BASE . '/';
    }

    if (SITE_BASE === '') {
        return '/' . $path;
    }

    return SITE_BASE . '/' . $path;
}
