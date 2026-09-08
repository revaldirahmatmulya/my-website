<?php

namespace App\Models;

if (!class_exists(AuthenticatableModel::class, false)) {
    if (env('DB_CONNECTION') === 'mongodb' || (function_exists('config') && config('database.default') === 'mongodb')) {
        class_alias(\MongoDB\Laravel\Auth\User::class, AuthenticatableModel::class);
    } else {
        class_alias(\Illuminate\Foundation\Auth\User::class, AuthenticatableModel::class);
    }
}
