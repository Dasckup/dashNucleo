<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TypesContact;

class ContactClientsFromAutoSave extends Model
{
    use HasFactory;
    protected $table = "contact_clients_from_autosave";

    public function users(){
        return $this->hasOne(User::class, 'id', 'user');
    }

    public function types(){
        return $this->hasOne(TypesContact::class, 'id', 'type');
    }

}
