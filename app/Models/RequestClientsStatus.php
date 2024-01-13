<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestClientsStatus extends Model
{
    use HasFactory;
    protected $table = "requests_clients_status";

    public function clients(){
        return $this->hasOne(RequestsClients::class, "id", "client")->with("submission")->with("status");
    }

    public function material(){
        return $this->hasOne(RequestsClientsMaterial::class, "id", "article")->with("clients");
    }
}
