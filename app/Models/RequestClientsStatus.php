<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestClientsStatus extends Model
{
    use HasFactory;
    protected $table = "requests_clients_status";

    public function clients(){
        return $this->hasOne(RequestsClients::class, "id", "client")->with("submission");
    }

    public function material(){
        return $this->hasOne(RequestsClientsMaterial::class, "id", "article")->with("clients");
    }

    public function statusDetails(){
        return $this->hasOne(Status::class, "id", "status");
    }

    public function status2(){
        return $this->hasOne(RequestClientsStatus2::class, "id", "status");
    }

    public function notes(){
        return $this->hasMany(RequestsClientsArticleNotes::class, "article", "article");
    }

    public function files(){
        return $this->hasMany(RequestsClientsArticleFiles::class, "article", "article");
    }

    public function reasonCancellation(){
        return $this->hasOne(RequestsClientsStatusReasonsCancellation::class, 'article', 'article')->with("reasons");
    }
}
