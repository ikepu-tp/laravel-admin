<?php

use Illuminate\Support\Facades\Route;
use ikepu_tp\LaravelAdmin\app\Http\Controllers\UserController;
use ikepu_tp\LaravelAdmin\app\Http\Middleware\AdminMiddleware;

Route::group([
    "middleware" => [
        "web",
        "auth:" . config("laravelAdmin.gurad", "web"),
        AdminMiddleware::class,
    ],
    "prefix" => config("laravelAdmin.prefix", ""),
], function () {
    Route::resource("users", UserController::class)->names("laravelAdmin.user")->only(["index", "update"]);
});
