<?php

namespace App\Http\Controllers\Alog;

use App\Http\Controllers\Controller;
use App\Models\Alog;
use Illuminate\Http\Request;

class AlogController extends Controller
{
    public function index()
    {
        $logs = Alog::orderBy("created_at" , "DESC")->limit(2000)->with('users')->get();

        return view('pages.alog.index', [
            'logs' => $logs
        ]);
    }
}
