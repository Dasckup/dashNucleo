<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClientsFiles extends Model
{
    use HasFactory;

    protected $table = 'requests_clients_files';

    public function users(){
        return $this->hasOne(User::class , 'id' , 'user');
    }

}