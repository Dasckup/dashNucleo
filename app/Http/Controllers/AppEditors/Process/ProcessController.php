<?php

namespace App\Http\Controllers\AppEditors\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientsProccess;

class ProcessController extends Controller
{
    public function show($id){

        $process = ClientsProccess::where('id', $id)->with('material_content')->with('verdict')->with('author')->with('analysis')->first();
        $process->deadline = date('d/m/Y', strtotime($process->created_at. ' + '.$process->deadline_amount.' '.$process->deadline_type));


    }
}
