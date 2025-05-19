<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banque;
class BanqueController extends Controller
{

    public function index()
    {
        $banques = Banque::paginate(6);  // Pagination de 10 banque par page
        return view('Categories.banque', compact('banques'));
    }
    public function show(Banque $banque)
    {
        return view('banque.show', compact('banque'));
    }

        public function create()
        {
            return view('banque.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'nom_banque' => 'required|string|max:255|unique:banques',

            ]);

            Banque::create($request->all());

            return redirect()->route('banque.index')
                             ->with('success', 'banque créée avec succès');
        }

        public function edit(Banque $banque)
        {
            return view('banque.edit', compact('banque'));
        }

        public function update(Request $request, Banque $banque)
        {
            $request->validate([
                'nom_banque' => 'required|string|max:255|unique:banques,nom_banque,'.$banque->id,

            ]);

            $banque->update($request->all());

            return redirect()->route('banque.index')
                             ->with('success', 'banque mise à jour avec succès');
        }

        public function destroy(Banque $banque)
        {
            $banque->delete();

            return redirect()->route('banque.index')
                             ->with('success', 'banque supprimée avec succès');
        }
        public function toggleVisibility(Banque $banque)
    {
        $banque->update(['is_visible' => !$banque->is_visible]);

        return back()->with('success', 'Visibilité de la banque mise à jour');
    }
}
