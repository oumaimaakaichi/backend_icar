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
}
