<?php

declare(strict_types=1);

// Flag indicating we are running on Vercel Serverless
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Provide fallback APP_KEY if missing in environment variables
if (empty(getenv('APP_KEY')) && empty($_ENV['APP_KEY'])) {
    $fallbackKey = 'base64:1crb4ggKg/KjO6AMe/3SND69UXCKe/0HaE0v4Qg5dEc=';
    putenv("APP_KEY={$fallbackKey}");
    $_ENV['APP_KEY'] = $fallbackKey;
    $_SERVER['APP_KEY'] = $fallbackKey;
}

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

// Redirect cache paths to writable /tmp
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';

putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
$_ENV['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

// Load composer autoloader early
require __DIR__ . '/../vendor/autoload.php';

// Dynamically filter package manifest to only include providers that exist in this vendor
$packages = [];
$packagesFile = __DIR__ . '/../bootstrap/cache/packages.php';

if (file_exists($packagesFile)) {
    $rawPackages = require $packagesFile;
    if (is_array($rawPackages)) {
        foreach ($rawPackages as $pkgName => $pkgConfig) {
            if (isset($pkgConfig['providers'])) {
                $validProviders = array_values(array_filter(
                    $pkgConfig['providers'],
                    fn ($cls) => class_exists($cls)
                ));
                if (!empty($validProviders)) {
                    $pkgConfig['providers'] = $validProviders;
                    $packages[$pkgName] = $pkgConfig;
                }
            }
        }
    }
}

file_put_contents(
    '/tmp/bootstrap/cache/packages.php',
    '<?php return ' . var_export($packages, true) . ';'
);

// Ensure services.php is freshly compiled by ProviderRepository in writable /tmp
if (file_exists('/tmp/bootstrap/cache/services.php')) {
    @unlink('/tmp/bootstrap/cache/services.php');
}

// Default SQLite fallback in /tmp if not using external database
$dbConnection = getenv('DB_CONNECTION') ?: ($_ENV['DB_CONNECTION'] ?? 'sqlite');
$needsSqliteInit = false;

if ($dbConnection === 'sqlite') {
    $dbPath = getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? '/tmp/database.sqlite');
    putenv("DB_DATABASE={$dbPath}");
    $_ENV['DB_DATABASE'] = $dbPath;
    $_SERVER['DB_DATABASE'] = $dbPath;

    if (!file_exists($dbPath) || filesize($dbPath) === 0) {
        $bundledDb = __DIR__ . '/../database/database.sqlite';
        if (file_exists($bundledDb) && filesize($bundledDb) > 0) {
            @copy($bundledDb, $dbPath);
        } else {
            @touch($dbPath);
            $needsSqliteInit = true;
        }
    }
}

try {
    define('LARAVEL_START', microtime(true));

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // Auto-migrate & seed SQLite on cold start if fresh
    if ($needsSqliteInit && isset($dbPath) && file_exists($dbPath) && filesize($dbPath) === 0) {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        } catch (\Throwable $migrationError) {
            error_log('Auto SQLite initialization: ' . $migrationError->getMessage());
        }
    }

    // Auto-seed MongoDB Atlas if connected and projects collection is empty
    if ($dbConnection === 'mongodb' && extension_loaded('mongodb')) {
        try {
            if (\App\Models\Project::count() === 0) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Throwable $mongoSeedError) {
            error_log('Auto MongoDB initialization: ' . $mongoSeedError->getMessage());
        }
    }

    $request = \Illuminate\Http\Request::capture();
    $response = $app->handleRequest($request);
    $response->send();
    $app->terminate();
} catch (\Throwable $e) {
    error_log('Vercel Laravel Bootstrap Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

    $isDebug = (getenv('APP_DEBUG') === 'true') || isset($_GET['debug']);

    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');

    if ($isDebug) {
        echo "<div style=\"font-family:sans-serif;padding:30px;background:#fef2f2;color:#991b1b;border:1px solid #f87171;margin:20px;border-radius:8px;\">";
        echo "<h2>Vercel Diagnostic Error</h2>";
        echo "<p><strong>Exception:</strong> " . get_class($e) . "</p>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
        echo "<h3>Stack Trace:</h3>";
        echo "<pre style=\"background:#fff;padding:15px;overflow:auto;font-size:12px;\">" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        echo "</div>";
    } else {
        echo "<div style=\"font-family:sans-serif;text-align:center;padding:50px;\">";
        echo "<h1>500 | Server Error</h1>";
        echo "<p>Something went wrong on the server. If you are the owner, add <code>?debug=1</code> to the URL to view diagnostic details.</p>";
        echo "</div>";
    }
}
