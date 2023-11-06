<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsFromAutoSave extends Model
{
    use HasFactory;

    protected $table = "clients_from_autosave";


    protected $casts = [
        "id" => "string",
    ];

    public function contacts(){
        return $this->hasMany(ContactClientsFromAutoSave::class, "client", "id")->with("users");
    }

    public function users(){
        return $this->hasOne(User::class, 'id', 'user');
    }
}
