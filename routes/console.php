<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mongodb:test', function () {
    $this->info('--- Testing MongoDB Atlas Connection ---');

    if (!extension_loaded('mongodb')) {
        $this->error('PHP MongoDB extension is NOT loaded.');
        return 1;
    }

    $uri = config('database.connections.mongodb.dsn');
    $dbName = config('database.connections.mongodb.database');

    if (empty($uri)) {
        $this->error('MONGODB_URI is not set in your environment / .env file.');
        return 1;
    }

    $maskedUri = preg_replace('/(?<=:\/\/)(.*?)(?=@)/', '***:***', (string) $uri);
    $this->line("Target URI : {$maskedUri}");
    $this->line("Database   : {$dbName}");

    try {
        $startTime = microtime(true);
        $connection = DB::connection('mongodb');
        $command = new \MongoDB\Driver\Command(['ping' => 1]);
        $connection->getMongoClient()->getManager()->executeCommand($dbName, $command);
        $duration = round((microtime(true) - $startTime) * 1000, 2);

        $this->info("SUCCESS: Successfully connected to MongoDB Atlas! (Response time: {$duration}ms)");

        $collections = iterator_to_array($connection->getMongoDB()->listCollectionNames());
        $this->line('Existing collections: ' . (empty($collections) ? '(none yet)' : implode(', ', $collections)));

        return 0;
    } catch (\Throwable $e) {
        $this->error('FAILED to connect to MongoDB Atlas: ' . $e->getMessage());
        return 1;
    }
})->purpose('Test connection to MongoDB Atlas');
