<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proccess extends Model
{
    use HasFactory;
    protected $table = 'proccess';

    public function process_clients(){
        return $this->hasMany(ClientsProccess::class, 'on_process', 'id')->with('author');
    }
}
