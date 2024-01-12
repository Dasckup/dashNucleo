<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppModerators\Login\LoginController as Login;
use App\Http\Controllers\AppModerators\Home\HomeController as Home;
use App\Http\Controllers\AppModerators\Material\MaterialController as Material;

Route::controller(Login::class)->group(function (){
    Route::get('/moderator/login', 'index')->name("AppModerator.login.index");
    Route::post('/moderator/login', 'store')->name("AppModerator.login.store");
    Route::get('/moderator/logout', 'destroy')->name("AppModerator.login.destroy");
});

Route::middleware(['auth:moderatorAccess'])->group(function () {
    Route::controller(Home::class)->group(function (){
        Route::get('/moderator/home', 'index')->name("AppModerator.home");
    });

    Route::controller(Material::class)->group(function (){
        Route::get('/moderator/material/{id}', 'show')->name("AppModerator.material.show");
    });

});
