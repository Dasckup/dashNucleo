<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile(){
        $auth = Auth::user();
         return view('pages.user.show', [
             "auth" => $auth
         ]);
    }

    public function index(){
        $users = User::with('permissions')->get();
        return view('pages.user.index', [
            "users" => $users
        ]);
    }

    public function show(){
        return "";
    }

    public function create(){
        return "";
    }
}
