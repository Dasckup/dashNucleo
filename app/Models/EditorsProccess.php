<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorsProccess extends Model
{
    use HasFactory;
    protected $table = 'editors_proccess';

    public function client(){
        return $this->hasOne(ClientsProccess::class, 'id', 'proccess_id')
                    ->with('material_content')
                    ->with('analysis')
                    ->with('verdict');
    }
}
