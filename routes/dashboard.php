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
use App\Http\Controllers\Author\AuthorController as Author;
use Illuminate\Support\Facades\DB;
use App\Models\ClientsFromAutoSave;
use App\Models\RequestClientsStatus;
use App\Models\RequestClientsStatus2;
use App\Models\RequestsClients;
use App\Models\RequestsClientsArticleFiles;
use App\Models\RequestsClientsDescription;
use App\Models\RequestsClientsFiles;
use App\Models\RequestsClientsMaterial;
use App\Models\RequestsClientsSubmission;
use App\Models\Status;

Route::controller(Login::class)->group(function (){
    Route::get('/login', 'index')->name("login.index");
    Route::post('/login', 'store')->name("login.store");
    Route::get('/logout', 'destroy')->name("login.destroy");
});

Route::middleware(['auth:dashboard'])->group(function () {

    Route::get('/', [Home::class, 'index'])->name("home");
    Route::get('/log', [Alog::class, 'index'])->name("log");

    Route::controller(Author::class)->group(function () {
        Route::get('/autores', [Author::class, 'index'])->name("author.index");

        Route::get('/autores/novo', [Author::class, 'create'])->name("author.create");
        Route::post('/autores/novo', [Author::class, 'store'])->name("author.store");
        Route::post('/autores/{id}/novo/note', [Author::class, 'store__note'])->name("author.store.note");

        Route::get('/autor/{id}', [Author::class, 'show'])->name("author.show");
        Route::put('/autor/{id}', [Author::class, 'show'])->name("author.update");
        Route::put('/autor/{id}/update/information', [Author::class, 'update__information'])->name("author.update.information");
        Route::put('/autor/{id}/update/address', [Author::class, 'update__address'])->name("author.update.address");
        Route::put('/autor/{id}/update/documentation', [Author::class, 'update__documentation'])->name("author.update.documentation");


        Route::delete('/autor/{id}/disable', [Author::class, 'destroy'])->name("author.destroy");
        Route::put('/autor/{id}/enable', [Author::class, 'enable'])->name("author.enable");

        Route::post('/autores/{id}/upload', [Author::class, 'upload'])->name("author.upload");
    });

    Route::controller(Clients::class)->group(function () {
        Route::post('/submissions/consult/term', 'consult_term')->name("client.consult.term");

        Route::get('/submissions/{status}', 'index')->name("client.index");

        Route::post('/submissions/get/count/all', 'getAllSubmissions')->name("client.count.all");
        Route::post('/submissions/{client}/change/document/status', 'ChangeDocumentStatus')->name("client.change.document.status");

        Route::get('/submissions/{id}/{status}', 'update')->name("client.update");
        Route::post('/submissions/update_status/', 'updateStatus')->name("client.update.status");
        Route::post('/submissions/update_status/canceled', 'updateStatusCanceled')->name("client.update.canceled");
        Route::post('/submissions/update/submission/term', 'updateSubmissionTerm')->name("client.update.submission");

        Route::post('/submissions/{id}/upload/material', 'uploadMaterial')->name("client.upload.material");
        Route::post('/submissions/{id}/remove/material', 'removeMaterialFile')->name("client.remove.article.file");

        Route::get('/submission/{id}/', 'show')->name("client.show");
        Route::post('/submissions/article/{id}/new/note', 'store_note')->name("client.store.note");

        Route::get('/submissions/form/send/whatsapp', 'send_message_to_client')->name("client.whatsapp");
        Route::post('/submissions/form/send/whatsapp/api', 'send_message_to_client_api')->name("client.whatsapp.api");
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
        Route::get('/intencao-de-submissao/todos', 'indexAll')->name("client.intention.index.all");
        Route::get('/intencao-de-submissao/atendidos', 'show')->name("client.intention.show");
        Route::get('/intencao-de-submissao/not-contacted/', 'notContacted')->name("client.intention.not_contacted");
        Route::post('/intencao-de-submissao/not-contacted/send-message', 'SendMessageToNotContacted')->name("client.intention.not_contacted.send_message");

        Route::post('/intencao-de-submissao/is-client/{id}', 'update')->name("client.intention.update");
        Route::post('/intencao-de-submissao/contact/{id}', 'updateContact')->name("client.intention.update.contact");
    });

    Route::controller(Users::class)->group(function (){
        Route::get('/usuarios', 'index')->name("user.index")->middleware(['can.any:director,admin']);
        Route::post('/usuarios/novo', 'store')->name("user.store")->middleware(['can.any:director,admin']);
        Route::put('/usuarios/{id}/update', 'update')->name("user.update")->middleware(['can.any:director,admin']);
        Route::get('/usuarios/{id}', 'show')->name("user.show")->middleware(['can.any:director,admin']);
        Route::post('/usuarios/change/status', 'changeStatus')->name("user.changeStatus")->middleware(['can.any:director,admin']);

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


Route::get('/teste', function () {
    $clients = RequestsClientsMaterial::orderBy('created_at', 'desc')
    ->limit(100)
    ->with('file_all_version')
    ->get();

    if(count($clients) < 1){
        echo "Nenhum cliente encontrado";
        return;
    }

    foreach($clients as $client){

        if(count($client->file_all_version) > 0){
            echo $client->client." - ".$client->file_all_version->first()->id."<br/><br/>";
            continue;
        }

        try{

            $extension = explode(".", $client->name_material);

            $file = new RequestsClientsArticleFiles();
            $file->article = $client->id;
            $file->clients = $client->client;
            $file->url_material = $client->url_material;
            $file->label = $client->name_material;
            $file->size_material = $client->size_material;
            $file->extension = end($extension);
            $file->version = 0;
            $file->save();


        }catch(\Exception $e){
            echo $e->getMessage()."<br/><br/>";
            continue;
        }
    }
});


// Not Login
Route::controller(Clients::class)->group(function () {
    Route::get('/submissions/form/send/whatsapp/autosend', 'sendMessageToNewClient');
    Route::get('/submissions/form/send/whatsapp/autosend/secondday', 'sendMessageToNewClientSecondTime');
});

Route::controller(Events::class)->group(function () {
    Route::get('/eventos/submit/', 'submit')->name("events.submit");
});
