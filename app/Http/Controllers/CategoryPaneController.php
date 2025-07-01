<?php

namespace App\Http\Controllers;

use App\Models\CategoryPane;
use Illuminate\Http\Request;

class CategoryPaneController extends Controller
{
    public function index()
    {
        return CategoryPane::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        return CategoryPane::create($request->all());
    }

    public function show($id)
    {
        return CategoryPane::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $categoryPane = CategoryPane::findOrFail($id);

        $request->validate([
            'titre' => 'string|max:255',
            'description' => 'string'
        ]);

        $categoryPane->update($request->all());
        return $categoryPane;
    }

    public function destroy($id)
    {
        return CategoryPane::destroy($id);
    }





    public function indexx()
    {
        $categories = CategoryPane::latest()->paginate(10);
        return view('Categories.category_panes', compact('categories'));
    }

    public function createe()
    {
        return view('admin.category_panes.create');
    }

    public function storee(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255|unique:category_panes,titre',
            'description' => 'required|string'
        ]);

        CategoryPane::create($request->all());

        return redirect()->route('category-panes.index')
            ->with('success', 'Catégorie de panne créée avec succès');
    }

    public function showw(CategoryPane $categoryPane)
    {
        return view('admin.category_panes.show', compact('categoryPane'));
    }

    public function editt(CategoryPane $categoryPane)
    {
        return view('admin.category_panes.edit', compact('categoryPane'));
    }

    public function updatee(Request $request, CategoryPane $categoryPane)
    {
        $request->validate([
            'titre' => 'required|string|max:255|unique:category_panes,titre,'.$categoryPane->id,
            'description' => 'required|string'
        ]);

        $categoryPane->update($request->all());

        return redirect()->route('category-panes.index')
            ->with('success', 'Catégorie de panne mise à jour avec succès');
    }

    public function destroyy(CategoryPane $categoryPane)
    {
        $categoryPane->delete();

        return redirect()->route('category-panes.index')
            ->with('success', 'Catégorie de panne supprimée avec succès');
    }

    public function toggleVisibility(CategoryPane $categoryPane)
    {
        $categoryPane->update(['is_visible' => !$categoryPane->is_visible]);

        return back()->with('success', 'Visibilité de la catégorie mise à jour');
    }
}
