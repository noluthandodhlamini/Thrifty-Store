<?php

if (!function_exists('asset_url')) {
    require_once __DIR__ . '/paths.php';
}

function normalizeImageKey($name)
{
    $name = pathinfo($name, PATHINFO_FILENAME);
    $name = strtolower($name);
    $name = preg_replace('/[^a-z0-9]+/', '', $name);

    return $name;
}

function getImageDirectoryMap()
{
    static $map = null;

    if ($map !== null) {
        return $map;
    }

    $map = [
        'exact' => [],
        'normalized' => [],
    ];

    $imagesDir = dirname(__DIR__) . '/assets/images/';

    if (!is_dir($imagesDir)) {
        return $map;
    }

    foreach (glob($imagesDir . '*') as $filePath) {
        if (!is_file($filePath)) {
            continue;
        }

        $file = basename($filePath);

        if ($file === 'placeholder.svg') {
            continue;
        }

        $map['exact'][strtolower($file)] = $file;
        $map['normalized'][normalizeImageKey($file)] = $file;
    }

    return $map;
}

function resolveProductImageFile($filename, $title = '')
{
    $map = getImageDirectoryMap();
    $candidates = [];

    if (!empty($filename)) {
        $filename = basename(str_replace('\\', '/', $filename));
        $candidates[] = $filename;
        $candidates[] = pathinfo($filename, PATHINFO_FILENAME);
    }

    if (!empty($title)) {
        $candidates[] = $title;
    }

    foreach ($candidates as $candidate) {
        $lower = strtolower($candidate);

        if (isset($map['exact'][$lower])) {
            return $map['exact'][$lower];
        }

        $key = normalizeImageKey($candidate);

        if ($key !== '' && isset($map['normalized'][$key])) {
            return $map['normalized'][$key];
        }
    }

    $titleKey = normalizeImageKey($title !== '' ? $title : ($filename ?? ''));

    if ($titleKey !== '') {
        $bestMatch = null;
        $bestLength = 0;

        foreach ($map['normalized'] as $fileKey => $file) {
            if (strlen($fileKey) < 4) {
                continue;
            }

            if (str_contains($titleKey, $fileKey) || str_contains($fileKey, $titleKey)) {
                if (strlen($fileKey) > $bestLength) {
                    $bestMatch = $file;
                    $bestLength = strlen($fileKey);
                }
            }
        }

        if ($bestMatch !== null) {
            return $bestMatch;
        }

        $words = preg_split('/[^a-z0-9]+/i', strtolower($title !== '' ? $title : ($filename ?? '')));
        $words = array_values(array_filter($words, static function ($word) {
            return strlen($word) >= 4;
        }));

        foreach ($words as $word) {
            $wordKey = normalizeImageKey($word);

            if ($wordKey === '') {
                continue;
            }

            foreach ($map['normalized'] as $fileKey => $file) {
                if (strlen($fileKey) < 4) {
                    continue;
                }

                if (str_contains($fileKey, $wordKey)) {
                    if (strlen($fileKey) > $bestLength) {
                        $bestMatch = $file;
                        $bestLength = strlen($fileKey);
                    }
                }
            }
        }

        if ($bestMatch !== null) {
            return $bestMatch;
        }
    }

    return null;
}

function getPlaceholderImageSrc()
{
    static $placeholder = null;

    if ($placeholder !== null) {
        return $placeholder;
    }

    $imagesDir = dirname(__DIR__) . '/assets/images/';
    $candidates = ['placeholder.png', 'placeholder.jpg', 'placeholder.jpeg', 'placeholder.svg'];

    foreach ($candidates as $file) {
        if (is_file($imagesDir . $file)) {
            $placeholder = asset_url('assets/images/' . $file);
            return $placeholder;
        }
    }

    $placeholder = 'data:image/svg+xml,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400">'
        . '<rect width="400" height="400" fill="#e9ecef"/>'
        . '<text x="200" y="210" text-anchor="middle" fill="#6c757d" font-family="Arial,sans-serif" font-size="18">No image</text>'
        . '</svg>'
    );

    return $placeholder;
}

function getProductImageSrc($filename, $title = '')
{
    $resolved = resolveProductImageFile($filename, $title);
    $imagesDir = dirname(__DIR__) . '/assets/images/';

    if ($resolved !== null && is_file($imagesDir . $resolved)) {
        return asset_url('assets/images/' . $resolved);
    }

    return getPlaceholderImageSrc();
}

function getSizeOptions()
{
    return [
        'XS' => 'XS',
        'S' => 'S',
        'M' => 'M',
        'L' => 'L',
        'XL' => 'XL',
        'XXL' => 'XXL',
        'UK 5' => 'UK 5',
        'UK 6' => 'UK 6',
        'UK 7' => 'UK 7',
        'UK 8' => 'UK 8',
        'UK 9' => 'UK 9',
        'UK 10' => 'UK 10',
        'UK 11' => 'UK 11',
        'One Size' => 'One Size',
        'N/A' => 'N/A',
    ];
}

function normalizeCartEntry($entry)
{
    if (is_array($entry)) {
        return [
            'product_id' => (int)($entry['product_id'] ?? 0),
            'size' => trim($entry['size'] ?? 'One Size'),
        ];
    }

    return [
        'product_id' => (int)$entry,
        'size' => 'One Size',
    ];
}
