<?php

namespace App\Http\Controllers\AppAuthors\Material;

use App\Http\Controllers\Controller;
use App\Models\RequestsClientsMaterial;
use App\Models\RequestsClientsSubmission;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function show($id){

        $material = RequestsClientsMaterial::where('id', $id)->with('clients')->with('submissions')->first();


        return view('authors.pages.material.show', [
            "material" => $material,
        ]);
    }
}
