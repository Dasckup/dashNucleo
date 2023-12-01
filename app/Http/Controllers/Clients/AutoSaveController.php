<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\AnsweredClientsFromAutosave;
use App\Models\ContactClientsFromAutoSave;
use App\Models\ClientsFromAutoSave;
use App\Models\TypesContact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ZapBoss;

class AutoSaveController extends Controller
{

    public function index(){
        $clients = ClientsFromAutoSave::where("status", "intention")->with("contacts")->orderBy("created_at","ASC")->get();

        return view('pages.client.autosave.index', [
            "clients" => $clients
        ]);
    }

    public function show(){
        $clients = AnsweredClientsFromAutosave::with("information")->with("contacts")->with("users")->orderBy("id","ASC")->get();

        return view('pages.client.autosave.answered.index', [
            'clients' => $clients
        ]);
    }

    public function update(Request $request, $id){
        $clients = ClientsFromAutoSave::where("id" , $id)->where("status", "intention")->first();

        if($clients){
            $clients->status = "is client";
            $clients->save();

            $clientsSaved = new AnsweredClientsFromAutosave();
            $clientsSaved->client = $id;
            $clientsSaved->user = Auth::user()->id;
            $clientsSaved->observation = $request->justification;
            $clientsSaved->save();
        }

        return redirect()->back();
    }


    public function updateContact(Request $request, $id){
        $clients = ClientsFromAutoSave::where("id" , $id)->where("status", "intention")->first();
        $user = User::where("id", $request->user)->first();
        $contactType = TypesContact::where("id", $request->type_contact)->first();

        if($clients && $user && $contactType){
            $clientsSaved = new ContactClientsFromAutoSave();
            $clientsSaved->user = $user->id;
            $clientsSaved->client = $id;
            $clientsSaved->type = $contactType->id;
            $clientsSaved->observation = $request->obs;
            $clientsSaved->date = $request->date;
            $clientsSaved->save();

            return response()->json([
                "status" => "success",
                "metadata" => [
                    "message" => $request->obs,
                    "type" => $contactType->name,
                    "date" => date("d/m/Y \á\s H:i", strtotime($request->date)),
                    "user" => $user->name
                ]
            ]);
        }

        return response()->json([
            "status" => "error"
        ]);
    }

    public function notContacted(){
        $clients = ClientsFromAutoSave::where("status", "intention")->with("contacts")->orderBy("created_at","ASC")->get();
        $clientsNotContacted = [];

        foreach($clients as $client){
            if(count($client->contacts) == 0){
                array_push($clientsNotContacted, $client);
            }
        }

        return view('pages.client.autosave.not_contacted.index', [
            "clients" => $clientsNotContacted
        ]);
    }

    public function notContactedShow(){
        $clients = ClientsFromAutoSave::where("status", "intention")->with("contacts")->orderBy("created_at","ASC")->get();
        $clientsNotContacted = [];

        foreach($clients as $client){
            if(count($client->contacts) == 0){
                array_push($clientsNotContacted, $client);
            }
        }

        return view('pages.client.autosave.not_contacted.index', [
            "clients" => $clientsNotContacted
        ]);
    }

    public function SendMessageToNotContacted(Request $request){

        $clientId = $request->client;
        $user = User::where("id", $request->user)->first();
        $name = ucwords(strtolower(explode(' ',$request->name)[0]));
        $message = "Boa tarde, $name!
Somos da *Revista Científica Multidisciplinar Núcleo Do Conhecimento*, percebemos que você iniciou uma submissão de artigo científico mas não finalizou, você deseja publicar um artigo científico?";

        $zapboss = new ZapBoss();
        $zapboss->to($request->cellphone);
        $zapboss->message($message);

        $response = $zapboss->send();

        $clientsSaved = new ContactClientsFromAutoSave();
        $clientsSaved->user = $user->id;
        $clientsSaved->client = $clientId;
        $clientsSaved->type = 5;
        $clientsSaved->observation = "Mensagem enviada automaticamente pelo sistema";
        $clientsSaved->date = date("Y-m-dTH:i");
        $clientsSaved->save();

        return response()->json([
            "status" => "success",
        ]);
    }


    public function send_message_to_client(){




    }


    public function returned(Request $request){
        $numero = str_replace('55','',$request->sender);
        $formatCell = "(" . substr($numero, 0, 2) . ") " . substr($numero, 2, 5) . "-" . substr($numero, 7);
        $intention = ClientsFromAutoSave::where("cellphone", $formatCell)->where("returned", false)->first();
        if($intention){
            $intention->returned = true;
            $intention->save();
        }
    }
}



