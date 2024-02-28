<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alog extends Model
{
    use HasFactory;
    protected $table = "alog";

    public function users(){
        return $this->hasOne(User::class, 'id', 'user');
    }
}
