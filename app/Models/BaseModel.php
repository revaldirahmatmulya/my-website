<?php

namespace App\Models;

if (!class_exists(BaseModel::class, false)) {
    if (env('DB_CONNECTION') === 'mongodb' || (function_exists('config') && config('database.default') === 'mongodb')) {
        class_alias(\MongoDB\Laravel\Eloquent\Model::class, BaseModel::class);
    } else {
        class_alias(\Illuminate\Database\Eloquent\Model::class, BaseModel::class);
    }
}
