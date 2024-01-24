<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClientsMaterial extends Model
{
    use HasFactory;

    // The name of the table has change from "requests_clients_material" to "requests_clients_article"
    protected $table = "requests_clients_article";

    public function clients(){
        return $this->hasOne(RequestsClients::class , "id" , "client")->with("submission")->with("status")->with("address")->with("document");
    }

    public function submissions(){
        return $this->hasOne(RequestsClientsSubmission::class , "client" , "client");
    }

    public function address(){
        return $this->hasOne(RequestsClientsAddress::class , "client" , "client");
    }

    public function file_last_version(){
        return $this->hasOne(RequestsClientsFiles::class , "clients" , "client")->orderBy('created_at', 'DESC');
    }

    public function file_all_version(){
        return $this->hasMany(RequestsClientsFiles::class , "clients" , "client")->with('users')->orderBy('created_at', 'DESC');
    }

    public function status(){
        return $this->hasOne(RequestClientsStatus::class , "id" , "article");
    }

    public function submission(){
        return $this->hasOne(RequestsClientsSubmission::class , 'client', 'client');
    }

    public function notes(){
        return $this->hasMany(RequestsClientsNotes::class , "article", "id")->orderBy('created_at', 'desc')->with('users');
    }
}
