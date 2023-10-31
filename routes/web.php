<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\ClientsController as Clients;
use App\Http\Controllers\Home\HomeController as Home;
use App\Http\Controllers\Alog\AlogController as Alog;
use App\Http\Controllers\Login\LoginController as Login;
use App\Http\Controllers\User\UserController as Users;
use App\Http\Controllers\Clients\AutoSaveController as AutoSave;


Route::controller(Login::class)->group(function (){
    Route::get('/login', 'index')->name("login.index");
    Route::post('/login', 'store')->name("login.store");
    Route::get('/logout', 'destroy')->name("login.destroy");
});

Route::middleware(['auth'])->group(function () {

    Route::get('/', [Home::class, 'index'])->name("home");
    Route::get('/log', [Alog::class, 'index'])->name("log");


    Route::controller(Clients::class)->group(function () {
        Route::get('/submissoes', 'index')->name("client.index");
        Route::get('/submissoes/{id}/{status}', 'update')->name("client.update");
        Route::get('/submissoes/{id}/', 'show')->name("client.show");
    });


    Route::controller(AutoSave::class)->group(function (){
        Route::get('/intencao-de-submissao', 'index')->name("client.intention.index");
        Route::get('/intencao-de-submissao/atendidos', 'show')->name("client.intention.show");
        Route::post('/intencao-de-submissao/is-client/{id}', 'update')->name("client.intention.update");
    });

    Route::controller(Users::class)->group(function (){
        Route::get('/perfil', 'show')->name("user.show");
    });

});

