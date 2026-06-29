<?php

require_once __DIR__ . '/paths.php';

$host = $_SERVER['HTTP_HOST'] ?? '';
$isProduction = str_contains($host, 'infinityfreeapp.com')
    || str_contains($host, 'infinityfree.net');

if ($isProduction) {
    $conn = mysqli_connect(
        'sql306.infinityfree.com',
        'if0_42124175',
        'MiNahDhl983',
        'if0_42124175_db_name'
    );
} else {
    $conn = mysqli_connect(
        'localhost',
        'root',
        '',
        'thrift_store'
    );
}

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}
