<?php

namespace App\Http\Controllers;

use App\Models\ClassificationPiece;
use Illuminate\Http\Request;

class ClassificationPieceController extends Controller
{
    public function index()
    {
        $classifications = ClassificationPiece::paginate(6);;
        return view('Categories.classificationPiece', compact('classifications'));
    }

    public function create()
    {
        return view('classificationPiece.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'classificationPrincipale' => 'required|string|max:255',
                'classificationSecondaire' => 'required|string|max:255',
                'isVisible' => 'sometimes|boolean'
            ]);

            ClassificationPiece::create($validated);

            return redirect()->route('classificationPiece.index')
                             ->with('success', 'Classification créée avec succès');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    public function show(ClassificationPiece $classificationPiece)
    {
        return view('classificationPiece.show', compact('classificationPiece'));
    }

    public function edit(ClassificationPiece $classificationPiece)
    {
        return view('classificationPiece.edit', compact('classificationPiece'));
    }

    public function update(Request $request, ClassificationPiece $classificationPiece)
    {
        $validated = $request->validate([
            'classificationPrincipale' => 'required|string|max:255',
            'classificationSecondaire' => 'required|string|max:255',
            'isVisible' => 'sometimes|boolean'
        ]);

        $classificationPiece->update($validated);

        return redirect()->route('classificationPiece.index')
                         ->with('success', 'Classification mise à jour avec succès');
    }

    public function destroy(ClassificationPiece $classificationPiece)
    {
        $classificationPiece->delete();

        return redirect()->route('classificationPiece.index')
                         ->with('success', 'Classification supprimée avec succès');
    }
}
