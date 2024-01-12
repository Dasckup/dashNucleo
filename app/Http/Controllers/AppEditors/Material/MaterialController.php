<?php

namespace App\Http\Controllers\AppEditors\Material;

use App\Http\Controllers\Controller;
use App\Models\ClientsProccess;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function show($id){

        $process = ClientsProccess::where('id', $id)->with('material_content')->with('verdict')->with('author')->with('analysis')->first();
        $process->deadline = date('d/m/Y', strtotime($process->created_at. ' + '.$process->deadline_amount.' '.$process->deadline_type));

        return view('editors.pages.material.show', [
            "process" => $process,
        ]);
    }
}
