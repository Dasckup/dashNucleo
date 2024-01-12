<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsProccess extends Model
{
    use HasFactory;

    protected $table = 'clients_proccess';

    public function author(){
        return $this->hasOne(RequestsClients::class, 'id', 'clients');
    }

    public function material_content(){
        return $this->hasOne(RequestsClientsMaterial::class, 'id', 'material')->with('file_last_version');
    }

    public function analysis(){
        return $this->hasMany(CommentsEditorsProccess::class , 'process', 'id')->where('response_to', NULL)->with('materials')->with('responses');
    }

    public function verdict(){
         return $this->hasOne(EditorsProccess::class, 'proccess_id', 'id');
    }
}


