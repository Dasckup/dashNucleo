<?php

namespace App\Http\Controllers\AppModerators\Home;

use App\Http\Controllers\Controller;
use App\Models\RequestsClients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EditorsProccess;

class HomeController extends Controller
{
    public function index(){

        $processes = EditorsProccess::
        with('client')
        ->get();

        return view('moderator.pages.home.index', [
            "processes" => $processes,
        ]);
    }
}
