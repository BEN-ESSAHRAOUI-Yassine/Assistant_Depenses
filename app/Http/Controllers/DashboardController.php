<?php

namespace App\Http\Controllers;

use App\Enums\StatutRecu;
use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'total_recus' => $user->recus()->count(),
            'traite' => $user->recus()->where('statut', StatutRecu::Traite)->count(),
            'en_attente' => $user->recus()->where('statut', StatutRecu::EnAttente)->count(),
            'echoue' => $user->recus()->where('statut', StatutRecu::Echoue)->count(),
            'total_estime' => $user->recus()->where('statut', StatutRecu::Traite)->sum('estimated_total'),
        ];

        $recentRecus = $user->recus()
            ->withCount('depenses')
            ->latest()
            ->limit(5)
            ->get();

        $categoryTotals = Depense::whereHas('recu', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->selectRaw('categorie, SUM(quantite * prix_unitaire) as total')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

        $categoryLabels = [
            'alimentaire' => 'Alimentaire',
            'boissons' => 'Boissons',
            'hygiene' => 'Hygiène',
            'entretien' => 'Entretien',
            'autre' => 'Autre',
        ];

        $chartCategories = [];
        $chartValues = [];

        foreach ($categoryLabels as $key => $label) {
            $value = (float) ($categoryTotals[$key] ?? 0);
            if ($value > 0) {
                $chartCategories[] = $label;
                $chartValues[] = $value;
            }
        }

        $months = [];
        $monthCounts = [];
        $monthTotals = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $label = $date->format('M Y');
            $months[] = $label;

            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            $monthData = $user->recus()
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->selectRaw('COUNT(*) as count, SUM(estimated_total) as total')
                ->first();

            $monthCounts[] = (int) ($monthData->count ?? 0);
            $monthTotals[] = (float) ($monthData->total ?? 0);
        }

        return view('dashboard', compact(
            'stats',
            'recentRecus',
            'chartCategories',
            'chartValues',
            'months',
            'monthCounts',
            'monthTotals',
        ));
    }
}
