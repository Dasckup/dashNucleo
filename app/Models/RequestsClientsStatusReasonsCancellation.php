<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClientsStatusReasonsCancellation extends Model
{
    use HasFactory;

    protected $table = 'requests_clients_status_reasons_cancellation';

    public function users(){
        return $this->hasOne(User::class , "id" , "user");
    }

    public function reasons(){
        return $this->hasOne(StatusReasonsCancellation::class , "id" , "reason");
    }
}
