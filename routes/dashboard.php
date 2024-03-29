<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\ClientsController as Clients;
use App\Http\Controllers\Home\HomeController as Home;
use App\Http\Controllers\Alog\AlogController as Alog;
use App\Http\Controllers\Login\LoginController as Login;
use App\Http\Controllers\User\UserController as Users;
use App\Http\Controllers\Clients\AutoSaveController as AutoSave;
use App\Http\Controllers\Events\EventsController as Events;
use App\Http\Controllers\Products\ProductsController as Products;
use Illuminate\Support\Facades\DB;
use App\Models\ClientsFromAutoSave;
use App\Models\RequestClientsStatus;
use App\Models\RequestsClients;
use App\Models\RequestsClientsMaterial;

Route::controller(Login::class)->group(function (){
    Route::get('/login', 'index')->name("login.index");
    Route::post('/login', 'store')->name("login.store");
    Route::get('/logout', 'destroy')->name("login.destroy");
});

Route::middleware(['auth:dashboard'])->group(function () {

    Route::get('/', [Home::class, 'index'])->name("home");
    Route::get('/log', [Alog::class, 'index'])->name("log");



    // ONLY ADMIN
    Route::controller(Clients::class)->group(function () {
        Route::get('/submissoes', 'index')->name("client.index");

        Route::post('/submissoes/consult/term', 'consult_term')->name("client.consult.term");

        $routsStatus = [
            'pendente',
            'atendidos',
            'pendencias',
            'aceitos',
            'pagas',
            'recusados',
            'pagamento_pendentes',
            'cancelados'
        ];

        foreach ($routsStatus as $status){
            Route::get('/submissoes/'.$status, 'index_'.$status)->name("client.index.".$status);
        }

        Route::post('/submissoes/get/count/all', 'getAllSubmissions')->name("client.count.all");

        Route::get('/submissoes/{id}/{status}', 'update')->name("client.update");
        Route::post('/submissoes/update_status/', 'updateStatus')->name("client.update.status");
        Route::post('/submissoes/update/submission/term', 'updateSubmissionTerm')->name("client.update.submission");

        Route::post('/submissoes/{id}/upload/material', 'uploadMaterial')->name("client.upload.material");

        Route::get('/submissoes/{id}/', 'show')->name("client.show");
        Route::post('/submissoes/article/{id}/new/note', 'store_note')->name("client.store.note");

        Route::get('/submissoes/form/send/whatsapp', 'send_message_to_client')->name("client.whatsapp");
        Route::post('/submissoes/form/send/whatsapp/api', 'send_message_to_client_api')->name("client.whatsapp.api");
    });

    Route::controller(Events::class)->group(function () {
        Route::get('/eventos', 'index')->name("events.index");
        Route::post('/eventos/new', 'store')->name("events.store");
        Route::get('/eventos/stop/{event}', 'stop')->name("events.stop");
        Route::get('/eventos/start/{event}', 'start')->name("events.start");
        Route::get('/eventos/editar/{event}', 'show')->name("events.show");
        Route::put('/eventos/salvar/{event}', 'update')->name("events.update");
    });

    Route::controller(AutoSave::class)->group(function (){
        Route::get('/intencao-de-submissao', 'index')->name("client.intention.index");
        Route::get('/intencao-de-submissao/atendidos', 'show')->name("client.intention.show");
        Route::get('/intencao-de-submissao/not-contacted/', 'notContacted')->name("client.intention.not_contacted");
        Route::post('/intencao-de-submissao/not-contacted/send-message', 'SendMessageToNotContacted')->name("client.intention.not_contacted.send_message");

        Route::post('/intencao-de-submissao/is-client/{id}', 'update')->name("client.intention.update");
        Route::post('/intencao-de-submissao/contact/{id}', 'updateContact')->name("client.intention.update.contact");
    });

    Route::controller(Users::class)->group(function (){
        Route::get('/usuarios', 'index')->name("user.index")->middleware(['can.any:director,admin']);
        Route::post('/usuarios/novo', 'store')->name("user.store")->middleware(['can.any:director,admin']);
        Route::get('/usuarios/{id}', 'show')->name("user.show")->middleware(['can.any:director,admin']);

        Route::get('/perfil', 'profile')->name("profile.show");
        Route::post('/perfil/atualizar', 'update')->name("profile.update");
    });

    Route::controller(Products::class)->group(function () {
        Route::get('/produtos/todos', 'index')->name("products.index");
        Route::get('/produtos/novo', 'create')->name("products.create");
        Route::post('/produtos/novo', 'store')->name("products.store");
        Route::get('/produtos/editar/{product}', 'edit')->name("products.edit");
        Route::put('/produtos/editar/{product}', 'update')->name("products.update");
    });

});


// Not Login
Route::controller(Clients::class)->group(function () {
    Route::get('/submissoes/form/send/whatsapp/autosend', 'sendMessageToNewClient');
    Route::get('/submissoes/form/send/whatsapp/autosend/secondday', 'sendMessageToNewClientSecondTime');
});

Route::controller(Events::class)->group(function () {
    Route::get('/eventos/submit/', 'submit')->name("events.submit");
});


