<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClientsArticleFiles extends Model
{
    use HasFactory;

    protected $table = 'requests_clients_article_files';

    public function users(){
        return $this->hasOne(User::class , 'id' , 'user');
    }
}