<?php

namespace App\Http\Controllers\AppAuthors\Home;

use App\Http\Controllers\Controller;
use App\Models\Proccess;
use App\Models\Process;
use App\Models\RequestsClients;
use App\Models\RequestsClientsMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){

        $user = Auth::guard('authorAccess')->user();
        $clientSubmissions = RequestsClients::where("id", $user->clients)->with('submission')->with('address')->with('material')->get();
        $process  = Proccess::with('process_clients')->get();

        return view("authors.pages.home.index", [
            'processes' => $process
        ]);
    }
}


