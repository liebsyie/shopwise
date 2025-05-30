<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingList;

class EditListController extends Controller
{
    // Show the edit form
    public function edit($id)
    {
        $user = Auth::user();
        $list = $user->shoppingLists()->find($id);

        if (!$list) {
            return redirect()->route('dashboard')->with('error', 'List not found.');
        }

        return view('lists.edit', compact('list'));
    }

    // Handle the update form submission
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $list = $user->shoppingLists()->find($id);

        if (!$list) {
            return redirect()->route('dashboard')->with('error', 'List not found.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $list->update([
            'name' => $validated['name'],
            'budget' => $validated['budget'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Shopping list updated successfully.');
    }
}