<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;
use App\Models\GroceryItem;

class ListDetailController extends Controller
{
    public function show($id)
    {
        $list = ShoppingList::with('items')->find($id);

        if (!$list) {
            return view('lists.notfound');
        }

        $totalSpent = $list->items->sum(function($item) {
            return $item->price * $item->quantity;
        });

        return view('lists.detail', compact('list', 'totalSpent'));
    }

    public function addItem(Request $request, $listId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|string|max:255',
            'checked' => 'boolean',
        ]);

        $list = ShoppingList::findOrFail($listId);

        $item = new GroceryItem($request->all());
        $item->shopping_list_id = $list->id;
        $item->save();

        return redirect()->route('lists.show', $list->id)->with('success', 'Item added successfully!');
    }

    public function updateItem(Request $request, $listId, $itemId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|string|max:255',
            'checked' => 'boolean',
        ]);

        $item = GroceryItem::where('shopping_list_id', $listId)->findOrFail($itemId);
        $item->update($request->all());

        return redirect()->route('lists.show', $listId)->with('success', 'Item updated successfully!');
    }

    public function toggleCheck($listId, $itemId)
    {
        $item = GroceryItem::where('shopping_list_id', $listId)->findOrFail($itemId);
        $item->checked = !$item->checked;
        $item->save();

        return redirect()->route('lists.show', $listId);
    }

    public function deleteItem($listId, $itemId)
    {
        $item = GroceryItem::where('shopping_list_id', $listId)->findOrFail($itemId);
        $item->delete();

        return redirect()->route('lists.show', $listId)->with('success', 'Item removed from list');
    }

    public function deleteList($id)
    {
        $list = ShoppingList::findOrFail($id);
        $list->items()->delete();
        $list->delete();

        return redirect()->route('dashboard')->with('success', 'Shopping list deleted');
    }
}