<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnsweredClientsFromAutosave extends Model
{
    use HasFactory;
    protected $table = "answered_clients_from_autosave";

    public function information(){
        return $this->hasOne(ClientsFromAutoSave::class, 'id' , 'client' );
    }

    public function users(){
        return $this->hasOne(User::class, 'id', 'user');
    }
}
