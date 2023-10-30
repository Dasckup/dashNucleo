<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ClientsFromAutoSave;
use Illuminate\Http\Request;

class AutoSaveController extends Controller
{

    public function index(){
        $clients = ClientsFromAutoSave::where("status", "intention")->orderBy("id","DESC")->get();

        return view('pages.client.autosave.index', [
            "clients" => $clients
        ]);
    }

    public function update($id){
        $clients = ClientsFromAutoSave::where("id" , $id)->where("status", "intention")->first();

        if($clients){
            $clients->status = "is client";
            $clients->save();
        }

        return redirect()->back();
    }


}
