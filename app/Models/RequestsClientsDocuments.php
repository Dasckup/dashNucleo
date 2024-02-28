<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClientsDocuments extends Model
{
    use HasFactory;

    public function clients(){
        return $this->hasOne(RequestsClients::class, "id", "client");
    }
}
