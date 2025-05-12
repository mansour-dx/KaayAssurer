<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Police;
use App\Models\Sinistre;
use App\Models\Paiement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'clientCount' => Client::count(),
            'activePolicesCount' => Police::where('statut', 'active')->count(),
            'pendingSinistresCount' => Sinistre::where('statut', 'en_attente')->count(),
            'monthlyPaymentsCount' => Paiement::whereMonth('date_paiement', Carbon::now()->month)
                                    ->whereYear('date_paiement', Carbon::now()->year)
                                    ->count(),
            'recentPolices' => Police::with('client')->latest()->take(5)->get(),
            'recentSinistres' => Sinistre::with('police')->latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
