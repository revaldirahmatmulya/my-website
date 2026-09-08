<?php

namespace App\Models;

if (!class_exists(BaseModel::class, false)) {
    $isMongo = (getenv('DB_CONNECTION') === 'mongodb')
        || (isset($_ENV['DB_CONNECTION']) && $_ENV['DB_CONNECTION'] === 'mongodb')
        || (function_exists('app') && app()->bound('config') && config('database.default') === 'mongodb');

    if ($isMongo) {
        class_alias(\MongoDB\Laravel\Eloquent\Model::class, BaseModel::class);
    } else {
        class_alias(\Illuminate\Database\Eloquent\Model::class, BaseModel::class);
    }
}
