<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppAuthors\Login\LoginController as Login;
use App\Http\Controllers\AppAuthors\Home\HomeController as Home;
use App\Http\Controllers\AppAuthors\Material\MaterialController as Material;
use App\Http\Controllers\AppAuthors\User\UserController as User;
use Illuminate\Support\Facades\App;

Route::controller(Login::class)->group(function (){
    Route::get('/author/login', 'index')->name("AppAuthor.login.index");
    Route::post('/author/login', 'store')->name("AppAuthor.login.store");
    Route::get('/author/logout', 'destroy')->name("AppAuthor.login.destroy");
});

Route::middleware(['auth:authorAccess'])->group(function () {
    Route::controller(Home::class)->group(function (){
        Route::get('/author', 'index')->name("AppAuthor.home");
    });

    Route::controller(User::class)->group(function (){
        Route::get('/author/profile', 'show')->name("AppAuthor.user.profile");
        Route::post('/author/profile/update', 'update')->name("AppAuthor.user.profile.update");

    });

    Route::controller(Material::class)->group(function (){
        Route::get('/author/material/{id}', 'show')->name("AppAuthor.material.show");
    });

    Route::get('/author/lang/{language}', function ($language) {
        if (! in_array($language, ['pt_BR','en', 'es', 'ru', 'de', 'it', 'fr'])) {
            abort(400);
        }

        setcookie("language_user", $language, time() + (365 * 24 * 60 * 60), "/");
        App::setLocale($language);
        return redirect()->route('AppAuthor.home');
    })->name('AppAuthor.lang.change');
});
