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
            $totalLivestock        = Livestock::where('user_id', (string) $user->id)->count();
            $totalOwners           = Owner::where('user_id', (string) $user->id)->count();
            $vaccinationsThisMonth = Vaccination::where('user_id', (string) $user->id)
                                        ->whereMonth('date_given', now()->month)->count();
            $recentTrades          = Trade::where('user_id', (string) $user->id)->latest()->take(5)->get();
            $overdueVaccines       = Vaccination::where('user_id', (string) $user->id)
                                        ->where('next_due_date', '<', now())->get();
            $upcomingVaccines      = Vaccination::where('user_id', (string) $user->id)
                                        ->whereBetween('next_due_date', [now(), now()->addDays(7)])->get();
        }

        // Enrich trades with owner names and animal tag
        $recentTrades = $recentTrades->map(function($trade) {
            $trade->from_owner_name = optional(Owner::find($trade->from_owner_id))->name ?? $trade->from_owner_id;
            $trade->to_owner_name   = optional(Owner::find($trade->to_owner_id))->name ?? $trade->to_owner_id;
            $trade->animal_tag      = optional(Livestock::find($trade->livestock_id))->tag_number ?? $trade->livestock_id;
            return $trade;
        });

        // Enrich overdue vaccines with animal tag
        $overdueVaccines = $overdueVaccines->map(function($v) {
            $v->animal_tag = optional(Livestock::find($v->livestock_id))->tag_number ?? $v->livestock_id;
            return $v;
        });

        $upcomingVaccines = $upcomingVaccines->map(function($v) {
            $v->animal_tag = optional(Livestock::find($v->livestock_id))->tag_number ?? $v->livestock_id;
            return $v;
        });

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