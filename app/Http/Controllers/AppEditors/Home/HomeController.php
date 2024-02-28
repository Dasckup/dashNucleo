<?php

namespace App\Http\Controllers\AppEditors\Home;

use App\Http\Controllers\Controller;
use App\Models\RequestsClients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EditorsProccess;

class HomeController extends Controller
{
    public function index(){
        $userId = auth('editorAccess')->user()->id;

        $processes = EditorsProccess::where(function($query) use ($userId) {
            $query->where('editor_a', $userId)
                    ->orWhere('editor_b', $userId);
        })
        ->with('client')
        ->get()
        ->groupBy(function($process) use ($userId) {
            $result = null;
            if($process->editor_a == $userId){
                $result = $process->result_editor_a;
            }else{
                $result = $process->result_editor_b;
            }
            switch($result){
                case null:
                    return "warning";
                case 0:
                    return "danger";
                case 1:
                    return "success";
            }
        });
        return view('editors.pages.home.index', [
            "processes" => $processes,
        ]);
    }
}
