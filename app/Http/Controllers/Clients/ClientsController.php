<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Cryptography;
use App\Models\Alog;
use App\Models\RequestClientsStatus;
use App\Models\RequestsClients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index(){

        $clients = RequestsClients::with("submission")->with("status")->orderBy("created_at","DESC")->get();

        return view('pages.client.index', [
            "clients" => $clients
        ]);
    }

    public function update($id,$status){

        if(!Auth::check() || !Auth::user()["id"])
                return redirect()->route("login.index");

        $client = RequestClientsStatus::where("client", $id)->first();

        if(!$client){
            return redirect()->route("client.index");
        }

        switch ($status){
            case "pendente":
                $status = [
                    "status" => "pendente",
                    "bs" => "warning"
                ];
            break;
            case "cancelado":
                $status = [
                    "status" => "cancelado",
                    "bs" => "danger"
                ];
            break;
            case "pago":
                $status = [
                    "status" => "pago",
                    "bs" => "success"
                ];
            break;
            default:
                $status = [
                    "status" => "atendido",
                    "bs" => "success"
                ];
            break;
        }

        $saveInLog = new Alog();
        $saveInLog->user = Auth::user()["id"];
        $saveInLog->message = "Alterou o status do cliente [#".$id."] de: ".$client->status." para: ".$status["status"];
        $saveInLog->ip = $_SERVER['REMOTE_ADDR'];
        $saveInLog->save();

        $client->status = $status["status"];
        $client->bs = $status["bs"];
        $client->save();

        return redirect()->route("client.index");
    }


    public function show($id){
        if(!Auth::user()){
            return redirect()->route("login.index");
        }

        $client = RequestsClients::where("id", $id)->with("material")->with("submission")->with("address")->with("status")->first();

        if(!$client){
            return redirect()->route("client.index")->withErrors(["error" => "Cliente não econtrado e/ou desativado"]);
        }

        return view('pages.client.show', [
            "client" => $client
        ]);
    }
}
