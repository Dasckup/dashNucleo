<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestClientsStatus;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){

        $thisMonth = RequestClientsStatus::whereBetween('created_at', [now()->startOfMonth(), now()]);

        return view('pages.home.index', [
            'pending_review_count' => [
                'total' => RequestClientsStatus::where('status', 'pendente')->count(),
                'currentMonth' => $thisMonth->where('status', 'pendente')->count(),
            ],
            'submissions_accept' => [
                'total' => RequestClientsStatus::where('status', 'aceito')->count(),
                'currentMonth' => $thisMonth->where('status', 'aceito')->count(),
            ],
            'submission_refused' => [
                'total' => RequestClientsStatus::where('status', 'recusado')->count(),
                'currentMonth' => $thisMonth->where('status', 'recusado')->count(),
            ],
        ]);
    }
}
