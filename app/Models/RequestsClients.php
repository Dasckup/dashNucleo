<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClients extends Model
{
    use HasFactory;

    public function submission(){
        return $this->hasOne(RequestsClientsSubmission::class , 'client', 'id');
    }

    public function status(){
        return $this->hasOne(RequestClientsStatus::class , 'client', 'id');
    }

    public function address(){
        return $this->hasOne(RequestsClientsAddress::class , 'client', 'id');
    }

    public function material(){
        return $this->hasOne(RequestsClientsMaterial::class, 'client', 'id');
    }
}
