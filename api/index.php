<?php

declare(strict_types=1);

// Flag indicating we are running on Vercel Serverless
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Serverless /tmp writable directories setup
$tmpStoragePaths = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($tmpStoragePaths as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0755, true);
    }
}

// Default SQLite fallback in /tmp if not using external database
$dbConnection = getenv('DB_CONNECTION') ?: ($_ENV['DB_CONNECTION'] ?? 'sqlite');
if ($dbConnection === 'sqlite') {
    $dbPath = getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? '/tmp/database.sqlite');
    putenv("DB_DATABASE={$dbPath}");
    $_ENV['DB_DATABASE'] = $dbPath;
    $_SERVER['DB_DATABASE'] = $dbPath;

    if (!file_exists($dbPath)) {
        $bundledDb = __DIR__ . '/../database/database.sqlite';
        if (file_exists($bundledDb)) {
            @copy($bundledDb, $dbPath);
        } else {
            @touch($dbPath);
        }
    }
}

// Forward request to Laravel public/index.php
require __DIR__ . '/../public/index.php';
