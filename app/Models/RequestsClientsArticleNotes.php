<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClientsArticleNotes extends Model
{
    use HasFactory;

    protected $table = "requests_clients_article_notes";

    public function users(){
        return $this->hasOne(User::class , "id" , "user");
    }
}