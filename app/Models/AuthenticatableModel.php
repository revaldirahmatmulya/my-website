<?php

namespace App\Models;

if (!class_exists(AuthenticatableModel::class, false)) {
    $isMongo = (getenv('DB_CONNECTION') === 'mongodb')
        || (isset($_ENV['DB_CONNECTION']) && $_ENV['DB_CONNECTION'] === 'mongodb')
        || (function_exists('app') && app()->bound('config') && config('database.default') === 'mongodb');

    if ($isMongo) {
        class_alias(\MongoDB\Laravel\Auth\User::class, AuthenticatableModel::class);
    } else {
        class_alias(\Illuminate\Foundation\Auth\User::class, AuthenticatableModel::class);
    }
}
