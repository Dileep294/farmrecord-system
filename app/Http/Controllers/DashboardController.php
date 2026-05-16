<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use App\Models\Owner;
use App\Models\Vaccination;
use App\Models\Trade;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->canSeeAllData()) {
            $totalLivestock        = Livestock::count();
            $totalOwners           = Owner::count();
            $vaccinationsThisMonth = Vaccination::whereMonth('date_given', now()->month)->count();
            $recentTrades          = Trade::latest()->take(5)->get();
            $overdueVaccines       = Vaccination::where('next_due_date', '<', now())->get();
            $upcomingVaccines      = Vaccination::whereBetween('next_due_date', [now(), now()->addDays(7)])->get();
        } else {
            $totalLivestock        = Livestock::where('user_id', $user->id)->count();
            $totalOwners           = Owner::where('user_id', $user->id)->count();
            $vaccinationsThisMonth = Vaccination::where('user_id', $user->id)
                                        ->whereMonth('date_given', now()->month)->count();
            $recentTrades          = Trade::where('user_id', $user->id)->latest()->take(5)->get();
            $overdueVaccines       = Vaccination::where('user_id', $user->id)
                                        ->where('next_due_date', '<', now())->get();
            $upcomingVaccines      = Vaccination::where('user_id', $user->id)
                                        ->whereBetween('next_due_date', [now(), now()->addDays(7)])->get();
        }

        return view('dashboard.index', compact(
            'totalLivestock',
            'totalOwners',
            'vaccinationsThisMonth',
            'recentTrades',
            'overdueVaccines',
            'upcomingVaccines'
        ));
    }
}
