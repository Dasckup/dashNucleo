<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppEditors\Login\LoginController as Login;
use App\Http\Controllers\AppEditors\Home\HomeController as Home;
use App\Http\Controllers\AppEditors\Material\MaterialController as Material;

Route::controller(Login::class)->group(function (){
    Route::get('/editor/login', 'index')->name("AppEditor.login.index");
    Route::post('/editor/login', 'store')->name("AppEditor.login.store");
    Route::get('/editor/logout', 'destroy')->name("AppEditor.login.destroy");
});

Route::middleware(['auth:editorAccess'])->group(function () {
    Route::controller(Home::class)->group(function (){
        Route::get('/editor/home', 'index')->name("AppEditor.home");
    });

    Route::controller(Material::class)->group(function (){
        Route::get('/editor/material/{id}', 'show')->name("AppEditor.material.show");
    });

});
