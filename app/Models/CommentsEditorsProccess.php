<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsEditorsProccess extends Model
{
    use HasFactory;

    protected $table = 'comments_editors_proccess';

    public function responses(){
        return $this->hasMany(CommentsEditorsProccess::class , 'response_to', 'id')->with('materials')->with('responses');
    }

    public function materials(){
        return $this->hasMany(CommentsEditorsProccessUpload::class, 'comments', 'id');
    }
}
