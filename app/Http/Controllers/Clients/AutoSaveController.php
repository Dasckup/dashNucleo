<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\AnsweredClientsFromAutosave;
use App\Models\ClientsFromAutoSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoSaveController extends Controller
{

    public function index(){
        $clients = ClientsFromAutoSave::where("status", "intention")->orderBy("id","DESC")->get();

        return view('pages.client.autosave.index', [
            "clients" => $clients
        ]);
    }

    public function show(){
        $clients = AnsweredClientsFromAutosave::with("information")->with("users")->orderBy("id","DESC")->get();

        return view('pages.client.autosave.answered.index', [
            'clients' => $clients
        ]);
    }

    public function update(Request $request, $id){
        $clients = ClientsFromAutoSave::where("id" , $id)->where("status", "intention")->first();

        if($clients){
//            $clients->status = "is client";
//            $clients->save();

            $clientsSaved = new AnsweredClientsFromAutosave();
            $clientsSaved->client = $id;
            $clientsSaved->user = Auth::user()->id;
            $clientsSaved->observation = $request->justification;
            $clientsSaved->save();
        }

        return redirect()->back();
    }


}
