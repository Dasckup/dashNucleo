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
}
