<?php

namespace App\Http\Controllers;

use App\Enums\CategorieDepense;
use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepenseController extends Controller
{
    public function index(Request $request): View
    {
        $depenses = Depense::query()
            ->whereHas('recu', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('recu');

        if ($request->filled('categorie')) {
            $depenses->where('categorie', $request->categorie);
        }

        if ($request->filled('search')) {
            $depenses->where('libelle', 'like', '%'.$request->search.'%');
        }

        $sortField = in_array($request->sort, ['libelle', 'quantite', 'prix_unitaire', 'categorie'])
            ? $request->sort
            : 'created_at';

        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

        $depenses->orderBy($sortField, $sortDirection);

        return view('depenses.index', [
            'depenses' => $depenses->paginate(15)->withQueryString(),
            'categories' => CategorieDepense::cases(),
        ]);
    }
}
