<?php

namespace App\Http\Middleware;
use App\Models\TypesContact as ModelsTypesContact;

class TypesContact{

    static public function get(){
        $types = ModelsTypesContact::where("active", true)->get();

        return $types;
    }
}
