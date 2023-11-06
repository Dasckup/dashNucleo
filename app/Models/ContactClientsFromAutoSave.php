<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactClientsFromAutoSave extends Model
{
    use HasFactory;
    protected $table = "contact_clients_from_autosave";

    public function users(){
        return $this->hasOne(User::class, 'id', 'user');
    }
}
