<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewList; // Assuming you have this model for the lists

class NewListController extends Controller
{
    public function create()
    {
        return view('newlist.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'List name is required',
            'budget.required' => 'Budget is required',
            'budget.numeric' => 'Budget must be a number',
            'budget.min' => 'Budget must be a positive number',
        ]);

        NewList::create([
            'name' => $validated['name'],
            'budget' => $validated['budget'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'New list created successfully!');
    }
}