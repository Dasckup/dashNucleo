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
                    "bs" => "info"
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

        return redirect()->back();
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


    public function index_pendente(){

        $clients = RequestClientsStatus::where("status", "pendente")->with("clients")->orderBy("created_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "Pendentes",
                "bg" => "warning"
            ]
        ]);
    }
    public function index_atendido(){

        $clients = RequestClientsStatus::where("status", "atendido")->with("clients")->orderBy("created_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "Atendidas",
                "bg" => "info"
            ]
        ]);
    }
    public function index_pagas(){

        $clients = RequestClientsStatus::where("status", "pago")->with("clients")->orderBy("created_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "Pagas",
                "bg" => "success"
            ]
        ]);
    }
    public function index_cancelados(){

        $clients = RequestClientsStatus::where("status", "cancelado")->with("clients")->orderBy("created_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "Canceladas",
                "bg" => "danger"
            ]
        ]);
    }
}
